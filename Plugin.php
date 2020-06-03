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
            'description' => 'Next generation block styled editor.',
            'author'      => 'Nick Khaetsky',
            'icon'        => 'icon-pencil-square-o',
            'homepage'    => 'https://github.com/FlusherDock1/EditorJS'
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

    public function registerEditorJSPlugins()
    {
        return [
            'ReaZzon\Editor\Classes\Plugins\LinkTool\Plugin' => 'linkTool'
        ];
    }
}
