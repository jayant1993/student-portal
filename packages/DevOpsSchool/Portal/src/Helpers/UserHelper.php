<?php

namespace Portal\Helpers;

use Portal\Models\User; 

class UserHelper
{

    public static function getUser($request){

        $parameter = [
            'filters' => $request['filters'],
            'user_data' => $request['user_data']
        ];

        $user = new User();
        $getuser = $user->findOne($parameter);

        if($getuser){

            return ['message' => 'success', 'data' => $getuser, 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to get data', 'status_code' => 500];
        }

    }

    public static function listUser($request){

        $parameter = [
            'count' => $request['user_data']['count'],
            'offset' => $request['user_data']['offset'],
            'parameter' => $request['user_data']['parameter']
        ];

        $user = new User();
        $listuser = $user->findAll($parameter);

        if($listuser){

            return ['message' => 'success', 'data' => $listuser, 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to list data', 'status_code' => 500];
        }


        
    }

    public static function updateUser($request){

        $parameter = [
            'id' => $request['id'],
            'user_data' => $request['user_data']
        ];

        $user = new User();
        $updateuser = $user->updateOne($parameter);

        if($updateuser){

            return ['message' => 'success', 'data' => 'Updated successfully', 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to update data', 'status_code' => 500];
        }

    }

    public static function deleteUser($request){

        $user = new User();
        $deleteuser = $user->deleteOne($request['id']);

        if($deleteuser){

            return ['message' => 'success', 'data' => 'deleted successfully', 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to delete data', 'status_code' => 500];
        }

    }
    
}