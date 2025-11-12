<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController ;
use App\Http\Controllers\HomeController ;
use App\Http\Controllers\PostsController ;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowsController;
use App\Http\Controllers\Comments;
use App\Http\Controllers\NotificationsController;

// for testing real app
use App\Events\SendMsg;

// ______ TESTING EBSOCKET

Route::get('/test',function(){

    $message = "Hello from Laravel Event Brodcasting";
    broadcast(new SendMsg($message));
    return "Message Brodcasted";
});

Route::get("/test2",function(){
    return view("Listner");
});


// ______ TESTING EBSOCKET


Route::get('/register', [AuthController ::class , 'load_register'])->name('register.load');

Route::post('/register', [AuthController ::class , 'register_post'])->name('register.post');

Route::get('/login', [AuthController ::class , 'load_login'])->name('login');

Route::post('/login', [AuthController ::class , 'login_post'])->name('login.post');

Route::get('/logout', [AuthController ::class , 'logout'])->name('logout');

// Route::get('/whoami', function () {
//     return auth()->user();
// });

Route::Redirect("/","/home");

Route::middleware(['auth'])->prefix('home')->group(function(){
    
    Route::get('/', [HomeController ::class , 'load_home'])->name('home.load');
    Route::get('/loadExplore', [HomeController ::class , 'loadExplore'])->name('home.loadExplore');
    Route::get('/profile', [HomeController ::class , 'load_profile'])->name('profile.load');
    
    Route::get('/SeeProfile/{id}', [HomeController ::class , 'SeeProfile'])->name('profile.see');
    Route::post('/update_profile', [HomeController ::class , 'update_profile'])->name('profile.update');
    
    Route::get('/searchUsers', [HomeController ::class , 'searchUsers'])->name('users.search');
    
    Route::post('/ToggleFollowUser/{id}', [HomeController ::class , 'ToggleFollowUser'])->name('users.ToggleFollowUser');
    Route::get('/chatWith/{id}',[HomeController ::class,"chat_Load"])->name("chat.load");
    Route::post('/send',[HomeController ::class,"send"])->name("chat.send");

    Route::get('/getFollowers/{id}',[FollowsController::class,"getFollowers"])->name("followers.get");
    Route::get('/getFollowing/{id}',[FollowsController::class,"getFollowing"])->name("following.get");
    Route::get('/getPosts/{id}',[FollowsController::class,"getPosts"])->name("posts.get");

    Route::get('/notifications/push',[NotificationsController::class,"push"])->name("notifications.push");
    
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
