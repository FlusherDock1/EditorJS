<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\AbstractTool;

class ListTool extends AbstractTool
{
    public function registerSettings(): array
    {
        return [
            'class' => 'List',
            'inlineToolbar' => true,
            'config' => [
                'defaultStyle' => 'unordered'
            ]
        ];
    }

    public function registerValidations(): array
    {
        return [
            'style' => [
                'type' => 'string'
            ],
            'items' => [
                'type' => 'array',
                'data' => [
                    '-' => [
                        'type' => 'string',
                        'allowedTags' => 'i,b,u'
                    ]
                ]
            ]
        ];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/assets/js/listTool.js'
        ];
    }

    public function registerViews(): array
    {
        return [
            'reazzon.editor::blocks.list'
        ];
    }
}
