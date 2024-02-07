<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\AbstractTool;

class TableTool extends AbstractTool
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
            '/plugins/reazzon/editor/assets/js/tableTool.js'
        ];
    }

    public function registerViews(): array
    {
        return [
            'reazzon.editor::blocks.table'
        ];
    }
}
