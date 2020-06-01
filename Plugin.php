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
