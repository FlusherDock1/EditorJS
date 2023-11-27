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
            'paragraph' => [
                'validation' => [
                    'text' => [
                        'type' => 'string',
                        'allowedTags' => 'i,b,u,a[href],span[class],code[class],mark[class]'
                    ]
                ],
                'view' => 'reazzon.editor::blocks.paragraph'
            ],
            'header' => [
                'settings' => [
                    'class' => 'Header',
                    'shortcut' => 'CMD+SHIFT+H',
                ],
                'validation' => [
                    'text' => [
                        'type' => 'string',
                    ],
                    'level' => [
                        'type' => 'int',
                        'canBeOnly' => [1, 2, 3, 4, 5]
                    ]
                ],
                'scripts' => [
                    '/plugins/reazzon/editor/blocks/header/js/block.js',
                ],
                'view' => 'reazzon.editor::blocks.heading'
            ],
            'quote' => [
                'settings' => [
                    'class' => 'Quote',
                    'inlineToolbar' => true,
                    'shortcut' => 'CMD+SHIFT+O',
                ],
                'validation' => [
                    'text' => [
                        'type' => 'string'
                    ],
                    'caption' => [
                        'type' => 'string'
                    ],
                    'alignment' => [
                        'type' => 'string'
                    ]
                ],
                'scripts' => [
                    '/plugins/reazzon/editor/blocks/quote/js/block.js'
                ],
                'view' => 'reazzon.editor::blocks.quote'
            ],
            'warning' => [
                'settings' => [
                    'class' => 'Warning',
                    'inlineToolbar' => true,
                    'shortcut' => 'CMD+SHIFT+W',
                ],
                'validation' => [
                    'title' => [
                        'type' => 'string'
                    ],
                    'message' => [
                        'type' => 'string'
                    ]
                ],
                'scripts' => [
                    '/plugins/reazzon/editor/blocks/warning/js/block.js'
                ],
                'view' => 'reazzon.editor::blocks.warning'
            ],
            'delimiter' => [
                'settings' => [
                    'class' => 'Delimiter',
                ],
                'validation' => [],
                'scripts' => [
                    '/plugins/reazzon/editor/blocks/delimiter/js/block.js'
                ],
                'view' => 'reazzon.editor::blocks.delimiter'
            ]
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
