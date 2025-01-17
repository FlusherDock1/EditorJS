<?php namespace ReaZzon\Editor;

use Event;
use System\Classes\PluginBase;
use ReaZzon\Editor\Classes\JSONConverter;
use ReaZzon\Editor\Classes\Events\IntegrateEditorInPlugins;

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
     * registerSettings registers any backend configuration links used by this package.
     */
    public function registerSettings(): array
    {
        return [
            'settings' => [
                'label' => 'EditorJs settings',
                'description' => 'Manage plugin settings.',
                'category' => 'Editor',
                'icon' => 'icon-cog',
                'class' => \ReaZzon\Editor\Settings\Settings::class,
            ]
        ];
    }

    /**
     * registerMarkupTags registers Twig markup tags introduced by this package.
     */
    public function registerMarkupTags(): array
    {
        return [
            'filters' => [
                'editorjs' => [JSONConverter::class, 'convertAndGetHTML']
            ]
        ];
    }

    /**
     * registerEditorJsBlocks extension blocks for EditorJs
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
            \ReaZzon\Editor\Tools\CodeTool::class => 'code',
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
     * registerEditorJsTunes extension tunes for blocks of EditorJs
     */
    public function registerEditorJsTunes(): array
    {
        return [
            \ReaZzon\Editor\Tunes\TextVariantTune::class => 'textVariant'
        ];
    }

    private function addEventListeners(): void
    {
        Event::subscribe(IntegrateEditorInPlugins::class);
    }
}
