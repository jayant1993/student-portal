<?php

$namespace = 'Oauthproviders\Controllers';

Route::group(['namespace' => $namespace], function(){

    /**
     * Google
     */

    Route::get('callback','Googlecontroller@oauthcallback');

    Route::get('google/get/user','Googlecontroller@getUser');

    Route::get('google/login','Googlecontroller@redirectGoogle');

   
    
    
});

