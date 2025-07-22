<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostsModel;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller{
    public function load_home(){

        $posts = DB::table('posts')
        ->join('users','posts.user_id','=','users.id')
       ->select(
        'posts.content',
        'posts.image_path as post_image',
        'posts.created_at',
        'users.name',
        'users.image_path as user_image'
    )
        ->orderBy('posts.id','desc')
        ->get();
        
        ;
        return view("Home",compact('posts')) ;
    }
    public function load_profile(Request $req){


        return view('Profile') ;
    }
}
