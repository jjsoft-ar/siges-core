<?php

/** Notifications Routes **/
Route::group(['middleware' => 'auth', 'namespace' => 'JJSoft\SigesCore\Http\Controllers'], function () {
    Route::get('notifications', ['as' => 'notifications.index', 'uses' => 'NotificationsController@index']);
    Route::get('notifications/{id}/read', ['as' => 'notifications.read', 'uses' => 'NotificationsController@read']);
});

/** Some Core Routes for API calls **/
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->group(['middleware' => ['api.auth'], 'providers' => ['inSession']], function ($api) {
        $api->group(['prefix' => 'core', 'namespace' => 'JJSoft\SigesCore\Http\Controllers'], function ($api) {
            $api->resource('entity/{id}/fields', 'Core\FieldsController', ['only' => ['index', 'store', 'update', 'destroy']]);
            $api->put('entity/{id}/order-fields', 'Core\FieldsController@reOrderFieldId');
            $api->get('field-type/{type}/form', 'Core\FieldsController@fieldTypeForm');
        });
    });
});
