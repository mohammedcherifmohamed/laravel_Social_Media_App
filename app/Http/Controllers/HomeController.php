<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostsModel;
use App\Models\comments;
use App\Models\User;
use App\Models\follows;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller{
    public function load_home(){

        $followedUserIds = follows::where('follower_id', auth()->id())
                          ->pluck('followed_id');

        $posts = PostsModel::with('user', 'likes')
            ->whereIn('user_id', $followedUserIds)
            ->orderBy('id', 'desc')
            ->get();

        return view("Home",compact('posts')) ;
    }

    public function loadExplore(){
         $posts = PostsModel::with('user', 'likes')
                ->orderBy('id', 'desc')
                ->get();
        return view("Home",compact('posts')) ;
    }

    public function load_profile(Request $req){
            $user = Auth::user();
            $posts = $user->posts()
                    ->with('likes')
                    ->orderBy('id','desc')
                    ->get();
            $follows = false ;
            return view('Profile',compact('posts','user','follows')) ;
    }

    public function SeeProfile($id){

        $user = User::findOrFail($id);
        $posts = $user->posts()
                ->with('likes')
                ->orderBy('id','desc')
                ->get();
        ; 
                $follows = follows::where('follower_id', auth()->id())
                                ->where('followed_id', $id)
                                ->exists(); // returns true/false

        return view('profile',compact('posts','user','follows'))  ;
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


public function ToggleFollowUser($id){

    $res = follows::where('follower_id', auth()->id())
                 ->where('followed_id', $id)
                 ->first();

    if ($res) {
        // Unfollow (delete follow record)
        $deleted = $res->delete();

        return response()->json([
            "deleted" => $deleted,
            "followed" => false
        ]);
    } else {
        // Follow (create follow record)
        $created = follows::create([
            "follower_id" => auth()->id(),
            "followed_id" => $id,
        ]);

        return response()->json([
            "created" => (bool)$created,
            "followed" => true,
            "data" => "Followed user " . $id
        ]);
    }
}


  
}
