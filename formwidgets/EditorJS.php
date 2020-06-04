<?php namespace ReaZzon\Editor\FormWidgets;

use Config, Event;
use System\Classes\PluginManager;
use October\Rain\Support\Collection;
use Backend\Classes\FormWidgetBase;

/**
 * EditorJS Form Widget
 * @package ReaZzon\Editor\FormWidgets
 * @author Nick Khaetsky, rzzsapb@gmail.com
 */
class EditorJS extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'reazzon_editor_editor_js';

    public $placeholder;

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
    public function loadAssets()
    {
        $this->addCss('css/editor.css', 'ReaZzon.Editor');
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
        $this->toolSettings = Config::get('reazzon.editor::toolSettings');
        $this->scripts = Config::get('reazzon.editor::scripts');

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

            foreach ($editorPlugins as $section => $config) {
                if ($section === 'blocks'){
                    foreach ($config as $key => $block){
                        $this->toolSettings = array_add($this->toolSettings, $key, $block);
                    }
                }
                if ($section === 'scripts'){
                    foreach ($config as $script){
                        array_push($this->scripts, $script);
                    }
                }
            }
        }
    }
}
