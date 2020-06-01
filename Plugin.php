<?php namespace ReaZzon\Editor;

use Backend;
use System\Classes\PluginBase;

/**
 * Editor Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Editor',
            'description' => 'No description provided yet...',
            'author'      => 'ReaZzon',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'ReaZzon\Editor\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'reazzon.editor.some_permission' => [
                'tab' => 'Editor',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'editor' => [
                'label'       => 'Editor',
                'url'         => Backend::url('reazzon/editor/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['reazzon.editor.*'],
                'order'       => 500,
            ],
        ];
    }
}
