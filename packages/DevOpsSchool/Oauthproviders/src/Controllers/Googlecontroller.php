<?php

namespace Oauthproviders\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Rules\ValidateData;

use Validator;
use Auth;
use Socialite;


class Googlecontroller extends Controller
{
    public function redirectGoogle(){
        return Socialite::driver('google')->stateless()->redirect();
    }
    
    public function oauthcallback(){
        $user = Socialite::driver('google')->stateless()->user();

        return $user;
    }

    public function getUser(){

    }


}
