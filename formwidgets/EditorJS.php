<?php namespace ReaZzon\Editor\FormWidgets;

use Config, Event;
use System\Classes\PluginManager;
use October\Rain\Support\Collection;
use Backend\Classes\FormWidgetBase;

/**
 * EditorJS Form Widget
 * @package ReaZzon\Editor\FormWidgets
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class EditorJS extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'editorjs';

    public $placeholder;

    public $stretch;

    public $scripts;

    public $toolSettings;

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->fillFromConfig([
            'placeholder',
        ]);
        $this->prepareVars();
        return $this->makePartial('editorjs');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->prepareBlocks();
        $this->vars['placeholder'] = $this->placeholder;
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['toolSettings'] = e(json_encode($this->toolSettings));
        $this->vars['scripts'] = $this->scripts;
    }

    /**
     * @inheritDoc
     */
    protected function loadAssets()
    {
        $this->addCss('css/editor.css', 'ReaZzon.Editor');
        $this->addJs('js/editor.js', 'ReaZzon.Editor');
        $this->addJs('js/vendor.js', 'ReaZzon.Editor');
        $this->addJs('js/dragnrdrop.js', 'ReaZzon.Editor');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }

    protected function prepareBlocks()
    {
        $pluginManager = PluginManager::instance();
        $plugins = $pluginManager->getPlugins();

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
                    if ($name === 'settings') {
                        $this->toolSettings = array_add($this->toolSettings, $block, $section);
                    }
                    if ($name === 'scripts') {
                        foreach ($section as $script) {
                            $this->addJs($script);
                        }
                    }
                }
            }
        }
    }
}
