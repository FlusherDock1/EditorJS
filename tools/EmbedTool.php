<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\AbstractTool;

class EmbedTool extends AbstractTool
{
    public function registerSettings(): array
    {
        return [
            'class' => 'Embed',
            'inlineToolbar' => true,
            'config' => [
                'defaultStyle' => 'unordered'
            ]
        ];
    }

    public function registerValidations(): array
    {
        return [
            'service' => [
                'type' => 'string'
            ],
            'source' => [
                'type' => 'string'
            ],
            'embed' => [
                'type' => 'string'
            ],
            'width' => [
                'type' => 'int'
            ],
            'height' => [
                'type' => 'int'
            ],
            'caption' => [
                'type' => 'string',
                'required' => false
            ]
        ];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/assets/js/embedTool.js'
        ];
    }

    public function registerViews(): array
    {
        return [
            'reazzon.editor::blocks.list'
        ];
    }
}
