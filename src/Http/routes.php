<?php

/** Notifications Routes **/
Route::group(['middleware' => 'auth', 'namespace' => 'JJSoft\SigesCore\Http\Controllers'], function () {
    Route::get('notifications', ['as' => 'notifications.index', 'uses' => 'NotificationsController@index']);
    Route::get('notifications/{id}/read', ['as' => 'notifications.read', 'uses' => 'NotificationsController@read']);
});


