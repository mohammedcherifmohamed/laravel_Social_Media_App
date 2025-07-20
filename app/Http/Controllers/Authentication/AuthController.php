<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function load_register(){
        return view('Auth.Register') ;
    }

    public function register_post(Request $req){

        $req->validate([
            "profileImage" => "required|image|mimes:jpg,png,jpeg",
            "username" => "required|max:30|min:2|unique:users,name" ,
            "Nickname" => "required|min:3|max:30",
            "email" => "email|unique:users,email",
            "password" => "required|min:3|max:30|confirmed",

        ]);

        if ($req->hasFile('profileImage')) {
            $image = $req->file('profileImage');
            $image_path = $image->store('profile_images', 'public');
        } else {
            $image_path = null;
        }

        try{

            $result = User::create([
                "name" => $req->username ,
                "nickName" => $req->Nickname ,
                "email" => $req->email ,
                "password" => Hash::make($req->password),
                "image_path" => $image_path ,
            ]);
            
            if($result){
                return redirect()->route('login')->with('register_success','Registration successfully you can Loginto you account');
            }
        }catch(\Exception $e){
            return redirect()->back()->with('db_error','somthing went wrong pleas try again') ;
        }

        // return view('Auth.Register') ;
    }
    
    public function load_login(){
        return view('Auth.login') ;
    }

    public function login_post(Request $req){

        $user = User::where('email',$req->email)->first();
        if($user && Hash::check($req->password , $user->password)){
            Auth::login($user);
            return redirect()->route('home.load') ;     
        }else{
            
            return redirect()->back()->with('error_login','Email or User Name') ;
        }

    }

}
