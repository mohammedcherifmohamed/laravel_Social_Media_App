<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function load_home(){
        return view('Home') ;
    }
    public function load_profile(Request $req){


        return view('Profile') ;
    }
}
