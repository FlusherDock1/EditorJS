<?php namespace ReaZzon\Editor;

use Backend, Event;
use System\Classes\PluginBase;

use ReaZzon\Editor\Classes\Event\ExtendRainLabBlog;
use ReaZzon\Editor\Classes\Event\ExtendRainLabStaticPages;
use ReaZzon\Editor\Classes\Event\ExtendIndicatorNews;
use ReaZzon\Editor\Classes\Event\ExtendLovataGoodNews;

/**
 * Editor Plugin Information File
 * @package ReaZzon\Editor
 * @author Nick Khaetsky, rzzsapb@gmail.com
 */
class Plugin extends PluginBase
{
    /** @var array Plugin dependencies */
    public $require = ['October.Drivers'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'reazzon.editor::lang.plugin.name',
            'description' => 'reazzon.editor::lang.plugin.description',
            'author'      => 'Nick Khaetsky',
            'icon'        => 'icon-pencil-square-o',
            'homepage'    => 'https://github.com/FlusherDock1/EditorJS'
        ];
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array|void
     */
    public function boot()
    {
        Event::subscribe(ExtendRainLabBlog::class);
        Event::subscribe(ExtendRainLabStaticPages::class);
        Event::subscribe(ExtendLovataGoodNews::class);
        Event::subscribe(ExtendIndicatorNews::class);
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'reazzon.editor.access_settings' => [
                'tab'   => 'reazzon.editor::lang.plugin.name',
                'label' => 'reazzon.editor::lang.permission.access_settings'
            ],
        ];
    }

    /**
     * Registers settings for this plugin
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'reazzon.editor::lang.settings.menu_label',
                'description' => 'reazzon.editor::lang.settings.menu_description',
                'category'    => 'reazzon.editor::lang.plugin.name',
                'class'       => 'ReaZzon\Editor\Models\Settings',
                'permissions' => ['reazzon.editor.access_settings'],
                'icon'        => 'icon-cog',
                'order'       => 500,
            ]
        ];
    }

    /**
     * Registers formWidgets.
     *
     * @return array
     */
    public function registerFormWidgets()
    {
        return [
            'ReaZzon\Editor\FormWidgets\EditorJS' => 'editorjs',
        ];
    }
}
