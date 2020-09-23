<?php namespace ReaZzon\Editor\Traits;

use Config, View;
use EditorJS\EditorJS;
use EditorJS\EditorJSException;

/**
 * Trait ConvertEditor
 * Some code was borrowed from https://github.com/advoor/nova-editor-js/blob/master/src/NovaEditorJs.php
 *
 * @package ReaZzon\Editor\Traits
 * @author Nick Khaetsky, nick@reazzon.ru
 */
trait ConvertEditor
{
    public function convertJsonToHtml($jsonField)
    {
        $config = Config::get('reazzon.editor::validationSettings');

        try {
            // Initialize Editor backend and validate structure
            $editor = new EditorJS($jsonField, json_encode($config));

            // Get sanitized blocks (according to the rules from configuration)
            $blocks = $editor->getBlocks();

            $htmlOutput = '<div class="editor-js-content">';

            foreach ($blocks as $block) {
                switch ($block['type']) {
                    case 'header':
                        $htmlOutput .= View::make('reazzon.editor::blocks.heading', $block['data']);;
                        break;
                    case 'paragraph':
                        $htmlOutput .= View::make('reazzon.editor::blocks.paragraph', $block['data']);
                        break;
                    case 'list':
                        $htmlOutput .= View::make('reazzon.editor::blocks.list', $block['data']);
                        break;
                    case 'image':
                        $block['data']['classes'] = $this->calculateImageClasses($block['data']);
                        $htmlOutput .= View::make('reazzon.editor::blocks.image', $block['data']);
                        break;
                    case 'code':
                        $htmlOutput .= View::make('reazzon.editor::blocks.code', $block['data']);
                        break;
                    case 'linkTool':
                        $htmlOutput .= View::make('reazzon.editor::blocks.link', $block['data']);
                        break;
                    case 'checklist':
                        $htmlOutput .= View::make('reazzon.editor::blocks.checklist', $block['data']);
                        break;
                    case 'delimiter':
                        $htmlOutput .= View::make('reazzon.editor::blocks.delimiter', $block['data']);
                        break;
                    case 'table':
                        $htmlOutput .= View::make('reazzon.editor::blocks.table', $block['data']);
                        break;
                    case 'raw':
                        $htmlOutput .= View::make('reazzon.editor::blocks.raw', $block['data']);
                        break;
                    case 'embed':
                        $htmlOutput .= View::make('reazzon.editor::blocks.embed', $block['data']);
                        break;
                    case 'quote':
                        $htmlOutput .= View::make('reazzon.editor::blocks.quote', $block['data']);
                        break;
                }
            }

            $htmlOutput .= '</div>';

            return html_entity_decode($htmlOutput);
        } catch (EditorJSException $e) {
            // process exception
            return 'Something went wrong: ' . $e->getMessage();
        }
    }

    /**
     * @param $blockData
     * @return string
     */
    public function calculateImageClasses($blockData)
    {
        $classes = [];
        foreach ($blockData as $key => $data) {
            if (is_bool($data) && $data === true) {
                $classes[] = $key;
            }
        }

        return implode(' ', $classes);
    }
}