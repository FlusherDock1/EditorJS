<?php

Route::group(['prefix' => 'editorjs'], function () {

    Route::group(['prefix' => 'plugins'], function () {

        Route::any('linktool', function () {
            return (new ReaZzon\Editor\Classes\Plugins\LinkTool\Plugin)->createResponse(\Input::all());
        });

        Route::any('image/{type}', function ($type) {
            return (new ReaZzon\Editor\Classes\Plugins\Image\Plugin)->createResponse($type, \Input::all());
        });

        Route::any('attaches', function () {
            return (new ReaZzon\Editor\Classes\Plugins\Attaches\Plugin)->createResponse(\Input::all());
        });

    });

});