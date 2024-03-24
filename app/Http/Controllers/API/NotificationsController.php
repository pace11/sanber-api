<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Notifications;
use Validator;

class NotificationsController extends ResponseController
{
    /**
     * Display the specified resource. 
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = Auth::guard('api')->user();
        $notifications = Notifications::with(['user', 'posts'])
                    ->whereHas('posts', function($q) use($user){
                        $q->where('users_id', $user->id);
                    })
                    ->orderBy('updated_at', 'desc')
                    ->get();
        
        return $this->sendResponse($notifications, 'Fetch notifications success');
    }

    /**
     * Insert new resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create($id) {
        $user = Auth::guard('api')->user();
        $posts = Posts::whereId($id)->first();
        $alreadyLikePost = Likes::where('users_id', $user->id)
                                ->where('posts_id',$id)
                                ->first();

        if (!$posts) {
            return $this->sendError('Not Found', false, 404);
        }

        if ($alreadyLikePost) {
            return $this->sendError('Your already like this post', false, 406);
        }
        
        $likes = Likes::create([
            "posts_id" => $id,
            "users_id" => $user->id
        ]);

        if ($likes && !$posts->is_own_post ) {
            Notifications::create([
                "posts_id" => $posts->id,
                "users_id" => $user->id,
                "read" => false,
            ]);
        }

        return $this->sendResponse($likes, "Like post success", 201);
    }
}
