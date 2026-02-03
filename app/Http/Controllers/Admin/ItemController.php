<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Item;
use App\Models\Notification;
use App\Models\StockLog;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Item::with(['category', 'unit']);

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('stock_status')) {
            switch ($request->stock_status) {
                case 'low':
                    $query->where('stock', '>', 0)->whereRaw('stock <= min_stock');
                    break;
                case 'out':
                    $query->where('stock', '<=', 0);
                    break;
                case 'available':
                    $query->where('stock', '>', 0)->whereRaw('stock > min_stock');
                    break;
            }
        }

        $items = $query->orderBy('name')->paginate(10);
        $categories = Category::orderBy('name')->get();

        return view('admin.items.index', compact('items', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        
        // Generate suggested item code
        $suggestedCode = Item::generateCode();
        
        return view('admin.items.create', compact('categories', 'units', 'suggestedCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'nullable|string|max:50|unique:items',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // Generate code if not provided
        $code = $request->code ?? Item::generateCode($request->category_id);

        DB::transaction(function () use ($request, $code) {
            $item = Item::create([
                'code' => $code,
                'name' => $request->name,
                'category_id' => $request->category_id,
                'unit_id' => $request->unit_id,
                'stock' => $request->stock,
                'min_stock' => $request->min_stock,
                'price' => $request->price ?? 0,
                'description' => $request->description,
            ]);

            // Log initial stock
            StockLog::create([
                'item_id' => $item->id,
                'action' => 'ADJUST',
                'qty' => $request->stock,
                'previous_stock' => 0,
                'current_stock' => $request->stock,
                'user_id' => auth()->id(),
                'description' => 'Stok awal',
            ]);

            // Check for low stock notification
            if ($item->stock <= $item->min_stock && $item->stock > 0) {
                $this->createLowStockNotification($item);
            }
        });

        return redirect()->route('admin.items.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $categories = Category::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        return view('admin.items.edit', compact('item', 'categories', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:items,code,'.$item->id,
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $oldStock = $item->stock;

        $item->update([
            'code' => $request->code,
            'name' => $request->name,
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id,
            'stock' => $request->stock,
            'min_stock' => $request->min_stock,
            'price' => $request->price ?? 0,
            'description' => $request->description,
        ]);

        // Log stock change if different
        if ($oldStock != $request->stock) {
            $qty = $request->stock - $oldStock;
            StockLog::create([
                'item_id' => $item->id,
                'action' => 'ADJUST',
                'qty' => $qty,
                'previous_stock' => $oldStock,
                'current_stock' => $request->stock,
                'user_id' => auth()->id(),
                'description' => 'Penyesuaian stok',
            ]);
        }

        return redirect()->route('admin.items.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        $item->load(['category', 'unit', 'stockLogs.user', 'itemLocations.location']);
        return view('admin.items.show', compact('item'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        if ($item->stockIns()->exists() || $item->stockOuts()->exists()) {
            return redirect()->route('admin.items.index')
                ->with('error', 'Barang tidak dapat dihapus karena masih memiliki riwayat transaksi.');
        }

        $item->delete();

        return redirect()->route('admin.items.index')
            ->with('success', 'Barang berhasil dihapus.');
    }

    /**
     * Create low stock notification.
     */
    protected function createLowStockNotification(Item $item)
    {
        Notification::create([
            'item_id' => $item->id,
            'type' => 'low_stock',
            'message' => "Stok {$item->name} ({$item->code}) menipis. Sisa stok: {$item->stock} {$item->unit->name}",
        ]);
    }
}

