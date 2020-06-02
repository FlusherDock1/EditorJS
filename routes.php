<?php

Route::group(['prefix' => 'editorjs'], function (){

    Route::group(['prefix' => 'plugins'], function (){

        Route::any('linktool', function ($code){
            return (new ReaZzon\Editor\Classes\Plugins\LinkTool\Plugin)->createResponse($code);
        });

    });

});
