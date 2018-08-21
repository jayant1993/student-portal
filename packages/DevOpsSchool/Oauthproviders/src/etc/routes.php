<?php

$namespace = 'Oauthproviders\Controllers';

Route::group(['namespace' => $namespace], function(){

    /**
     * Google
     */

    Route::get('callback','Googlecontroller@oauthcallback');

    Route::get('google/redirect','Googlecontroller@redirect_call');

    Route::get('google/login','Googlecontroller@redirectGoogle');

   
    
    
});

