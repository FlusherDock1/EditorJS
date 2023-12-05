<?php namespace ReaZzon\Editor\Blocks;

use ReaZzon\Editor\Classes\AbstractBlock;

class WarningBlock extends AbstractBlock
{
    public function registerSettings(): array
    {
        return [
            'class' => 'Warning',
            'inlineToolbar' => true,
            'shortcut' => 'CMD+SHIFT+W',
        ];
    }

    public function registerValidations(): array
    {
        return [
            'title' => [
                'type' => 'string'
            ],
            'message' => [
                'type' => 'string'
            ]
        ];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/blocks/js/warningBlock.js'
        ];
    }

    public function registerViews(): array
    {
        return [
            'reazzon.editor::blocks.warning'
        ];
    }
}
