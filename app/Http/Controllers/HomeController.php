<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostsModel;
use App\Models\comments;
use App\Models\User;
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

            return view('Profile',compact('posts','user')) ;
    }

    public function SeeProfile($id){

        $user = User::findOrFail($id);
        $posts = $user->posts()
                ->with('likes')
                ->orderBy('id','desc')
                ->get();

        
        ; 
        
        return view('profile',compact('posts','user'))  ;
    }

    public function searchUsers(Request $req){

        $query = $req->query('query');



       $users =  User::where('name', 'like' , "%$query%" )
        ->select('id','name','image_path','nickName')
        ->get();


        return response()->json([
                "success" => true ,
                "data" => $users
        ]) ;
    }
}
