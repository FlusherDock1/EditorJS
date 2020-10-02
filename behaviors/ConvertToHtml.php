<?php namespace ReaZzon\Editor\Behaviors;

use View;

/**
 * Class ConvertableBehavior
 * @package ReaZzon\Editor\Classes\Behaviors
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class ConvertToHtml extends ConvertableBehavior
{
    /**
     * @var array Settings for validation
     */
    protected $validationSettings;

    /**
     * @var array Views for blocks
     */
    protected $blocksViews;

    /**
     * Converts json string to blocks
     * @param string $jsonField
     * @return string
     */
    public function convertJsonToHtml($jsonField)
    {
        return $this->startConverter($jsonField);
    }

    /**
     * @param \EditorJS\EditorJS $editor
     * @param array $blocks
     * @return mixed|string
     */
    public function processBlocks($editor, $blocks)
    {
        $htmlOutput = '<div class="editor-js-content">';

        foreach ($blocks as $block) {
            $viewBlock = array_get($this->blocksViews, $block['type']);
            if (!empty($viewBlock)) {
                $htmlOutput .= View::make($viewBlock, $block['data']);
            }
        }

        $htmlOutput .= '</div>';

        return html_entity_decode($htmlOutput);
    }
}