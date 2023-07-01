<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemsController extends Controller
{
    public function index() {
        return redirect()->route('item.show', 0);
    }

    public function show($sorting) {
        switch ($sorting) {
            case 0:
                $items = Item::orderBy('data_id')->get();
                break;
            case 1:
                $items = Item::orderByDesc('data_id')->get();
                break;
            case 2:
                $items = Item::orderBy('name')->get();
                break;
            case 3: 
                $items = Item::orderByDesc('name')->get();
                break;
            default:
                abort(404);
        }
        return view('items', compact('items') + ['sorting' => $sorting]);
    }

    public function store(Request $request) {
        $data = request()->validate([
            'data_id' => 'numeric',
            'name' => 'string',
        ]);
        $data['name'] = trim($data['name']);
        $data['data_id'] = Item::max('data_id') + 1 ;
        Item::create($data);
        $sorting = $request->input('sorting');
        return redirect()->route('item.show', $sorting);
    }

    public function update(Request $request, Item $item) {
        $data = request()->validate([
            'data_id' => 'numeric',
            'name' => 'string',
        ]);
        $item->update($data);
        $sorting = request()->input('sorting');
        return redirect()->route('item.show', $sorting);
    }

    public function destroy(Request $request, Item $item) {
        $item->delete();
        $sorting = $request->input('sorting');
        return redirect()->route('item.show', $sorting);
    }
}
