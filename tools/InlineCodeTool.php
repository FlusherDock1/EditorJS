<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\AbstractTool;

class InlineCodeTool extends AbstractTool
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
