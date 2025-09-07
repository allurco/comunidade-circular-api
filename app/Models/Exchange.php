<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exchange extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'from_user_id','to_user_id','item_id','date','notes','type',
        'status','status_datetime','avoided_items'
    ];
    protected $casts = [
        'date' => 'datetime',
        'status_datetime' => 'datetime',
    ];
    public function item() { return $this->belongsTo(Item::class); }
    public function fromUser() { return $this->belongsTo(User::class, 'from_user_id'); }
    public function toUser() { return $this->belongsTo(User::class, 'to_user_id'); }
    public function comments() { return $this->hasMany(Comment::class); }
}
