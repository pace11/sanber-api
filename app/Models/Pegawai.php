<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Pegawai extends Model
{
    use HasFactory, HasUuids, SoftDeletes, Sortable;

    protected $table = 'pegawai';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'nip_lama',
        'nip_baru',
        'tmt_golongan',
        'tmt_jabatan',
        'kepala_sekolah',
        'jurusan',
        'tahun_lulus',
        'keterangan',
        'pendidikan_terakhir_id',
        'keturunan_id',
        'golongan_id',
        'jabatan_id',
        'agama_id',
    ];
    protected $guard = [
        'created_at', 'updated_at'
    ];
    protected $dates = [
        'deleted_at'
    ];

    public $timestamps = true;

    public $sortable = ['nama'];

    public function pendidikan_terakhir() {
        return $this->belongsTo(PendidikanTerakhir::class, 'pendidikan_terakhir_id', 'id');
    }

    public function keturunan() {
        return $this->belongsTo(Keturunan::class, 'keturunan_id', 'id');
    }

    public function golongan() {
        return $this->belongsTo(Golongan::class, 'golongan_id', 'id');
    }

    public function jabatan() {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
    }

    public function agama() {
        return $this->belongsTo(Agama::class, 'agama_id', 'id');
    }
}
