<?php

$namespace = 'Storage\Controllers';

Route::group(['namespace' => $namespace, 'prefix' => 'api'], function(){

    Route::group(['middleware' => 'auth:api'], function(){

    });

    /**
     * Paytm
     */

    Route::post('storage/file/upload','Storagecontroller@add');

    Route::post('storage/file/list','Storagecontroller@list');

   
    
    
});

