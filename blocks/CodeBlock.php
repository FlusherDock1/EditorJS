<?php namespace ReaZzon\Editor\Blocks;

use ReaZzon\Editor\Classes\AbstractEditorJsBlock;

class CodeBlock extends AbstractEditorJsBlock
{
    public function registerSettings(): array
    {
        return [
            'class' => 'CodeTool'
        ];
    }

    public function registerValidations(): array
    {
        return [
            'code' => [
                'type' => 'string'
            ]
        ];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/blocks/js/codeBlock.js'
        ];
    }

    public function registerViews(): array
    {
        return [
            'reazzon.editor::blocks.code'
        ];
    }
}
