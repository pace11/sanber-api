<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SpotifyNotif extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'spotify_notif';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'title', 'description', 'plan', 'member_count', 'expires_at'
    ];
    protected $guard = [
        'created_at', 'updated_at'
    ];
    protected $dates = [
        'deleted_at'
    ];

    public $timestamps = true;
}
