<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Likes;
use App\Models\Posts;
use App\Models\Notifications;
use Validator;

class LikesController extends ResponseController
{
    /**
     * Display the specified resource. 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $likes = Likes::with(['user:id,name,email'])
                    ->orderBy('updated_at', 'desc')
                    ->where('posts_id', $id)
                    ->get();

        if (!$likes) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($likes, 'Fetch likes success');
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

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $user = Auth::guard('api')->user();
        $likes = Likes::where('posts_id', $id)
                    ->where('users_id', $user->id)
                    ->forceDelete();

        if (!$likes) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Unlikes post success');
    }
}
