<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\MemesController;
use \App\Http\Controllers\CommentsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::resource('/', MemesController::class);
Route::resource('/comments', CommentsController::class);
Route::delete('/{meme}',  [MemesController::class, 'destroy']);

Route::get('/upvote/{id}', [MemesController::class, 'upvote']);
Route::get('/downvote/{id}', [MemesController::class, 'downvote']);
Route::get('/showmymemes', [MemesController::class, 'showmymemes']);
Route::get('/comments/upvote/{id}', [CommentsController::class, 'upvote']);
Route::get('/comments/downvote/{id}', [CommentsController::class, 'downvote']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
