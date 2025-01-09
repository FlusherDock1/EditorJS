<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\Tool;

class UnderlineTool extends Tool
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

    public function registerView(): ?string
    {
        return null;
    }
}
