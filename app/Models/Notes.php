<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'notes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'title', 'description'
    ];
    protected $guard = [
        'created_at', 'updated_at'
    ];
    protected $dates = [
        'deleted_at'
    ];

    public $timestamps = true;
}
