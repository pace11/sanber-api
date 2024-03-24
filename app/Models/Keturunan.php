<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Keturunan extends Model
{
    use HasFactory, SoftDeletes, Sortable;

    protected $table = 'keturunan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'title',
    ];
    protected $guard = [
        'created_at', 'updated_at'
    ];
    protected $dates = [
        'deleted_at'
    ];

    public $timestamps = true;

    public $sortable = ['id', 'title'];

    public function pegawai() {
        return $this->hasMany(Pegawai::class);
    }
}
