<?php

use ReaZzon\Editor\Classes\Controllers\ImageToolController;
use ReaZzon\Editor\Classes\Controllers\AttachesToolController;

Route::group(['prefix' => 'reazzon/editorjs/tools', 'middleware' => ['web']], function () {

    Route::group(['prefix' => 'image', 'controller' => ImageToolController::class], function () {
        Route::post('uploadFile', 'upload');
        Route::post('fetchUrl', 'fetch');
    });

    Route::group(['prefix' => 'attaches', 'controller' => AttachesToolController::class], function () {
        Route::post('', 'upload');
    });

});
