<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\AbstractTool;

class UnderlineTool extends AbstractTool
{
    public function registerSettings(): array
    {
        return [
            'class' => 'Underline'
        ];
    }

    public function registerValidations(): array
    {
        return [];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/assets/js/underlineTool.js'
        ];
    }

    public function registerViews(): array
    {
        return [];
    }
}
