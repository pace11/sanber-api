<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Likes extends Model
{
    use HasFactory;

    protected $table = 'likes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'posts_id', 'users_id',
    ];
    protected $guard = [
        'created_at', 'updated_at'
    ];
    protected $dates = [
        'deleted_at'
    ];
    protected $appends = ['is_like_post'];

    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function getIsLikePostAttribute() {
        $user = Auth::guard('api')->user();
        $is_like_post = $this->user->id == $user->id ?? false;
        return $is_like_post;
    }
}
