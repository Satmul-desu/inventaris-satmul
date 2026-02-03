<?php

namespace App\Http\Controllers\Admin;

use App\Models\Borrowing;
use App\Models\Item;
use App\Models\Notification;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Borrowing::with(['item', 'user']);

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('borrower_name', 'like', "%{$search}%")
                  ->orWhere('borrower_phone', 'like', "%{$search}%")
                  ->orWhereHas('item', function ($itemQuery) use ($search) {
                      $itemQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('code', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('borrow_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('borrow_date', '<=', $request->date_to);
        }

        $borrowings = $query->orderBy('created_at', 'desc')->paginate(10);
        $items = Item::orderBy('name')->get();

        return view('admin.borrowings.index', compact('borrowings', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::with(['unit'])->where('stock', '>', 0)->orderBy('name')->get();
        return view('admin.borrowings.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'borrower_name' => 'required|string|max:255',
            'borrower_phone' => 'nullable|string|max:20',
            'qty' => 'required|integer|min:1',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
            'note' => 'nullable|string',
        ]);

        // Check stock availability
        $item = Item::findOrFail($request->item_id);
        if ($item->stock < $request->qty) {
            return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $item->stock)
                ->withInput();
        }

        DB::transaction(function () use ($request, $item) {
            $previousStock = $item->stock;

            // Create borrowing record
            $borrowing = Borrowing::create([
                'item_id' => $request->item_id,
                'borrower_name' => $request->borrower_name,
                'borrower_phone' => $request->borrower_phone,
                'qty' => $request->qty,
                'borrow_date' => $request->borrow_date,
                'return_date' => $request->return_date,
                'status' => 'borrowed',
                'note' => $request->note,
                'user_id' => auth()->id(),
            ]);

            // Update item stock
            $item->decrement('stock', $request->qty);

            // Create stock log
            StockLog::create([
                'item_id' => $item->id,
                'action' => 'OUT',
                'qty' => -$request->qty,
                'previous_stock' => $previousStock,
                'current_stock' => $item->stock,
                'user_id' => auth()->id(),
                'description' => "Peminjaman: {$request->borrower_name}",
            ]);

            // Check for low stock notification
            if ($item->stock <= $item->min_stock) {
                Notification::create([
                    'item_id' => $item->id,
                    'type' => $item->stock <= 0 ? 'out_of_stock' : 'low_stock',
                    'message' => "Stok {$item->name} menipis akibat peminjaman. Sisa stok: {$item->stock}",
                ]);
            }
        });

        return redirect()->route('admin.borrowings.index')
            ->with('success', 'Peminjaman berhasil dicatat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['item.unit', 'user']);
        return view('admin.borrowings.show', compact('borrowing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $borrowing)
    {
        if (!in_array($borrowing->status, ['pending', 'borrowed'])) {
            return redirect()->route('admin.borrowings.index')
                ->with('error', 'Peminjaman yang sudah dikembalikan tidak dapat diubah.');
        }

        $items = Item::with(['unit'])->orderBy('name')->get();
        return view('admin.borrowings.edit', compact('borrowing', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        if (!in_array($borrowing->status, ['pending', 'borrowed'])) {
            return redirect()->route('admin.borrowings.index')
                ->with('error', 'Peminjaman yang sudah dikembalikan tidak dapat diubah.');
        }

        $request->validate([
            'item_id' => 'required|exists:items,id',
            'borrower_name' => 'required|string|max:255',
            'borrower_phone' => 'nullable|string|max:20',
            'qty' => 'required|integer|min:1',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
            'note' => 'nullable|string',
        ]);

        // Check stock if item changed
        $item = Item::findOrFail($request->item_id);
        if ($borrowing->item_id != $request->item_id) {
            if ($item->stock < $request->qty) {
                return back()->with('error', 'Stok tidak mencukupi untuk item yang dipilih. Stok tersedia: ' . $item->stock)
                    ->withInput();
            }
        }

        DB::transaction(function () use ($request, $borrowing, $item) {
            $oldQty = $borrowing->qty;
            $newQty = $request->qty;

            // Restore old stock if item changed
            if ($borrowing->item_id != $request->item_id) {
                $borrowing->item->increment('stock', $oldQty);
                StockLog::create([
                    'item_id' => $borrowing->item_id,
                    'action' => 'IN',
                    'qty' => $oldQty,
                    'previous_stock' => $borrowing->item->stock - $oldQty,
                    'current_stock' => $borrowing->item->stock,
                    'user_id' => auth()->id(),
                    'description' => 'Koreksi peminjaman: Perubahan item',
                ]);

                // Deduct new item stock
                $previousStock = $item->stock;
                $item->decrement('stock', $newQty);
                StockLog::create([
                    'item_id' => $item->id,
                    'action' => 'OUT',
                    'qty' => -$newQty,
                    'previous_stock' => $previousStock,
                    'current_stock' => $item->stock,
                    'user_id' => auth()->id(),
                    'description' => 'Peminjaman: ' . $request->borrower_name,
                ]);
            } elseif ($oldQty != $newQty) {
                // Stock adjustment for same item
                $stockDiff = $newQty - $oldQty;
                if ($stockDiff > 0) {
                    // Need more stock
                    if ($item->stock < $stockDiff) {
                        throw new \Exception('Stok tidak mencukupi untuk penambahan jumlah.');
                    }
                    $item->decrement('stock', $stockDiff);
                    StockLog::create([
                        'item_id' => $item->id,
                        'action' => 'OUT',
                        'qty' => -$stockDiff,
                        'previous_stock' => $item->stock + $stockDiff,
                        'current_stock' => $item->stock,
                        'user_id' => auth()->id(),
                        'description' => 'Koreksi peminjaman: Penyesuaian jumlah',
                    ]);
                } else {
                    // Return some stock
                    $item->increment('stock', abs($stockDiff));
                    StockLog::create([
                        'item_id' => $item->id,
                        'action' => 'IN',
                        'qty' => abs($stockDiff),
                        'previous_stock' => $item->stock - abs($stockDiff),
                        'current_stock' => $item->stock,
                        'user_id' => auth()->id(),
                        'description' => 'Koreksi peminjaman: Penyesuaian jumlah',
                    ]);
                }
            }

            $borrowing->update([
                'item_id' => $request->item_id,
                'borrower_name' => $request->borrower_name,
                'borrower_phone' => $request->borrower_phone,
                'qty' => $newQty,
                'borrow_date' => $request->borrow_date,
                'return_date' => $request->return_date,
                'note' => $request->note,
            ]);
        });

        return redirect()->route('admin.borrowings.index')
            ->with('success', 'Peminjaman berhasil diperbarui.');
    }

    /**
     * Return/Pengembalian barang.
     */
    public function returnItem(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status !== 'borrowed') {
            return back()->with('error', 'Peminjaman ini tidak dalam status dipinjam.');
        }

        $request->validate([
            'return_note' => 'nullable|string',
            'condition' => 'nullable|string|in:good,damaged,lost',
        ]);

        DB::transaction(function () use ($request, $borrowing) {
            $item = $borrowing->item;
            $previousStock = $item->stock;

            if ($request->condition === 'lost') {
                // Item hilang - tidak kembalikan ke stok
                $borrowing->update([
                    'status' => 'lost',
                    'actual_return_date' => now()->toDateString(),
                    'return_note' => $request->return_note,
                ]);
            } else {
                // Item kembali - kembalikan ke stok
                $borrowing->update([
                    'status' => 'returned',
                    'actual_return_date' => now()->toDateString(),
                    'return_note' => $request->return_note,
                ]);

                $item->increment('stock', $borrowing->qty);

                // Create stock log
                StockLog::create([
                    'item_id' => $item->id,
                    'action' => 'IN',
                    'qty' => $borrowing->qty,
                    'previous_stock' => $previousStock,
                    'current_stock' => $item->stock,
                    'user_id' => auth()->id(),
                    'description' => "Pengembalian: {$borrowing->borrower_name}" . ($request->return_note ? " - {$request->return_note}" : ''),
                ]);
            }
        });

        return redirect()->route('admin.borrowings.index')
            ->with('success', 'Pengembalian berhasil dicatat.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        if ($borrowing->status === 'borrowed') {
            // Return stock first
            $borrowing->item->increment('stock', $borrowing->qty);
            StockLog::create([
                'item_id' => $borrowing->item_id,
                'action' => 'IN',
                'qty' => $borrowing->qty,
                'previous_stock' => $borrowing->item->stock - $borrowing->qty,
                'current_stock' => $borrowing->item->stock,
                'user_id' => auth()->id(),
                'description' => 'Hapus peminjaman: Pengembalian stok',
            ]);
        }

        $borrowing->delete();

        return redirect()->route('admin.borrowings.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}

