<?php

use App\Http\Controllers\CommentController;
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

Route::get('/posts/{post}/comments', [CommentController::class, 'index'])->name('posts.comments.index');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store');
