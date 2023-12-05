<?php namespace ReaZzon\Editor\Blocks;

use ReaZzon\Editor\Classes\AbstractBlock;

class RawBlock extends AbstractBlock
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
            '/plugins/reazzon/editor/blocks/js/rawBlock.js'
        ];
    }

    public function registerViews(): array
    {
        return [
            'reazzon.editor::blocks.raw'
        ];
    }
}
