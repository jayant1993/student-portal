<?php

namespace Portal\Helpers;

use Portal\Models\Video;
use Portal\Helpers\VideoHelper;
use Storage\Helpers\StorageHelper;
use Storage\Helpers\FileHelper;

class VideoHelper
{

    public static function addVideo($request){


        $file = FileHelper::uploadFile($request->video);

        $storage = new StorageHelper();
        $object = $storage->addObject($file);

        if($object['status_code'] != 200){

            return ['message' => 'failed', 'data' => 'unable to upload video', 'status_code' => 500];
        }

        $parameter = [
            'id' => str_random(5),
            'video_title' => $request->video_title,
            'video_description' => $request->video_description,
            'video' => $object['data'],
            'status' => $request->status
        ];

        $video = new Video();
        $addvideo = $video->pushOne($parameter);

        if($addvideo){

            return ['message' => 'success', 'data' => $addvideo, 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to get data', 'status_code' => 500];
        }

    }

    public static function getVideo($request){

        $parameter = [
            'filters' => $request['filters'],
            'video_data' => $request['video_data']
        ];

        $video = new Video();
        $getvideo = $video->findOne($parameter);

        if($getvideo){

            return ['message' => 'success', 'data' => $getvideo, 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to get data', 'status_code' => 500];
        }

    }

    public static function listVideos($request){

        $parameter = [
            'count' => $request['video_data']['count'],
            'offset' => $request['video_data']['offset'],
            'parameter' => $request['video_data']['parameter']
        ];

        $video = new Video();
        $listvideo = $video->findAll($parameter);

        if($listvideo){

            return ['message' => 'success', 'data' => $listvideo, 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to list data', 'status_code' => 500];
        }
        
    }

    public static function deleteVideo($request){

        $video = new Video();
        $deletevideo = $video->deleteOne($request['id']);

        if($deletevideo){

            return ['message' => 'success', 'data' => 'deleted successfully', 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to delete data', 'status_code' => 500];
        }

    }
    
}