<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostsModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller{
    public function load_home(){

        $posts = PostsModel::with('user', 'likes')
                ->orderBy('id', 'desc')
                ->get();

        
        // dd($posts);
        return view("Home",compact('posts')) ;
    }

    public function load_profile(Request $req){
            $user = Auth::user();
            $posts = $user->posts()
                    ->with('likes')
                    ->orderBy('id','desc')
                    ->get();

            return view('Profile',compact('posts')) ;
    }
}
