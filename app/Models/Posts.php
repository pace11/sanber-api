<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Posts extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 'description', 'users_id'
    ];
    protected $guard = [
        'created_at', 'updated_at'
    ];
    protected $dates = [
        'deleted_at'
    ];
    protected $hidden = [
        'likes'
    ];
    protected $appends = ['is_like_post', 'is_own_post'];

    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function likes() {
        return $this->hasMany(Likes::class, 'posts_id');
    }

    public function replies() {
        return $this->hasOne(Replies::class, 'posts_id');
    }

    public function getIsLikePostAttribute() {
        $user = Auth::guard('api')->user();
        $is_like_post = false;
        
        foreach($this->likes as $value) {
            if ($value->users_id == $user->id) {
                $is_like_post = true;
            }
        }
        return $is_like_post;
    }

    public function getIsOwnPostAttribute() {
        $user = Auth::guard('api')->user();
        $is_own_post = $this->user->id == $user->id ?? false;
        return $is_own_post;
    }
}
