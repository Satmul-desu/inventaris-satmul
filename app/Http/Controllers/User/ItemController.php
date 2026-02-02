<?php

namespace App\Http\Controllers\User;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of items for user.
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

        $items = $query->orderBy('name')->paginate(10);

        return view('user.items.index', compact('items'));
    }
}

