<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostsModel;
class HomeController extends Controller
{
    public function load_home(){

        $posts = PostsModel::all();
        return view("Home",compact('posts')) ;
    }
    public function load_profile(Request $req){


        return view('Profile') ;
    }
}
