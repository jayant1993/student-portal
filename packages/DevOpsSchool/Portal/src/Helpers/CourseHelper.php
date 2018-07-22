<?php

namespace Portal\Helpers;

use Portal\Models\Course; 

class CourseHelper
{

    public static function addCourse($request){

        $parameter = [
            'id' => str_random(5),
            'course_name' => $request->course_name,
            'topics' => $request->topics,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->status
        ];

        $course = new Course();
        $addcourse = $course->pushOne($parameter);

        if($addcourse){

            return ['message' => 'success', 'data' => $addcourse, 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to get data', 'status_code' => 500];
        }

    }

    public static function getCourse($request){

        $parameter = [
            'filters' => $request['filters'],
            'course_data' => $request['course_data']
        ];

        $course = new Course();
        $getcourse = $course->findOne($parameter);

        if($getcourse){

            return ['message' => 'success', 'data' => $getcourse, 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to get data', 'status_code' => 500];
        }

    }

    public static function listCourses($request){

        $parameter = [
            'count' => $request['course_data']['count'],
            'offset' => $request['course_data']['offset'],
            'parameter' => $request['course_data']['parameter']
        ];

        $course = new Course();
        $listcourse = $course->findAll($parameter);

        if($listcourse){

            return ['message' => 'success', 'data' => $listcourse, 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to list data', 'status_code' => 500];
        }
        
    }

    public static function updateCourse($request){

        $parameter = [
            'id' => $request['id'],
            'course_data' => $request['course_data']
        ];

        $course = new Course();
        $updatecourse = $course->updateOne($parameter);

        if($updatecourse){

            return ['message' => 'success', 'data' => 'Updated successfully', 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to update data', 'status_code' => 500];
        }

    }

    public static function deleteCourse($request){

        $course = new Course();
        $deletecourse = $course->deleteOne($request['id']);

        if($deletecourse){

            return ['message' => 'success', 'data' => 'deleted successfully', 'status_code' => 200];
        } else{

            return ['message' => 'failed', 'data' => 'unable to delete data', 'status_code' => 500];
        }

    }
    
}