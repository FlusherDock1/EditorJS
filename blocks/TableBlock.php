<?php namespace ReaZzon\Editor\Blocks;

use ReaZzon\Editor\Classes\AbstractBlock;

class TableBlock extends AbstractBlock
{
    public function registerSettings(): array
    {
        return [
            'class' => 'Table',
        ];
    }

    public function registerValidations(): array
    {
        return [
            'withHeadings' => [
                'type' => 'bool'
            ],
            'content' => [
                'type' => 'array',
                'data' => [
                    '-' => [
                        'type' => 'array',
                        'data' => [
                            '-' => [
                                'type' => 'string',
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/blocks/js/tableBlock.js'
        ];
    }

    public function registerViews(): array
    {
        return [
            'reazzon.editor::blocks.table'
        ];
    }
}
