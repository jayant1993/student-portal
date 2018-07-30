<?php

namespace Portal\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Portal\Helpers\TopicHelper;
use App\Rules\ValidateData;

use Validator;
use Auth;


class Topiccontroller extends Controller
{

    
    public function addtopic(Request $request){

        $validator = Validator::make($request->all(), [ 
            'topic_name' => 'required',
            'topic_description' => 'sometimes',
            'video' => 'sometimes',
            'status' => 'required|in:active,inactive'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $topic = TopicHelper::addTopic($request);

        return response()->json(["message" => $topic['message'], "data" => $topic['data']], $topic['status_code']);        
    }


    public function listtopic(Request $request){

        $validator = Validator::make($request->all(), [ 
            'topic_data' => 'required|array',
            'topic_data.parameter' => ['required','array', new ValidateData],
            'topic_data.count' => 'required|integer',
            'topic_data.offset' => 'required|integer'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $topic = TopicHelper::listTopics($request);

        return response()->json(['message' => $topic['message'], 'data' => $topic['data']], $topic['status_code']);

    }



    public function gettopic(Request $request){

        $validator = Validator::make($request->all(), [ 
            'filters' => 'required|array',
            'topic_data' => ['required','array', new ValidateData] 
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $topic = TopicHelper::getTopic($request);

        return response()->json(['message' => $topic['message'], 'data' => $topic['data']], $topic['status_code']);

    }


    // not updated
    public function updatetopic(Request $request){

        $validator = Validator::make($request->all(), [ 
            'id' => 'required|exists:topics',
            'topic_data' => 'required|array', 
            'topic_data.topic_name' => 'sometimes|array',
            'topic_data.course_id' => 'sometimes|exists:courses,id',
            'topic_data.price' => 'sometimes|numeric',
            'topic_data.status' => 'sometimes|in:inactive,active', 
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $topic = TopicHelper::updateTopic($request);

        return response()->json(['message' => $topic['message'], 'data' => $topic['data']], $topic['status_code']);


    }

    public function deletetopic(Request $request){

        $validator = Validator::make($request->all(), [ 
            'id' => 'required|exists:topics'
        ]);
        
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $topic = TopicHelper::deleteTopic($request);

        return response()->json(['message' => $topic['message'], 'data' => $topic['data']], $topic['status_code']);

    }


}
