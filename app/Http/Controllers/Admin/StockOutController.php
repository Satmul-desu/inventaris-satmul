<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Location;
use App\Models\Notification;
use App\Models\StockLog;
use App\Models\StockOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StockOut::with(['item', 'location', 'user']);

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        if ($request->has('item_id') && $request->item_id) {
            $query->where('item_id', $request->item_id);
        }

        $stockOuts = $query->orderBy('date', 'desc')->paginate(10);
        $items = Item::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();

        return view('admin.stock-out.index', compact('stockOuts', 'items', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::with(['unit'])->where('stock', '>', 0)->orderBy('name')->get();
        $locations = Location::orderBy('name')->get();
        return view('admin.stock-out.create', compact('items', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'location_id' => 'nullable|exists:locations,id',
            'qty' => 'required|integer|min:1',
            'date' => 'required|date',
            'recipient' => 'nullable|string|max:255',
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

            // Create stock out record
            $stockOut = StockOut::create([
                'item_id' => $request->item_id,
                'location_id' => $request->location_id,
                'qty' => $request->qty,
                'date' => $request->date,
                'recipient' => $request->recipient,
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
                'description' => "Penerima: " . ($request->recipient ?? 'Tidak diketahui'),
            ]);

            // Check for low stock notification
            if ($item->stock <= $item->min_stock) {
                Notification::create([
                    'item_id' => $item->id,
                    'type' => $item->stock <= 0 ? 'out_of_stock' : 'low_stock',
                    'message' => $item->stock <= 0 
                        ? "Stok {$item->name} ({$item->code}) habis!"
                        : "Stok {$item->name} ({$item->code}) menipis. Sisa stok: {$item->stock} {$item->unit->name}",
                ]);
            }
        });

        return redirect()->route('admin.stock-out.index')
            ->with('success', 'Barang keluar berhasil dicatat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StockOut $stockOut)
    {
        $stockOut->load(['item', 'location', 'user']);
        return view('admin.stock-out.show', compact('stockOut'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockOut $stockOut)
    {
        DB::transaction(function () use ($stockOut) {
            $item = $stockOut->item;
            $previousStock = $item->stock;

            // Restore stock
            $item->increment('stock', $stockOut->qty);

            // Log the reversal
            StockLog::create([
                'item_id' => $item->id,
                'action' => 'IN',
                'qty' => $stockOut->qty,
                'previous_stock' => $previousStock,
                'current_stock' => $item->stock,
                'user_id' => auth()->id(),
                'description' => 'Penghapusan barang keluar',
            ]);

            $stockOut->delete();
        });

        return redirect()->route('admin.stock-out.index')
            ->with('success', 'Data barang keluar berhasil dihapus.');
    }
}

