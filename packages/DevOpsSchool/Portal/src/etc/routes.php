<?php

$namespace = 'Portal\Controllers';

Route::group(['namespace' => $namespace, 'prefix' => 'api'], function(){

    Route::group(['middleware' => 'auth:api'], function(){

    });

    Route::post('user/add','Usercontroller@adduser');

    Route::post('user/view','Usercontroller@getuser');

    Route::post('user/list','Usercontroller@listuser');

    Route::post('user/update','Usercontroller@updateuser');

    Route::post('user/delete','Usercontroller@deleteuser');

    Route::post('user/login','Usercontroller@login');

    Route::post('user/refresh','Usercontroller@refresh');
    
});

