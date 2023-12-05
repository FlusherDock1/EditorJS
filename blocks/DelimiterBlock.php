<?php namespace ReaZzon\Editor\Blocks;

use ReaZzon\Editor\Classes\AbstractBlock;

class DelimiterBlock extends AbstractBlock
{
    public function registerSettings(): array
    {
        return [
            'class' => 'Delimiter',
        ];
    }

    public function registerValidations(): array
    {
        return [];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/blocks/js/delimiterBlock.js'
        ];
    }

    public function registerViews(): array
    {
        return [
            'reazzon.editor::blocks.delimiter'
        ];
    }
}
