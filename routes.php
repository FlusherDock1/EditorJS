<?php

Route::group([
    'prefix' => 'reazzon/editorjs/tools',
    'middleware' => ['web']
], function () {
    Route::post('image/uploadFile', [\ReaZzon\Editor\Classes\Controllers\ImageToolController::class, 'upload']);
    Route::post('image/fetchUrl', [\ReaZzon\Editor\Classes\Controllers\ImageToolController::class, 'fetch']);
});
