<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\Tool;

class ListTool extends Tool
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

    public function registerView(): ?string
    {
        return 'reazzon.editor::blocks.list';
    }
}
