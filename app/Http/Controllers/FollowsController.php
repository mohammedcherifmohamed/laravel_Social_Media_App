<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\follows ;
use App\Models\PostsModel ;
use Illuminate\Support\Facades\Storage;


class FollowsController extends Controller
{
    
    public function getPosts($id){
             $followedUserIds = follows::where('follower_id', auth()->id())
                          ->pluck('followed_id');

        $posts = PostsModel::with('user', 'likes')
            ->whereIn('user_id', $followedUserIds)
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'posts' => $posts
        ]);
    }


public function getFollowers($id){
    $followed_users = follows::where('followed_id', $id)
        ->with('follower')
        ->get();

    return response()->json([
        "success" => true,
        "followed_users" => $followed_users->map(function ($follow) {
            $user = $follow->follower;

            // Check if the auth user follows this follower
            $isFollowing = follows::where('follower_id', auth()->id())
                ->where('followed_id', $user->id)
                ->exists();

            return [
                'follower' => [
                    "id" => $user->id,
                    'name' => $user->name,
                    'nickName' => $user->nickName,
                    'image_path' => $user->image_path
                        ? Storage::url($user->image_path)
                        : asset('images/default-avatar.png'),
                    'is_followed_by_auth_user' => $isFollowing,
                ]
            ];
        })
    ]);
}

public function getFollowing($id){
    $following_users = follows::where('follower_id', $id)
        ->with('followed')
        ->get();

    return response()->json([
        "success" => true,
        "following_users" => $following_users->map(function ($follow) {
            $user = $follow->followed;

            // Check if the auth user follows this user
            $isFollowing = follows::where('follower_id', auth()->id())
                ->where('followed_id', $user->id)
                ->exists();

            return [
                'followed' => [
                    "id" => $user->id,
                    'name' => $user->name,
                    'nickName' => $user->nickName,
                    'image_path' => $user->image_path
                        ? Storage::url($user->image_path)
                        : asset('images/default-avatar.png'),
                    'is_followed_by_auth_user' => $isFollowing,
                ]
            ];
        })
    ]);
}
}

