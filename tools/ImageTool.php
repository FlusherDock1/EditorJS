<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\Tool;

class ImageTool extends Tool
{
    public function registerSettings(): array
    {
        return [
            'class' => 'ImageTool',
            'config' => [
                'endpoints' => [
                    'byFile' => url('/reazzon/editorjs/tools/image/uploadFile'),
                    'byUrl' => url('/reazzon/editorjs/tools/image/fetchUrl')
                ]
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
                    ]
                ]
            ],
            'caption' => [
                'type' => 'string'
            ],
            'withBorder' => [
                'type' => 'boolean'
            ],
            'withBackground' => [
                'type' => 'boolean'
            ],
            'stretched' => [
                'type' => 'boolean'
            ]
        ];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/assets/js/imageTool.js'
        ];
    }

    public function registerView(): ?string
    {
        return 'reazzon.editor::blocks.image';
    }
}
