<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PostsController;
use App\Http\Controllers\API\LikesController;
use App\Http\Controllers\API\RepliesController;
use App\Http\Controllers\API\NotificationsController;
use App\Http\Controllers\API\NotesController;
use App\Http\Controllers\API\ScrapperController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register',  [UserController::class, 'register']);
Route::post('login',  [UserController::class, 'login']);
Route::post('forgot-password',  [UserController::class, 'forgotPassword']);

// Notes w/o auth
Route::get('notes', [NotesController::class, 'index']);
Route::get('notes/{id}', [NotesController::class, 'showById']);
Route::post('notes', [NotesController::class, 'create']);
Route::patch('notes/update/{id}', [NotesController::class, 'updateById']);
Route::delete('notes/delete/{id}', [NotesController::class, 'deleteById']);

Route::post('cek-pajak', [ScrapperController::class, 'index']);

Route::group(['middleware' => 'auth:api'], function() {

    // logout / detail user
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('user/me', [UserController::class, 'me']);
    Route::get('user/{id}', [UserController::class, 'showById']);
    Route::post('update-password', [UserController::class, 'updatePassword']);

    // Posts
    Route::get('posts', [PostsController::class, 'index']);
    Route::get('posts/{user_id}', [PostsController::class, 'showByUserId']);
    Route::post('post', [PostsController::class, 'create']);
    Route::get('post/{id}', [PostsController::class, 'showById']);
    Route::patch('post/update/{id}', [PostsController::class, 'updateById']);
    Route::delete('post/delete/{id}', [PostsController::class, 'deleteById']);

    // Likes
    Route::post('likes/post/{id}', [LikesController::class, 'create']);
    Route::get('likes/post/{id}', [LikesController::class, 'showById']);
    Route::post('unlikes/post/{id}', [LikesController::class, 'deleteById']);

    // Replies
    Route::post('replies/post/{id}', [RepliesController::class, 'create']);
    Route::get('replies/post/{id}', [RepliesController::class, 'showById']);
    Route::delete('replies/delete/{id}', [RepliesController::class, 'deleteById']);

    // Notifications
    Route::get('notifications', [NotificationsController::class, 'index']);

});
