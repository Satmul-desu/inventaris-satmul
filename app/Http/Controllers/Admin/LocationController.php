<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::orderBy('name')->get();
        return view('admin.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations',
            'description' => 'nullable|string',
        ]);

        Location::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lokasi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations,name,'.$location->id,
            'description' => 'nullable|string',
        ]);

        $location->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lokasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        if ($location->itemLocations()->exists() || $location->stockOuts()->exists()) {
            return redirect()->route('admin.locations.index')
                ->with('error', 'Lokasi tidak dapat dihapus karena masih digunakan.');
        }

        $location->delete();

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lokasi berhasil dihapus.');
    }
}

