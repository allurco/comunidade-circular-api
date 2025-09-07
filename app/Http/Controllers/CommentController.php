<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Exchange;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($exchangeId) {
        $exchange = Exchange::findOrFail($exchangeId);
        return $exchange->comments()->with('sender')->orderBy('created_at')->get();
    }

    public function store(Request $r, $exchangeId) {
        $r->validate(['message'=>'required|string']);
        $comment = Comment::create([
            'exchange_id' => $exchangeId,
            'sender_id'   => $r->user()->id,
            'message'     => $r->string('message'),
        ]);
        return $comment->load('sender');
    }
}
