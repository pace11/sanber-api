<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'pesanan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'qty', 'discount_price', 'total_price', 'status', 'produk_id', 'users_id'
    ];
    protected $guard = [
        'created_at', 'updated_at'
    ];
    protected $dates = [
        'deleted_at'
    ];

    public $timestamps = true;

    public function produk() {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }

    public function users() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
