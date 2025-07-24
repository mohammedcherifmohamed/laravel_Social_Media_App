<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Postsmodel ;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{


   public function add_post(Request $req){
      $req->validate([
         'content' => 'nullable|max:255',
         'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
      ]);

      $imageName = null;
      if ($req->hasFile('image')) {
         $imageName = $req->file('image')->store('posts_images', 'public'); 
      } else {
         $imageName = null;
      }


     $res =  PostsModel::create([
         "user_id" => Auth::id(),
         "content" => $req->content,
         "image_path" => $imageName,
      ]);

      return redirect()->back();
   }




}
