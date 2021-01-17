<?php namespace ReaZzon\Editor\Behaviors;

use October\Rain\Extension\ExtensionBase;
use System\Classes\PluginManager;

use EditorJS\EditorJS;
use EditorJS\EditorJSException;

/**
 * Class ConvertableBehavior
 * @package ReaZzon\Editor\Classes\Behaviors
 * @author Nick Khaetsky, nick@reazzon.ru
 */
abstract class ConvertableBehavior extends ExtensionBase
{
    /**
     * @var \October\Rain\Database\Model Reference to the extended model.
     */
    protected $model;

    /**
     * @var array Settings for validation
     */
    protected $validationSettings;

    /**
     * @var array Views for blocks
     */
    protected $blocksViews;

    /**
     * @param $jsonField
     * @return mixed|string
     */
    public function startConverter($jsonField)
    {
        $this->prepareBlocks();
        try {
            // Initialize Editor backend and validate structure
            $editor = new EditorJS($jsonField, json_encode($this->validationSettings));

            // Get sanitized blocks (according to the rules from configuration)
            $blocks = $editor->getBlocks();

            return $this->processBlocks($editor, $blocks);

        } catch (EditorJSException $e) {
            // process exception
            return 'Something went wrong: ' . $e->getMessage();
        }
    }

    public function prepareBlocks()
    {
        $pluginManager = PluginManager::instance();
        $plugins = $pluginManager->getPlugins();
        $this->validationSettings['tools'] = [];

        foreach ($plugins as $plugin) {
            if (!method_exists($plugin, 'registerEditorBlocks')) {
                continue;
            }

            $editorPlugins = $plugin->registerEditorBlocks();
            if (!is_array($editorPlugins)) {
                continue;
            }



            /**
             * @var string $block
             * @var array $section
             */
            foreach ($editorPlugins as $block => $sections) {
                foreach ($sections as $name => $section) {
                    if ($name === 'validation') {
                        $this->validationSettings['tools'] = array_add($this->validationSettings['tools'], $block, $section);
                    }
                    if ($name === 'view') {
                        $this->blocksViews = array_add($this->blocksViews, $block, $section);
                    }
                }
            }
        }
    }
    /**
     * @param EditorJS $editor
     * @param array $blocks
     * @return mixed
     */
    abstract public function processBlocks($editor, $blocks);
}
