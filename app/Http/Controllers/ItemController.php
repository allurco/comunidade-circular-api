<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $r) {
        $q = Item::with('owner')->latest();

        if ($r->filled('search')) {
            $s = $r->string('search');
            $q->where(function($w) use ($s){
                $w->where('title','like',"%$s%")
                    ->orWhere('category','like',"%$s%");
            });
        }
        if ($r->filled('status')) {
            $q->where('status', $r->string('status'));
        }

        return $q->paginate(20);
    }

    public function show($id) {
        return Item::with('owner')->findOrFail($id);
    }

    public function store(Request $r) {
        $data = $r->validate([
            'title'=>'required|string', 'category'=>'required|string',
            'conservation'=>'required|string', 'description'=>'required|string',
            'district'=>'nullable|string', 'lat'=>'nullable|numeric', 'lng'=>'nullable|numeric',
            'photo'=>'nullable|string', 'status'=>'nullable|string'
        ]);
        $data['owner_id'] = $r->user()->id;
        $item = Item::create($data);
        return response()->json($item->fresh('owner'), 201);
    }

    public function update(Request $r, $id) {
        $item = Item::findOrFail($id);
        $item->fill($r->only([
            'title','category','conservation','description','district','lat','lng','photo','status'
        ]))->save();
        return $item->fresh('owner');
    }

    public function destroy($id) {
        Item::findOrFail($id)->delete();
        return response()->json(['ok'=>true]);
    }
}
