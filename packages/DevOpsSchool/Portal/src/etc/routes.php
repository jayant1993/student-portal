<?php

$namespace = 'Portal\Controllers';

Route::group(['namespace' => $namespace, 'prefix' => 'api'], function(){

    Route::group(['middleware' => 'auth:api'], function(){

    });

    /**
     *  Session
     */

    
    Route::post('session/get','Usercontroller@getSession');


    /**
     * User
     */

    Route::post('user/add','Usercontroller@adduser');

    Route::post('user/view','Usercontroller@getuser');

    Route::post('user/list','Usercontroller@listuser');

    Route::post('user/update','Usercontroller@updateuser');

    Route::post('user/delete','Usercontroller@deleteuser');

    Route::post('user/login','Usercontroller@login');

    Route::post('user/refresh','Usercontroller@refresh');

    /**
     * Courses
     */

    Route::post('course/add','Coursecontroller@addcourse');

    Route::post('course/list','Coursecontroller@listcourse');

    Route::post('course/get','Coursecontroller@getcourse');

    Route::post('course/update','Coursecontroller@updatecourse');

    Route::post('course/delete','Coursecontroller@deletecourse');

    /**
     * Topics
     */

    Route::post('topic/add','Topiccontroller@addtopic');

    Route::post('topic/list','Topiccontroller@listtopic');

    Route::post('topic/get','Topiccontroller@gettopic');

    Route::post('topic/update','Topiccontroller@updatetopic');

    Route::post('topic/delete','Topiccontroller@deletetopic');


    /**
     * Videos
     */

    Route::post('video/add','Videocontroller@addvideo');

    Route::post('video/list','Videocontroller@listvideos');

    Route::post('video/get','Videocontroller@getvideo');

    Route::post('video/update','Videocontroller@updatevideo');

    Route::post('video/delete','Videocontroller@deletevideo');
    
    
});

