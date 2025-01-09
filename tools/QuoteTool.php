<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\AbstractTool;

class QuoteTool extends AbstractTool
{
    public function registerSettings(): array
    {
        return [
            'class' => 'Quote',
            'inlineToolbar' => true,
            'shortcut' => 'CMD+SHIFT+O',
        ];
    }

    public function registerValidations(): array
    {
        return [
            'text' => [
                'type' => 'string'
            ],
            'caption' => [
                'type' => 'string'
            ],
            'alignment' => [
                'type' => 'string'
            ]
        ];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/assets/js/quoteTool.js'
        ];
    }

    public function registerView(): ?string
    {
        return 'reazzon.editor::blocks.quote';
    }
}
