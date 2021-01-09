<?php
\Illuminate\Support\Facades\App::before(function() {
    Route::group(['prefix' => 'editorjs'], function () {
        Route::group([
            'prefix' => 'plugins',
            'middleware' => \ReaZzon\Editor\Classes\Middlewares\PluginGroupMiddleware::class
        ], function () {
            Route::any('linktool', \ReaZzon\Editor\Classes\Plugins\LinkTool\Plugin::class);
            Route::any('image/{type}', \ReaZzon\Editor\Classes\Plugins\Image\Plugin::class);
            Route::any('attaches', \ReaZzon\Editor\Classes\Plugins\Attaches\Plugin::class);
        });
    });
});
