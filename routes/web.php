<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication\AuthController ;
use App\Http\Controllers\HomeController ;



Route::get('/register', [AuthController ::class , 'load_register'])->name('register.load');

Route::post('/register', [AuthController ::class , 'register_post'])->name('register.post');

Route::get('/login', [AuthController ::class , 'load_login'])->name('login');

Route::post('/login', [AuthController ::class , 'login_post'])->name('login.post');




Route::middleware(['auth'])->prefix('home')->group(function(){
    
    Route::get('/', [HomeController ::class , 'load_home'])->name('home.load');

});


