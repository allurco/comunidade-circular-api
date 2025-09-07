<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ExchangeController extends Controller
{
    public function show($id) {
        $ex = Exchange::query()->with(['item.owner','fromUser','toUser','comments.sender'])->findOrFail($id);
        return $ex;
    }

    public function store(Request $r) {
        $data = $r->validate([
            'from_user_id' => ['required','exists:users,id'],
            'to_user_id'   => ['required','exists:users,id','different:from_user_id'],
            'item_id'      => ['required','exists:items,id'],
            'date'         => ['required','date'],
            'notes'        => ['nullable','string'],
            'type'         => ['required', Rule::in(['TROCA','DOACAO'])],
            'status'       => ['required', Rule::in(['PENDENTE','ACEITA','CONCLUIDA','CANCELADA'])],
            'status_datetime' => ['required','date'],
            'avoided_items'   => ['nullable','integer','min:1']
        ]);

        $exchangeId = DB::transaction(function () use ($data) {
            // Idempotency: look up a similar one first
            $existing = Exchange::where([
                'item_id' => $data['item_id'],
                'from_user_id' => $data['from_user_id'],
                'to_user_id' => $data['to_user_id'],
                'status' => $data['status'],
            ])->first();

            $ex = $existing ?? Exchange::create($data);

            // Business rule: if concluded, mark item as "Trocado"
            if ($data['status'] === 'CONCLUIDA') {
                Item::where('id', $data['item_id'])->update(['status' => 'Trocado', 'owner_id' => $data['to_user_id']]);
            }

            return $ex->id;
        });

        return response()->json(['id' => $exchangeId], 201);
    }
}
