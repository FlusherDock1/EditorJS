<?php namespace ReaZzon\Editor\Blocks;

use ReaZzon\Editor\Classes\AbstractEditorJsBlock;

class HeaderBlock extends AbstractEditorJsBlock
{
    public function registerSettings(): array
    {
        return [
            'class' => 'Header',
            'shortcut' => 'CMD+SHIFT+H'
        ];
    }

    public function registerValidations(): array
    {
        return [
            'text' => [
                'type' => 'string',
            ],
            'level' => [
                'type' => 'int',
                'canBeOnly' => [1, 2, 3, 4, 5]
            ]
        ];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/blocks/js/headerBlock.js'
        ];
    }

    public function registerViews(): array
    {
        return [
            'reazzon.editor::blocks.heading'
        ];
    }
}
