<?php

namespace Portal\Helpers;

use Portal\Models\User; 
use Illuminate\Support\Facades\Route;

class Authentication
{
    public static function getToken($tokenRequest){
        
        try{

            $instance = Route::dispatch($tokenRequest);

            $data = json_decode($instance->getContent());
                
            if($instance->getStatusCode() == 200){

                return ["message" => "success", "data" => $data, "status" => 200];

            } else{
            
                return ["message" => "failure", "data" => $data, "status" => 500]; 
            }
    
        } catch(Exception $e){
            return $e->getMessaage();
        }

    }

    public static function refreshToken($request, $refresh_token){

        try{

         $request->request->add([
                "grant_type" => "refresh_token",
                "refresh_token" => $refresh_token, 
                "client_id" => env('CLIENT_ID'),
                "client_secret" => env('CLIENT_SECRET')
        ]);
    
        $tokenRequest = $request->create(
                env('APP_URL').'/oauth/token',
                'post'
        );
        
        $get_token = (new self)->getToken($tokenRequest);

        if($get_token["status"] == 200){

            return ["message" => "success", "data" => $get_token['data'], "status" => 200];
            
        } else{

            return ["message" => "failed", "data" => $get_token['data']['message'], "status" => 500];
        }

        } catch(Exception $e){
            return $e->getMessage();
        }
    }

}