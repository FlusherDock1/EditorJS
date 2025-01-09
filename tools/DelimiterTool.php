<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\AbstractTool;

class DelimiterTool extends AbstractTool
{
    public function registerSettings(): array
    {
        return [
            'class' => 'Delimiter'
        ];
    }

    public function registerValidations(): array
    {
        return [];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/assets/js/delimiterTool.js'
        ];
    }

    public function registerView(): ?string
    {
        return 'reazzon.editor::blocks.delimiter';
    }
}
