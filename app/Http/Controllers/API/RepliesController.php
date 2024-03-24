<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Replies;
use App\Models\Posts;
use App\Models\Notifications;
use Validator;

class RepliesController extends ResponseController
{
    /**
     * Display the specified resource. 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $likes = Replies::with(['user:id,name,email'])
                    ->orderBy('updated_at', 'desc')
                    ->where('posts_id', $id)
                    ->get();

        if (!$likes) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($likes, 'Fetch replies success');
    }

    /**
     * Insert new resource.
     *
     * @param  request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id) {
        $user = Auth::guard('api')->user();
        $posts = Posts::whereId($id)->first();
        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ]);

        if (!$posts) {
            return $this->sendError('Not Found', false, 404);
        }

        if ($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $input = $request->all();
        $input['users_id'] = $user->id;
        $input['posts_id'] = $id;
        
        $replies = Replies::create($input);

        if (!$posts->is_own_post) {
            Notifications::create([
                "remark" => "reply",
                "posts_id" => $posts->id,
                "users_id" => $user->id,
                "read" => false,
            ]);
        }

        return $this->sendResponse($replies, "Submit reply success", 201);
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $user = Auth::guard('api')->user();
        $replies = Replies::where('id', $id)
                    ->where('users_id', $user->id)
                    ->forceDelete();

        if (!$replies) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete reply success');
    }
}
