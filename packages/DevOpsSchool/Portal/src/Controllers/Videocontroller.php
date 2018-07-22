<?php

namespace Portal\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Portal\Helpers\VideoHelper;
use App\Rules\ValidateData;

use Validator;
use Auth;


class Videocontroller extends Controller
{
    
    public function addvideo(Request $request){

        $validator = Validator::make($request->all(), [ 
            'video_title' => 'required',
            'video_description' => 'sometimes',
            'video' => 'required',
            'status' => 'required|in:active,inactive'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $video = VideoHelper::addVideo($request);

        return response()->json(["message" => $video['message'], "data" => $video['data']], $video['status_code']);        
    }


    public function listvideos(Request $request){

        $validator = Validator::make($request->all(), [ 
            'video_data' => 'required|array',
            'video_data.parameter' => ['required','array', new ValidateData],
            'video_data.count' => 'required|integer',
            'video_data.offset' => 'required|integer'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $videos = VideoHelper::listVideos($request);

        return response()->json(['message' => $videos['message'], 'data' => $videos['data']], $videos['status_code']);

    }



    public function getvideo(Request $request){

        $validator = Validator::make($request->all(), [ 
            'filters' => 'required|array',
            'video_data' => ['required','array', new ValidateData] 
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $video = VideoHelper::getVideo($request);

        return response()->json(['message' => $video['message'], 'data' => $video['data']], $video['status_code']);

    }


    public function deletevideo(Request $request){

        $validator = Validator::make($request->all(), [ 
            'id' => 'required|exists:videos'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $video = VideoHelper::deleteCourse($request);

        return response()->json(['message' => $video['message'], 'data' => $video['data']], $video['status_code']);

    }


}
