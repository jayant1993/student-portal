<?php

namespace Storage\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Storage\Helpers\StorageHelper;
use Storage\Helpers\FileHelper;

use App\Rules\ValidateData;

use Validator;
use Auth;


class Storagecontroller extends Controller
{
    
    public function add(Request $request){

        $validator = Validator::make($request->all(), [ 
            'file' => 'required'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $file = FileHelper::uploadFile($request->file);

        $storage = new StorageHelper();
        $object = $storage->addObject($file);

        return response()->json(["message" => $object['message'], "data" => $object['data']], $object['status_code']);        
    }


    public function list(Request $request){

        $storage = new StorageHelper();
        $object = $storage->listObjects();

        return response()->json(["message" => $object['message'], "data" => $object['data']], $object['status_code']);        
  
    }



    public function getcourse(Request $request){

        $validator = Validator::make($request->all(), [ 
            'filters' => 'required|array',
            'course_data' => ['required','array', new ValidateData] 
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $course = CourseHelper::getCourse($request);

        return response()->json(['message' => $course['message'], 'data' => $course['data']], $course['status_code']);

    }



    public function updatecourse(Request $request){

        $validator = Validator::make($request->all(), [ 
            'id' => 'required|exists:courses',
            'course_data' => 'required|array',
            'course_data.name' => 'sometimes|array',
            'course_data.status' => 'sometimes|in:inactive,active', 
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $course = CourseHelper::updateCourse($request);

        return response()->json(['message' => $course['message'], 'data' => $course['data']], $course['status_code']);


    }

    public function deletecourse(Request $request){

        $validator = Validator::make($request->all(), [ 
            'id' => 'required|exists:courses'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $course = CourseHelper::deleteCourse($request);

        return response()->json(['message' => $course['message'], 'data' => $course['data']], $course['status_code']);

    }


}
