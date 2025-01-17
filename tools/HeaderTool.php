<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\Tool;

class HeaderTool extends Tool
{
    public function registerSettings(): array
    {
        return [
            'class' => 'Header',
            'shortcut' => 'CMD+SHIFT+H'
        ];
    }

    public function registerValidations(): array
    {
        return [
            'text' => [
                'type' => 'string'
            ],
            'level' => [
                'type' => 'int',
                'canBeOnly' => [1, 2, 3, 4, 5]
            ]
        ];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/assets/js/headerTool.js'
        ];
    }

    public function registerView(): ?string
    {
        return 'reazzon.editor::blocks.heading';
    }
}
