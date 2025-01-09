<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\Tool;

class CodeTool extends Tool
{
    public function registerSettings(): array
    {
        return [
            'class' => 'CodeTool'
        ];
    }

    public function registerValidations(): array
    {
        return [
            'code' => [
                'type' => 'string'
            ]
        ];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/assets/js/codeTool.js'
        ];
    }

    public function registerView(): ?string
    {
        return 'reazzon.editor::blocks.code';
    }
}
