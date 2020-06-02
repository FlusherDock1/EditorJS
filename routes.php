<?php

Route::group(['prefix' => 'editorjs'], function (){

    Route::group(['prefix' => 'plugins'], function (){

        Route::any('{plugin}', function ($code){
            return \ReaZzon\Editor\Classes\PluginsManager::instance()->getPluginResponse($code);
        });

    });

    Route::get('save', function (){
        return \ReaZzon\Editor\Classes\EditorSave::save();
    });
});
