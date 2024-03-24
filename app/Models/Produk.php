<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Produk extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    protected $table = 'produk';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'title', 'description', 'price', 'discount_percentage', 'rating', 'stock', 'brand', 'category', 'thumbnail', 'images'
    ];
    protected $guard = [
        'created_at', 'updated_at'
    ];
    protected $dates = [
        'deleted_at'
    ];
    protected $casts = [
        'images' => 'array',
        'rating' => 'float',
    ];

    public $timestamps = true;

    public $sortable = ['id', 'title'];
}
