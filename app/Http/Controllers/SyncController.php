<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Exchange;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SyncController extends Controller
{
    public function pull(Request $r) {
        $since = $r->query('updated_since'); // ISO8601 string from device
        $ts = $since ? Carbon::parse($since) : null;
        $users = User::query()->withTrashed()
            ->when($ts, fn($q) => $q->where(function($qq) use ($ts) {
                $qq->where('updated_at','>=',$ts)->orWhere('deleted_at','>=',$ts);
            }))->get();
        $items = Item::withTrashed()
            ->when($ts, fn($q) => $q->where(function($qq) use ($ts) {
                $qq->where('updated_at','>=',$ts)->orWhere('deleted_at','>=',$ts);
            }))->get();

        $exchanges = Exchange::query()->with(['item','fromUser','toUser'])
            ->withTrashed()
            ->when($ts, fn($q) => $q->where(function($qq) use ($ts) {
                $qq->where('updated_at','>=',$ts)->orWhere('deleted_at','>=',$ts);
            }))->get();

        $comments = Comment::with('sender')
            ->withTrashed()
            ->when($ts, fn($q) => $q->where(function($qq) use ($ts) {
                $qq->where('updated_at','>=',$ts)->orWhere('deleted_at','>=',$ts);
            }))->get();

        return response()->json([
            'server_time' => now()->toIso8601String(),
            'users'       => $users,
            'items'       => $items,
            'exchanges'   => $exchanges,
            'comments'    => $comments,
        ]);
    }
}
