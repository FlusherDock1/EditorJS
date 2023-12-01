<?php namespace ReaZzon\Editor\Blocks;

use ReaZzon\Editor\Classes\AbstractEditorJsBlock;

class ParagraphBlock extends AbstractEditorJsBlock
{
    public function registerSettings(): array
    {
        return [
            'class' => 'Paragraph',
            'inlineToolbar' => true
        ];
    }

    public function registerValidations(): array
    {
        return [
            'text' => [
                'type' => 'string',
                'allowedTags' => 'i,b,u,a[href],span[class],code[class],mark[class]'
            ]
        ];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/blocks/js/paragraphBlock.js'
        ];
    }

    public function registerViews(): array
    {
        return [
            'reazzon.editor::blocks.paragraph'
        ];
    }
}
