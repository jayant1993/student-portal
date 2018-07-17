<?php

namespace Portal\Helpers;

use Portal\Models\Topic; 

class TopicHelper
{

    public static function addTopic($request){

        $parameter = [
            'id' => str_random(5),
            'topic_name' => $request->topic_name,
            'description' => $request->description,
            'video' => $request->video,
            'status' => $request->status
        ];

        $topic = new Topic();
        $addtopic = $topic->pushOne($parameter);

        if($addtopic){

            return ['message' => 'success', 'data' => $addtopic, 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to get data', 'status_code' => 500];
        }

    }


    public static function getTopic($request){

        $parameter = [
            'filters' => $request['filters'],
            'topic_data' => $request['topic_data']
        ];

        $topic = new Topic();
        $gettopic = $topic->findOne($parameter);

        if($gettopic){

            return ['message' => 'success', 'data' => $gettopic, 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to get data', 'status_code' => 500];
        }

    }

    public static function listTopics($request){

        $parameter = [
            'count' => $request['topic_data']['count'],
            'offset' => $request['topic_data']['offset'],
            'parameter' => $request['topic_data']['parameter']
        ];

        $topic = new Topic();
        $listtopics = $topic->findAll($parameter);

        if($listtopics){

            return ['message' => 'success', 'data' => $listtopics, 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to list data', 'status_code' => 500];
        }


        
    }

    public static function updateTopic($request){

        $parameter = [
            'id' => $request['id'],
            'topic_data' => $request['topic_data']
        ];

        $topic = new Topic();
        $updatetopic = $topic->updateOne($parameter);

        if($updatetopic){

            return ['message' => 'success', 'data' => 'Updated successfully', 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to update data', 'status_code' => 500];
        }

    }

    public static function deleteTopic($request){

        $topic = new Topic();
        $deletetopic = $topic->deleteOne($request['id']);

        if($deletetopic){

            return ['message' => 'success', 'data' => 'deleted successfully', 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to delete data', 'status_code' => 500];
        }

    }
    
}