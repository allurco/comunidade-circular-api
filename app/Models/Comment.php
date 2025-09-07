<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['exchange_id','sender_id','message'];
    public function exchange() { return $this->belongsTo(Exchange::class); }
    public function sender() { return $this->belongsTo(User::class, 'sender_id'); }
}
