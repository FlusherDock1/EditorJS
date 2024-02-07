<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\AbstractTool;

class RawTool extends AbstractTool
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

    public function registerViews(): array
    {
        return [
            'reazzon.editor::blocks.raw'
        ];
    }
}
