<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\Tool;

class ParagraphTool extends Tool
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
            '/plugins/reazzon/editor/assets/js/paragraphTool.js'
        ];
    }

    public function registerView(): ?string
    {
        return 'reazzon.editor::blocks.paragraph';
    }
}
