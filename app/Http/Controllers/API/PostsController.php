<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController as ResponseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Posts;
use App\Models\Pegawai;
use App\Models\Agama;
use App\Models\Golongan;
use App\Models\Jabatan;
use App\Models\Keturunan;
use App\Models\PendidikanTerakhir;
use Validator;

class PostsController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $user_data = Auth::guard('api')->user();
        $type = $request->query('type');
        $users_id = $request->query('users_id');
        $user = $users_id ? $users_id : $user_data->id;

        if ($type == 'me' || isset($users_id)) {
            $posts = Posts::with(['user:id,name,email'])
                        ->withCount(['likes', 'replies'])
                        ->orderBy('updated_at', 'desc')
                        ->where('users_id', $user)
                        ->get();
        } else {
            $posts = Posts::with(['user:id,name,email'])
                        ->withCount(['likes', 'replies'])
                        ->orderBy('updated_at', 'desc')
                        ->get();
        }

        return $this->sendResponse($posts, "Fetch posts success");
    }

    /**
     * Display the specified resource. 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showById($id) {
        $post = Posts::with(['user:id,name,email'])
                    ->withCount(['likes', 'replies'])
                    ->orderBy('updated_at', 'desc')
                    ->where('id', $id)
                    ->first();

        if (!$post) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($post, 'Fetch post success');
    }

    /**
     * Insert new resource.
     *
     * @param  request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $user = Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        $input = $request->all();
        $input['users_id'] = $user->id;
        
        $post = Posts::create($input);

        return $this->sendResponse($post, "Submit post success", 201);
    }

    /**
     * Modified the specific resource.
     *
     * @param  request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateById(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors(), 400);       
        }

        Posts::whereId($id)->update($request->all());
        $update = Posts::where('id', $id)->first();

        return $this->sendResponse($update, "Update post success");
    }

    /**
     * Remove the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteById($id) {
        $posts = Posts::whereId($id)->delete();

        if (!$posts) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse(null, 'Delete post success');
    }

    /**
     * Display the specific resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showByUserId($user_id) {
        $posts = Posts::with(['user:id,name,email'])
                        ->withCount(['likes', 'replies'])
                        ->orderBy('updated_at', 'desc')
                        ->where("users_id", $user_id)
                        ->get();

        if (!$posts) {
            return $this->sendError('Not Found', false, 404);
        }
        
        return $this->sendResponse($posts, 'Fetch post success');
    }
}
