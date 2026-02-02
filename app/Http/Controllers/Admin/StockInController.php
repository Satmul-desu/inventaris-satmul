<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Notification;
use App\Models\StockIn;
use App\Models\StockLog;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StockIn::with(['item', 'supplier', 'user']);

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        if ($request->has('item_id') && $request->item_id) {
            $query->where('item_id', $request->item_id);
        }

        $stockIns = $query->orderBy('date', 'desc')->paginate(10);
        $items = Item::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();

        return view('admin.stock-in.index', compact('stockIns', 'items', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::with(['unit'])->orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return view('admin.stock-in.create', compact('items', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'qty' => 'required|integer|min:1',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $item = Item::findOrFail($request->item_id);
            $previousStock = $item->stock;

            // Create stock in record
            $stockIn = StockIn::create([
                'item_id' => $request->item_id,
                'supplier_id' => $request->supplier_id,
                'qty' => $request->qty,
                'date' => $request->date,
                'note' => $request->note,
                'user_id' => auth()->id(),
            ]);

            // Update item stock
            $item->increment('stock', $request->qty);

            // Create stock log
            $supplierName = $stockIn->supplier ? $stockIn->supplier->name : 'Tidak ada supplier';
            StockLog::create([
                'item_id' => $item->id,
                'action' => 'IN',
                'qty' => $request->qty,
                'previous_stock' => $previousStock,
                'current_stock' => $item->stock,
                'user_id' => auth()->id(),
                'description' => "Barang masuk dari " . $supplierName,
            ]);

            // Check and remove low stock notification if stock is now sufficient
            if ($item->stock > $item->min_stock) {
                Notification::where('item_id', $item->id)
                    ->where('type', 'low_stock')
                    ->delete();
            }
        });

        return redirect()->route('admin.stock-in.index')
            ->with('success', 'Barang masuk berhasil dicatat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(StockIn $stockIn)
    {
        $stockIn->load(['item', 'supplier', 'user']);
        return view('admin.stock-in.show', compact('stockIn'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockIn $stockIn)
    {
        DB::transaction(function () use ($stockIn) {
            $item = $stockIn->item;
            $previousStock = $item->stock;

            // Restore stock
            $item->decrement('stock', $stockIn->qty);

            // Log the reversal
            StockLog::create([
                'item_id' => $item->id,
                'action' => 'OUT',
                'qty' => -$stockIn->qty,
                'previous_stock' => $previousStock,
                'current_stock' => $item->stock,
                'user_id' => auth()->id(),
                'description' => 'Penghapusan barang masuk',
            ]);

            $stockIn->delete();
        });

        return redirect()->route('admin.stock-in.index')
            ->with('success', 'Data barang masuk berhasil dihapus.');
    }
}

