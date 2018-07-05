<?php

namespace Portal\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Portal\Models\User;
use Portal\Helpers\Authentication;
use Portal\Helpers\UserHelper;
use App\Rules\ValidateData;

use Validator;
use Auth;


class Usercontroller extends Controller
{

    /**
     * Auth methods
     */

    public function login(Request $request){

        $validator = Validator::make($request->all(), [ 
            'username' => 'required|exists:users',
            'password' => 'required'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $credentials = $request->only(['username', 'password']);

        if(Auth::attempt(["username" => $credentials['username'], "password" => $credentials['password']])){

            $request->request->add([
                "grant_type" => "password",
                "client_id" => env('CLIENT_ID'),
                "client_secret" => env('CLIENT_SECRET'),
                "username" => $credentials['username'],
                "password" => $credentials['password'],
            ]);
    
            $authRequest = $request->create(
                env('APP_URL').'/oauth/token',
                'post'
            );

            $token = Authentication::getToken($authRequest);

            return response()->json(["message" => $token['message'], "token" => $token['data']], $token['status']);

        }
        
    }

    public function refresh(Request $request){
        
        $token = Authentication::refreshToken($request, $request->refreshtoken);

        return response()->json(["message" => $token['message'], "token" => $token['data']], $token['status']);
        
    }

    /**
     * User methods
     */


    public function adduser(Request $request)
    {
        $validator = Validator::make($request->all(), [ 
            'username' => 'required|string|max:20|min:4|unique:users',
            'password' => 'required|min:6|',

            'name' => 'required|array',
            'name.first' => 'required',
            'name.last' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|unique:users',
            'role' => 'required|in:admin,user',
            'access' => 'sometimes', 
            'status' => 'required|in:inactive,active', 
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $user = User::create([
            'id' => str_random(10),
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'role' => $request->role,
            'access' => $request->access,
            'status' => $request->status
        ]);

        if($user){

            return response()->json([ "message" => "success" , "data" => $user], 200);
        } else{

            return response()->json([ "message" => "failed" , "data" => "unable to create login credentials" ], 500);
        }
        
    }



    public function listuser(Request $request){

        $validator = Validator::make($request->all(), [ 
            'user_data' => 'required|array',
            'user_data.parameter' => ['required','array', new ValidateData],
            'user_data.count' => 'required|integer',
            'user_data.offset' => 'required|integer'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $user = UserHelper::listUser($request);

        return response()->json(['message' => $user['message'], 'data' => $user['data']], $user['status_code']);

    }



    public function getuser(Request $request){

        $validator = Validator::make($request->all(), [ 
            'filters' => 'required|array',
            'user_data' => ['required','array', new ValidateData] 
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $user = UserHelper::getUser($request);

        return response()->json(['message' => $user['message'], 'data' => $user['data']], $user['status_code']);

    }



    public function updateuser(Request $request){

        $validator = Validator::make($request->all(), [ 
            'id' => 'required|exists:users',
            'user_data' => 'required|array',
            'user_data.name' => 'sometimes|array',
            'user_data.name.first' => 'sometimes',
            'user_data.name.last' => 'sometimes',
            'user_data.email' => 'sometimes|email|unique:users',
            'user_data.mobile' => 'sometimes|unique:users', 
            'user_data.status' => 'sometimes|in:inactive,active', 
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $user = UserHelper::updateUser($request);

        return response()->json(['message' => $user['message'], 'data' => $user['data']], $user['status_code']);


    }

    public function deleteuser(Request $request){

        $validator = Validator::make($request->all(), [ 
            'id' => 'required|exists:users'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $user = UserHelper::deleteUser($request);

        return response()->json(['message' => $user['message'], 'data' => $user['data']], $user['status_code']);

    }


}
