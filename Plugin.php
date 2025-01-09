<?php namespace ReaZzon\Editor;

use Event;
use Backend;
use ReaZzon\Editor\Classes\Events\ExtendBlogPlugins;
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
    public function boot(): void
    {
        $this->addEventListeners();
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
     * registerEditorJsBlocks registers extension blocks for EditorJs
     */
    public function registerEditorJsTools(): array
    {
        return [
            \ReaZzon\Editor\Tools\ParagraphTool::class => 'paragraph',
            \ReaZzon\Editor\Tools\HeaderTool::class => 'header',
            \ReaZzon\Editor\Tools\ListTool::class => 'list',
            \ReaZzon\Editor\Tools\QuoteTool::class => 'quote',
            \ReaZzon\Editor\Tools\ImageTool::class => 'image',
            \ReaZzon\Editor\Tools\AttachesTool::class => 'attaches',
            \ReaZzon\Editor\Tools\TableTool::class => 'table',
            \ReaZzon\Editor\Tools\CodeAbstractTool::class => 'code',
            \ReaZzon\Editor\Tools\WarningTool::class => 'warning',
            \ReaZzon\Editor\Tools\DelimiterTool::class => 'delimiter',
            \ReaZzon\Editor\Tools\RawTool::class => 'raw',
            \ReaZzon\Editor\Tools\EmbedTool::class => 'embed',
            \ReaZzon\Editor\Tools\MarkerTool::class => 'marker',
            \ReaZzon\Editor\Tools\UnderlineTool::class => 'underline',
            \ReaZzon\Editor\Tools\InlineCodeTool::class => 'inlineCode',
        ];
    }

    /**
     * registerEditorJsTunes registers additional tunes for EditorJs
     */
    public function registerEditorJsTunes(): array
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

    private function addEventListeners(): void
    {
        Event::subscribe(ExtendBlogPlugins::class);
    }
}
