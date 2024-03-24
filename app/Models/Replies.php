<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Replies extends Model
{
    use HasFactory;

    protected $table = 'replies';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'description', 'posts_id', 'users_id',
    ];
    protected $guard = [
        'created_at', 'updated_at'
    ];
    protected $dates = [
        'deleted_at'
    ];
    protected $appends = ['is_own_reply'];

    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function getIsOwnReplyAttribute() {
        $user = Auth::guard('api')->user();
        $is_own_reply = $this->user->id == $user->id ?? false;
        return $is_own_reply;
    }
}
