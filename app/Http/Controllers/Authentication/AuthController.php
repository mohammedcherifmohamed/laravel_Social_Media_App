<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mail\ForgotPassword ;
use Carbon\Carbon ;


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
        if($user->social_id){
            Auth::attempt(['email' => $req->email],true);
            return redirect()->route('home.load') ;
        }
        $credentials = $req->only('email','password');
        $remember = $req->filled('remember') ;
        if(Auth::attempt($credentials,$remember)){
            return redirect()->route('home.load') ;     
        }else{
            
            return redirect()->back()->with('error_login','Email or User Name') ;
        }

    }


    public function LoadForgotPassword(){
        return view('Auth.Forgot') ;
    }
    
    public function ForgotPassword(Request $req){
        try{
            $req->validate([
                "email" => "required|email",
            ]);
            if(!User::where('email',$req->email)->exists()){
                return redirect()->back()->with("error_forgot","Email does not exist") ;
            }
                
                $token = Str::random(64);
                Tokens::updateOrInsert(
                    ['email' => $req->email],
                    [
                        'token' => $token,
                        'created_at' => Carbon::now()
                    ]

                );
                $link = url("/resetPassword/". $token . "?email=" . $req->email ) ;
                
                Mail::to($req->email)->send(new ForgotPassword(['link'=>$link]));
                
                return redirect()->back()->with("success_forgot","A password reset link has been sent.") ;
        }catch(\Exception $e){
        
            return redirect()->back()->with("error_forgot","Failed to send reset link: " . $e->getMessage()) ;
        }

    }
    public function LoadResetPassword(Request $req , $token){
        return view('Auth.reset-password',["token" => $token, "email" => $req->email]) ;
    }
    public function ResetPassword(Request $req){

        try{

            $req->validate([
                "password"=> "required|min:3|max:30|confirmed",
                "email" => "required|email",
                "token" => "required",
            ]);

            $found = Tokens::where("token",$req->token)->where("email",$req->email)->first();

            if(!$found){
                return redirect()->back()->with("error_reset","Invalid token or email.") ;
            }

            if(carbon::parse($found->created_at)->addMinutes(1)->isPast()){
                return redirect()->back()->with("error_reset","Token has expired.") ;
            }

            User::where("email",$req->email)->update([
                "password" => Hash::make($req->password),
            ]);

            return redirect()->route("login")->with("success_reset","Password has been reset successfully.") ;

        }catch(\Exception $e){

            return redirect()->back()->with("error_reset","Failed to reset password: " . $e->getMessage()) ;
            
        }
        

    }



    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

}

