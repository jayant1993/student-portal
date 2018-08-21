<?php

namespace Oauthproviders\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

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
    private $redis;

    public function __construct(){

        $this->redis = Redis::connection();
    }

    public function redirectGoogle(){
        return Socialite::driver('google')->stateless()->redirect();
    }
    
    public function oauthcallback(Request $request){

        $user = Socialite::driver('google')->stateless()->user();

        $userArray = (array)$user;

        if($this->checkUserExists($userArray["email"])){

            //if user exists
            //check email, update session

            $user = $this->checkUserExists($userArray["email"]);

            $authtype = DB::collection('users')->update(["authtype" => "google", "google" => $userArray]);

            $session_id = str_random(20);

            if($authtype){

                $this->redis->set($session_id, json_encode([
                    "user_id" => $user['id']
                ]), 'EX', 3600);

                return redirect($request->server('HTTP_REFERER') . '?session_id=' . $session_id . '&status=success');

            } else{

                return redirect($request->server('HTTP_REFERER') . '?status=error');
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
                "email" => $userArray["email"],
                "mobile" => null,
                "role" => "user",
                "status" => "active",
                'authtype' => "google",
                "google" => $userArray
            ); 


            $session_id = str_random(20);

            $insertUser = DB::collection('users')->insert($user);

            if($insertUser){

                $this->redis->set($session_id, json_encode([
                    "user_id" => $user['id']
                ]), 'EX', 3600);
                
                return redirect($request->server('HTTP_REFERER') . '?session_id=' . $session_id . '&status=success');

            } else{

                return redirect($request->server('HTTP_REFERER') . '?status=error');
            }
        }

    }
 
    public function redirect_call(Request $request){

        if(isset($request->session_id)){
            if($this->redis->get($request->session_id)){

                return redirect($request->server('HTTP_REFERER') . '?session_id=' . $this->redis->get('user_session'));
            
            } else{
            
                return Socialite::driver('google')->stateless()->redirect();
            // $this->redirectGoogle();

            }
        } else{
            return Socialite::driver('google')->stateless()->redirect();
        }
    }


    // public function is_token_valid(){

    //     $token = $this->get_access_token();

    //     try{
    //         $client = new Client(); //GuzzleHttp\Client
    //         $result = $client->get('https://www.googleapis.com/oauth2/v1/tokeninfo?access_token='.$token['access_token']);

    //         if($result->getStatusCode() != 200){
    //             return false;
    //         } else{
    //             return true;
    //         }
    //     } catch(GuzzleException $e){
    //             return false;
    //     }
    // }


    public function checkUserExists($email){
        $user = new User();

        $para = [
            "filters" => ["email" => $email],
            "user_data" => ["*"]
        ];

        $check = $user->findOne($para);

        if(count($check) !== 0){
            return $check;
        } else{
            return false;
        }
    }

    



}
