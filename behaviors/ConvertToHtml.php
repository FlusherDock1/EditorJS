<?php namespace ReaZzon\Editor\Behaviors;

use View;
use EditorJS\EditorJS;
use \Cms\Classes\Theme;
use \Cms\Classes\Partial;
use \Cms\Classes\Controller;

/**
 * Class ConvertableBehavior
 * @package ReaZzon\Editor\Classes\Behaviors
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class ConvertToHtml extends ConvertableBehavior
{
    const FOLDER_NAME = 'editorjs';

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
    public function convertJsonToHtml(string $jsonField): string
    {
        $this->getTemplatePartialsOptions();
        return $this->startConverter($jsonField);
    }

    public static function getTemplatePartialsOptions(): array
    {
        $blocksPartials = [];
        $theme = Theme::getEditTheme();
        $partials = Partial::listInTheme($theme, true);

        foreach ($partials as $partial) {
            $partialFilePath = $partial->getBaseFileName();
            if (strpos($partialFilePath, self::FOLDER_NAME) !== false) {
                $blockName = basename($partialFilePath);
                $blocksPartials[strtolower($blockName)] = $partialFilePath;
            }
        }

        return $blocksPartials;
    }

    public static function renderFromThemePartial($partial, $data)
    {
        try {
            return (new Controller)->renderPartial($partial, $data);
        } catch (\Exception $e) {
            trace_log($e);
            return false;
        }
    }

    /**
     * @param EditorJS $editor
     * @param array $blocks
     * @return string
     */
    public function processBlocks($editor, $blocks): string
    {
        $blocksPartials = $this->getTemplatePartialsOptions();
        $htmlOutput = '';

        foreach ($blocks as $block) {
            $blockType = strtolower($block['type']);
            if (array_key_exists($blockType, $blocksPartials)) {
                $htmlOutput .= $this->renderFromThemePartial($blocksPartials[$blockType], ['block' => $block]);
            } else {
                try {
                    $viewPath = array_get($this->blocksViews, $block['type']);
                    $htmlOutput .= View::make($viewPath, $block['data']);
                } catch (\Exception $ex) {
                    trace_log($ex);
                }
            }
        }

        return html_entity_decode($htmlOutput);
    }
}
