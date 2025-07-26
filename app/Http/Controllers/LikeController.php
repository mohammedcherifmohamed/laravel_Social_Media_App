<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostsModel;

class LikeController extends Controller
{
   public function toggle_like(Request $req){
    $user = $req->user();
        $post = PostsModel::findOrFail($req->post_id);

    $liked = $post->isLikedBy($user);

    if($liked){
        $post->likes()->where('user_id',$user->id)->delete();
    }else{
        $post->likes()->create(['user_id'=>$user->id]);
    }

    return response()->json([
        'liked' => !$liked,
        'likeCount' => $post->likes()->count()
    ]);

    
}
}
