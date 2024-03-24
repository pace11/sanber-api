<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notifications extends Model
{
    use HasFactory;

    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'remark', 'posts_id', 'users_id', 'read'
    ];
    protected $guard = [
        'created_at', 'updated_at'
    ];
    protected $hidden = [
        'posts_id', 'users_id'
    ];
    protected $casts = [
        'read' => 'boolean',
    ];

    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function posts() {
        return $this->belongsTo(Posts::class, 'posts_id', 'id');
    }
}
