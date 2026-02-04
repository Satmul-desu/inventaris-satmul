<?php

namespace App\Http\Controllers\Admin;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('role:owner')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::orderBy('name')->get();
        return view('admin.units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:units',
        ]);

        Unit::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.units.index')
            ->with('success', 'Satuan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        return view('admin.units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name,'.$unit->id,
        ]);

        $unit->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.units.index')
            ->with('success', 'Satuan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        if ($unit->items()->exists()) {
            return redirect()->route('admin.units.index')
                ->with('error', 'Satuan tidak dapat dihapus karena masih digunakan oleh barang.');
        }

        $unit->delete();

        return redirect()->route('admin.units.index')
            ->with('success', 'Satuan berhasil dihapus.');
    }
}

