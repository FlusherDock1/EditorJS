<?php namespace ReaZzon\Editor;

use Backend;
use System\Classes\PluginBase;

/**
 * Plugin Information File
 *
 * @link https://docs.octobercms.com/3.x/extend/system/plugins.html
 */
class Plugin extends PluginBase
{
    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails(): array
    {
        return [
            'name' => 'reazzon.editor::lang.plugin.name',
            'description' => 'reazzon.editor::lang.plugin.description',
            'author' => 'Nick Khaetsky',
            'icon' => 'icon-pencil-square-o',
            'homepage' => 'https://github.com/FlusherDock1/EditorJS'
        ];
    }

    /**
     * register method, called when the plugin is first registered.
     */
    public function register()
    {
        //
    }

    /**
     * boot method, called right before the request route.
     */
    public function boot()
    {
        //
    }

    /**
     * registerFormWidgets registers any form widgets implemented in this package.
     */
    public function registerFormWidgets(): array
    {
        return [
            \ReaZzon\Editor\FormWidgets\EditorJs::class => 'editorjs',
        ];
    }

    /**
     * registerEditorJsBlocks registers additional blocks for EditorJs
     */
    public function registerEditorJsBlocks(): array
    {
        return [
            \ReaZzon\Editor\Blocks\ParagraphBlock::class => 'paragraph',
            \ReaZzon\Editor\Blocks\HeaderBlock::class => 'header',
            \ReaZzon\Editor\Blocks\ListBlock::class => 'list',
            \ReaZzon\Editor\Blocks\QuoteBlock::class => 'quote',
            \ReaZzon\Editor\Blocks\TableBlock::class => 'table',
            \ReaZzon\Editor\Blocks\CodeBlock::class => 'code',
            \ReaZzon\Editor\Blocks\WarningBlock::class => 'warning',
            \ReaZzon\Editor\Blocks\DelimiterBlock::class => 'delimiter',
            \ReaZzon\Editor\Blocks\RawBlock::class => 'raw'
        ];
    }

    /**
     * registerEditorJsTunes registers additional tunes for EditorJs
     */
    public function registerEditorJsTunes(): array
    {
        return [
            \ReaZzon\Editor\Tools\MarkerTool::class => 'marker'
        ];
    }

    /**
     * registerEditorJsInlineToolbar registers additional inline toolbar for EditorJs
     */
    public function registerEditorJsInlineToolbar(): array
    {
        return [];
    }

    /**
     * registerComponents used by the frontend.
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'ReaZzon\Editor\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * registerPermissions used by the backend.
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
     * registerNavigation used by the backend.
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'editor' => [
                'label' => 'Editor',
                'url' => Backend::url('reazzon/editor/mycontroller'),
                'icon' => 'icon-leaf',
                'permissions' => ['reazzon.editor.*'],
                'order' => 500,
            ],
        ];
    }
}
