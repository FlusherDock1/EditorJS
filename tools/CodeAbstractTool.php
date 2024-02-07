<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\AbstractTool;

class CodeAbstractTool extends AbstractTool
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

    public function registerViews(): array
    {
        return [
            'reazzon.editor::blocks.code'
        ];
    }
}
