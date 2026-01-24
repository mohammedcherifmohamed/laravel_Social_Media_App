<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostsModel;
use App\Models\comments;
use App\Models\User;
use App\Models\chat;
use App\Models\follows;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Events\MessageSent;
use App\Events\NotificationEvent ;


class HomeController extends Controller{
  
    public function load_home(){
        
        $followedUserIds = follows::where('follower_id', auth()->id())
                          ->pluck('followed_id');

        $posts = PostsModel::with('user', 'likes')
            ->whereIn('user_id', $followedUserIds)
            ->orderBy('id', 'desc')
            ->with("comments")
             ->withCount('likes') 
            ->get();
              $followedUsers = follows::where('follower_id', auth()->id())
                    ->with('followed')
                    ->get()
                    ->pluck('followed');
            // dd($followedUsers);
        return view("Home",compact('posts','followedUsers')) ;
    }

    public function loadExplore(){
         $posts = PostsModel::with('user:id,name,image_path')
                ->orderBy('id', 'desc')
                 ->withCount('likes')
                ->get();
                 $followedUsers = follows::where('follower_id', auth()->id())
                    ->with('followed')
                    ->get()
                    ->pluck('followed');
        return view("Home",compact('posts','followedUsers')) ;
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
                    ->exists();

        return view('profile',compact('posts','user','follows'))  ;
    }

   public function searchUsers(Request $req)
{
    $query = $req->query('query');
    
    $users = User::where('name', 'like', "%$query%")
        ->select('id', 'name', 'image_path', 'nickName')
        ->paginate(6);

    return response()->json([
        "success" => true,
        "data" => $users->items(),
        "next_page_url" => $users->nextPageUrl()
    ]);
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
        // create notification for followed user 
        broadcast(new NotificationEvent(
            "follow",
            auth()->user()->name . " followed you",
            [
            "follower_id" => auth()->id(),
            "followed_id" => $id,
           ]
        ) ) ;

        return response()->json([
            "created" => (bool)$created,
            "followed" => true,
            "data" => "Followed user " . $id
        ]);
    }
}

    public function update_profile(Request $req){
        $user = User::findOrFail(auth()->id());

        $res = $req->validate([
            "oldPassword" => "required",
            "newPassword" => "nullable|min:3", 
            "username" => "required|min:3|unique:users,name," . $user->id,
            "nickName" => "required|min:3",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048"
        ]);

        if (!Hash::check($req->oldPassword, $user->password)) {
            return back()->withErrors(['oldPassword' => 'Old password is incorrect']);
        }

        $newPassword = $req->newPassword ? Hash::make($req->newPassword) : $user->password;

        
        if ($req->hasFile('image')) {
            if ($user->image_path && Storage::disk('public')->exists($user->image_path)) {
                Storage::disk('public')->delete($user->image_path);
            }

            $image_path = $req->file('image')->store('profile_images', 'public');
        } else {
            $image_path = $user->image_path;
        }

        if(!$res){
            return back()->with('errors', 'Something Went Wrong');
        }
        $user->update([
            "name" => $req->username,
            "nickName" => $req->nickName,
            "password" => $newPassword,
            "image_path" => $image_path,
        ]);

        return back()->with('success', 'Profile updated successfully');
    }

  
    public function chat_Load($id){
        // $message = "hello test" ;
        // broadcast(new MessageSent($message));
        // return "Message Brodcated";


        $user = User::findOrFail($id) ;
        $chat_messages = Chat::where(function ($query) use ($id) {
            $query->where('sender_id', auth()->id())
                ->where('reciever_id', $id);
        })->orWhere(function ($query) use ($id) {
            $query->where('sender_id', $id)
                ->where('reciever_id', auth()->id());
        })
        ->get();



        return response()->json([
            'success' => true ,
            'current_user' => auth()->id(),
            'reciever_chat' => $user->name,
            'reciever_id' => $user->id,
            'chat_messages' => $chat_messages 
        ]);
    
    
    }

    public function send(Request $req){
        $req->validate([
            'message' => "required|max:255",
            'reciever_id' => "required|exists:users,id"
        ]);

        // check if Sender follows Receiver
        
        // dd("Auth : " . auth()->id() . "Receiver : " . $req->reciever_id);

        $allowed =  follows::where('follower_id',auth()->id())
        ->where('followed_id',$req->reciever_id)
        ->exists();

    if($allowed){

    
        $message = chat::create([
            'sender_id' => auth()->id(),
            'reciever_id' =>  $req->reciever_id,
            'message' => $req->message
        ]);
         $senderName = auth()->user()->name;
      $receiverName = User::find($req->reciever_id)->name;
        broadcast(new MessageSent($message,$senderName,$receiverName));
        return response()->json([
            'success' => true ,
            'message' => $message
        ]);
    
       }else{

    return redirect()->route('403');

        return response()->json([
            'success' => false ,
            'message' => "You can only chat with users you follow."
        ]);
       }
    }

    public function getPosts(){
        $posts = Posts::wher('user_id',auth()->id())
            ->withCount('likes') 
            ->with('user', 'likes')
            ->orderBy('id', 'desc')
            ->get();
            return response()->json([
                'success' => true ,
                'posts' => $posts
            ]);
    }

}
