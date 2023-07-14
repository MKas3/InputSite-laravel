<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Item;
use Auth;

class ItemsController extends Controller
{
    public function index(Request $request) {
        $sort_field = $request->input('sort_field', 'data_id');
        $sort_order = $request->input('sort_order', 'asc');
        $items = Item::where('user_id', Auth::user()['id'])->orderBy($sort_field, $sort_order)->get();
        return view('items', compact('items') + ['sort_field' => $sort_field, 'sort_order' => $sort_order]);
    }

    public function store(Request $request) {
        $data = request()->validate([
            'data_id' => 'numeric',
            'name' => 'string',
        ]);
        $data['name'] = trim($data['name']);
        $data['user_id'] = Auth::user()['id'];
        $data['data_id'] = Item::where('user_id', $data['user_id'])->max('data_id') + 1;
        Item::create($data);
        $sort_field = $request->input('sort_field', 'data_id');
        $sort_order = $request->input('sort_order', 'asc');
        return redirect()->route('item.index', ['sort_field' => $sort_field, 'sort_order' => $sort_order]);
    }

    public function update(Request $request, Item $item) {
        if (Gate::denies('update-item', $item)) return;
        $data = request()->validate([
            'data_id' => 'numeric',
            'name' => 'string',
        ]);
        $item->update($data);
        $sort_field = $request->input('sort_field', 'data_id');
        $sort_order = $request->input('sort_order', 'asc');
        return redirect()->route('item.index', ['sort_field' => $sort_field, 'sort_order' => $sort_order]);
    }

    public function destroy(Request $request, Item $item) {
        if (Gate::denies('update-item', $item)) return;
        $item->delete();
        $sort_field = $request->input('sort_field', 'data_id');
        $sort_order = $request->input('sort_order', 'asc');
        return redirect()->route('item.index', ['sort_field' => $sort_field, 'sort_order' => $sort_order]);
    }
}
