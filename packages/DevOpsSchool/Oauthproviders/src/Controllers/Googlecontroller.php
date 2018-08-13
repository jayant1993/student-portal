<?php

namespace Oauthproviders\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Rules\ValidateData;
use Portal\Models\User; 

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use GuzzleHttp\Psr7;

use Validator;
use Auth;
use Socialite;
use DB;


class Googlecontroller extends Controller
{
    public function redirectGoogle(){
        return Socialite::driver('google')->stateless()->redirect();
    }
    
    public function oauthcallback(Request $request){

        $user = Socialite::driver('google')->stateless()->user();

        $userArray = (array)$user;

        if($this->checkUserExists($userArray["email"])){
            //if user exists
            //check email, update session

            $authtype = DB::collection('users')->push("authentication_type", "google");

            $session_id = str_random(10);

            $setSessionID = DB::collection('users')->push("session_id", str_random(10));

            $google = DB::collection('users')->push("google", $userArray);

            if($authtype && $setSessionID && $google){
                return redirect($request->server('HTTP_REFERER'))->withCookie('session_id', $session_id, 45000); 
            } else{
                return redirect($request->server('HTTP_REFERER'));
            }


        } else{

            // create user
            // generate session
            // update auth type

            $user = array(
                "id" => str_random(10),
                "username" => null,
                "password" => null,
                "name" => $userArray["name"],
                "email" => $userArray["mobile"],
                "mobile" => null,
                "role" => "user",
                "status" => "active",
                "authentication_type" => "google",
                "session_id" => str_random(10),
                "google" => $userArray
            ); 

            $insertUser = DB::collection('users')->insert($user);

            if($insertUser){
                return redirect( $request->server('HTTP_REFERER') )->withCookie('session_id', $user["session_id"], 45000);
            }

        }

        $userArray['session_id'] = str_random(20);

        $users = DB::collection('google')->insert($userArray);
    }


    public function is_token_valid(){

        $token = $this->get_access_token();

        try{
            $client = new Client(); //GuzzleHttp\Client
            $result = $client->get('https://www.googleapis.com/oauth2/v1/tokeninfo?access_token='.$token['access_token']);

            if($result->getStatusCode() != 200){
                return false;
            } else{
                return true;
            }
        } catch(GuzzleException $e){
                return false;
        }
    }

    public function checkUserExists($email){
        $user = new User();

        $para = [
            "filters" => ["email" => $email],
            "user_data" => ["*"]
        ];

        $check = $user->findOne($para);

        if(count($check) == 0){
            return true;
        } else{
            return false;
        }
    }

}
