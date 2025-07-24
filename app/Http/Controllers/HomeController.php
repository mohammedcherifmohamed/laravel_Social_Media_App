<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostsModel;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller{
    public function load_home(){

        $posts = PostsModel::with('user', 'likes')
                ->orderBy('id', 'desc')
                ->get();

        
        // dd($posts);
        return view("Home",compact('posts')) ;
    }

    public function load_profile(Request $req){


        return view('Profile') ;
    }
}
