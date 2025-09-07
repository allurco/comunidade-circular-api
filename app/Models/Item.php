<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'owner_id','title','category','conservation','description',
        'district','lat','lng','photo','status'
    ];
    public function owner() { return $this->belongsTo(User::class, 'owner_id'); }
    public function exchanges() { return $this->hasMany(Exchange::class); }
}
