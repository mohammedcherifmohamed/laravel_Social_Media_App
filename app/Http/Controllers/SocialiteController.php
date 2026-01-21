<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class SocialiteController extends Controller
{
    public function redirectTogoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallBack(){
        $user = Socialite::driver('google')->user();
       
        $found = User::where('social_id', $user->id)->first();
        if($found){
            Auth::login($found);
            return redirect()->route('home.load') ;
        }

            // dd($user);   
           

         $exists = User::where('email',$user->email)->first();
        if($exists){
            $exists->update([
                "social_id" => $user->id,
                "social_type" => "google",
            ]);
            Auth::login($exists);
            return redirect()->route('home.load') ;
        }else{
             $newUser = User::create([
                "name" => $user->name ,
                "email" => $user->email ,
                "social_id" => $user->id ,
                "social_type" => "google" ,
                "image_path" => $user->avatar,
                "nickName" => $user->nickname,
                "password" => Hash::make("qsd"),
            ]);

            Auth::login($newUser);
            return redirect()->route('home.load') ;
        }


    }

}
