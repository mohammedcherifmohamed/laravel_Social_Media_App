<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController ;
use App\Http\Controllers\HomeController ;
use App\Http\Controllers\PostsController ;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\Comments;



Route::get('/register', [AuthController ::class , 'load_register'])->name('register.load');

Route::post('/register', [AuthController ::class , 'register_post'])->name('register.post');

Route::get('/login', [AuthController ::class , 'load_login'])->name('login');

Route::post('/login', [AuthController ::class , 'login_post'])->name('login.post');

Route::get('/logout', [AuthController ::class , 'logout'])->name('logout');



Route::middleware(['auth'])->prefix('home')->group(function(){
    
    Route::get('/', [HomeController ::class , 'load_home'])->name('home.load');
    Route::get('/profile', [HomeController ::class , 'load_profile'])->name('profile.load');
    
    Route::get('/SeeProfile/{id}', [HomeController ::class , 'SeeProfile'])->name('profile.see');

});

Route::middleware(['auth'])->prefix('post')->group(function(){

    Route::post('/add',[PostsController::class,"add_post"])->name("post.add");
    Route::post('/toggle_like',[LikeController::class,"toggle_like"])->name('post.toggle_like');
    Route::delete('/{postId}/delete',[PostsController::class,"delete_post"])->name('post.delete');


});

Route::middleware(['auth'])->prefix('comment')->group(function(){

    Route::post('/add',[Comments::class,"add_comment"])->name('comment.add');
    
    Route::get('/get_comments/{postId}',[Comments::class,"get_comments"])->name('comment.get');


    
});
