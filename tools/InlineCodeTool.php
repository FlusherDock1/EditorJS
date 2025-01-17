<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\Tool;

class InlineCodeTool extends Tool
{
    public function registerSettings(): array
    {
        return [
            'class' => 'InlineCode'
        ];
    }

    public function registerValidations(): array
    {
        return [];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/assets/js/inline-codeTool.js'
        ];
    }

    public function registerView(): ?string
    {
        return null;
    }
}
