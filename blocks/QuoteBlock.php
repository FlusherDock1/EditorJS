<?php namespace ReaZzon\Editor\Blocks;

use ReaZzon\Editor\Classes\AbstractBlock;

class QuoteBlock extends AbstractBlock
{
    public function registerSettings(): array
    {
        return [
            'class' => 'Quote',
            'inlineToolbar' => true,
            'shortcut' => 'CMD+SHIFT+O',
        ];
    }

    public function registerValidations(): array
    {
        return [
            'text' => [
                'type' => 'string'
            ],
            'caption' => [
                'type' => 'string'
            ],
            'alignment' => [
                'type' => 'string'
            ]
        ];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/blocks/js/quoteBlock.js'
        ];
    }

    public function registerViews(): array
    {
        return [
            'reazzon.editor::blocks.quote'
        ];
    }
}
