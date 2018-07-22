<?php

namespace Portal\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Portal\Helpers\CourseHelper;
use App\Rules\ValidateData;

use Validator;
use Auth;


class Coursecontroller extends Controller
{

    
    public function addcourse(Request $request){

        $validator = Validator::make($request->all(), [ 
            'course_name' => 'required',
            'course_thumb' => 'sometimes', //future validation for thubnail images
            'topics' => 'required|array', //future topics validation should be there
            'description' => 'sometimes',
            'price' => 'required',
            'status' => 'required|in:active,inactive'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $course = CourseHelper::addCourse($request);

        return response()->json(["message" => $course['message'], "data" => $course['data']], $course['status_code']);        
    }


    public function listcourse(Request $request){

        $validator = Validator::make($request->all(), [ 
            'course_data' => 'required|array',
            'course_data.parameter' => ['required','array', new ValidateData],
            'course_data.count' => 'required|integer',
            'course_data.offset' => 'required|integer'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $course = CourseHelper::listCourses($request);

        return response()->json(['message' => $course['message'], 'data' => $course['data']], $course['status_code']);

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
