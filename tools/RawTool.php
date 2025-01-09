<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\Tool;

class RawTool extends Tool
{
    public function registerSettings(): array
    {
        return [
            'class' => 'RawTool'
        ];
    }

    public function registerValidations(): array
    {
        return [
            'html' => [
                'type' => 'string',
                'allowedTags' => '*',
            ]
        ];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/assets/js/rawTool.js'
        ];
    }

    public function registerView(): ?string
    {
        return 'reazzon.editor::blocks.raw';
    }
}
