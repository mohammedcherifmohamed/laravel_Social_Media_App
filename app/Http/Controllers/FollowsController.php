<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\follows ;

class FollowsController extends Controller
{
    

    public function getFollowers($id){
        $followed_users = follows::where('followed_id',$id)
             ->with('follower')
            ->get() ;

            return  response()->json([
                "success" => true,
                "followed_users" => $followed_users

            ]) ;

    }
    public function getFollowing($id){
        $following_users = follows::where('follower_id',$id)
             ->with('followed')
            ->get() ;
            // $image_path = \Illuminate\Support\Facades\Storage::url($user->followed->image_path);
            return  response()->json([
                "success" => true,
                "following_users" => $following_users,
                "image_path" => "http://localhost:8000/storage/" . auth()->user()->image_path
            ]) ;

    }

}
