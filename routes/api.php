<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
// user
Route::post('/login',  [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware("jwtAuth");
Route::post('/refresh', [AuthController::class, 'refresh'])->middleware("jwtAuth");
Route::get('/user-profile', [AuthController::class, 'getUser'])->middleware("jwtAuth");
//post
Route::post('posts/create', [PostController::class, 'create'])->middleware("jwtAuth");
Route::post('posts/update', [PostController::class, 'update'])->middleware("jwtAuth");
Route::post('posts/delete', [PostController::class, 'delete'])->middleware("jwtAuth");
Route::get('posts', [PostController::class, 'posts'])->middleware("jwtAuth");
// comment
Route::post('comments/create', [CommentController::class, 'create'])->middleware("jwtAuth");
Route::post('comments/update', [CommentController::class, 'update'])->middleware("jwtAuth");
Route::post('comments/delete', [CommentController::class, 'delete'])->middleware("jwtAuth");
Route::get('posts/comments', [CommentController::class, 'comments'])->middleware("jwtAuth");
//likes
Route::post('posts/like', [LikeController::class, 'like'])->middleware("jwtAuth");
Route::get('posts/likes', [LikeController::class, 'likes'])->middleware("jwtAuth");