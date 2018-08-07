<?php

namespace Oauthproviders\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Rules\ValidateData;

use Validator;
use Auth;
use Socialite;
use DB;


class Googlecontroller extends Controller
{
    public function redirectGoogle(){
        return Socialite::driver('google')->stateless()->redirect();
    }
    
    public function oauthcallback(){
        $user = Socialite::driver('google')->stateless()->user();

        $userArray = (array)$user;

        $users = DB::collection('google')->insert($userArray);
    }

    public function getUser(){

    }


}
