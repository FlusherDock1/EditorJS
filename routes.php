<?php

Route::group([
    'prefix' => 'reazzon/editorjs/tools',
    'middleware' => ['web']
], function () {

    Route::group([
        'prefix' => 'image',
        'controller' => \ReaZzon\Editor\Classes\Controllers\ImageToolController::class
    ], function () {

        Route::post('uploadFile', 'upload');
        Route::post('fetchUrl', 'fetch');

    });

    Route::group([
        'prefix' => 'attaches',
        'controller' => \ReaZzon\Editor\Classes\Controllers\AttachesToolController::class
    ], function () {

        Route::post('', 'upload');

    });

});
