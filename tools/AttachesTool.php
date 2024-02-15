<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\AbstractTool;

class AttachesTool extends AbstractTool
{
    public function registerSettings(): array
    {
        return [
            'class' => 'AttachesTool',
            'config' => [
                'endpoint' => url('/reazzon/editorjs/tools/attaches')
            ]
        ];
    }

    public function registerValidations(): array
    {
        return [
            'file' => [
                'type' => 'array',
                'data' => [
                    'url' => [
                        'type' => 'string'
                    ],
                    'size' => [
                        'type' => 'int'
                    ],
                    'name' => [
                        'type' => 'string'
                    ],
                    'extension' => [
                        'type' => 'string'
                    ]
                ]
            ],
            'title' => [
                'type' => 'string'
            ]
        ];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/assets/js/attachesTool.js'
        ];
    }

    public function registerViews(): array
    {
        return [
            'reazzon.editor::blocks.attach'
        ];
    }
}
