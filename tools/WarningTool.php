<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\AbstractTool;

class WarningTool extends AbstractTool
{
    public function registerSettings(): array
    {
        return [
            'class' => 'Warning',
            'inlineToolbar' => true,
            'shortcut' => 'CMD+SHIFT+W',
        ];
    }

    public function registerValidations(): array
    {
        return [
            'title' => [
                'type' => 'string'
            ],
            'message' => [
                'type' => 'string'
            ]
        ];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/assets/js/warningTool.js'
        ];
    }

    public function registerView(): ?string
    {
        return 'reazzon.editor::blocks.warning';
    }
}
