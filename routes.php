<?php

Route::group(['prefix' => 'editorjs'], function (){

    Route::group(['prefix' => 'plugins'], function (){

        Route::any('linktool', function (){
            return (new ReaZzon\Editor\Classes\Plugins\LinkTool\Plugin)->createResponse(\Input::all());
        });

    });

});
