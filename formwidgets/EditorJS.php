<?php namespace ReaZzon\Editor\FormWidgets;

use Config, Event;
use Backend\Classes\FormWidgetBase;

/**
 * EditorJS Form Widget
 */
class EditorJS extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'reazzon_editor_editor_js';

    public $placeholder;

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
        $this->vars['placeholder'] = $this->placeholder;
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['toolSettings'] = $this->getToolSettings();
        $this->vars['scripts'] = null;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/editor.css', 'ReaZzon.Editor');
        $this->addJs('js/vendor.js', 'ReaZzon.Editor');
        $this->addJs('js/tools/link.js', 'ReaZzon.Editor');
        $this->addJs('js/tools/list.js', 'ReaZzon.Editor');
        $this->addJs('js/tools/header.js', 'ReaZzon.Editor');
        $this->addJs('js/tools/code.js', 'ReaZzon.Editor');
        $this->addJs('js/tools/table.js', 'ReaZzon.Editor');
        $this->addJs('js/tools/checklist.js', 'ReaZzon.Editor');
        $this->addJs('js/tools/marker.js', 'ReaZzon.Editor');
        $this->addJs('js/tools/embed.js', 'ReaZzon.Editor');
        $this->addJs('js/tools/raw.js', 'ReaZzon.Editor');
        $this->addJs('js/tools/delimiter.js', 'ReaZzon.Editor');
        $this->addJs('js/editor.js', 'ReaZzon.Editor');
        $this->handleExtendedScripts();
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }

    protected function getToolSettings()
    {
        $toolsConfig = $this->handleExtendedConfigs(Config::get('reazzon.editor::toolSettings'));
        return e(json_encode($toolsConfig));
    }

    /**\
     * Handling events from other plugins
     *
     * Example:
     *      \Event::listen('reazzon.editor.extend_editor_scripts', function (){
     *          return '/plugins/reazzon/test/assets/js/raw.js';
     *      });
     *
     * @return void
     */
    protected function handleExtendedScripts(){
        $scriptsList = Event::fire('reazzon.editor.extend_editor_scripts');
        if (empty($scriptsList)) {
            return;
        }

        foreach ($scriptsList as $script){
            $this->vars['scripts'][] = $script;
        }
    }

    /**
     * Handling extenders
     *
     * Example:
     *      \Event::listen('reazzon.editor.extend_editor_tools_config', function (){
     *          return [
     *              'raw' => [
     *                  'class' => 'RawTool'
     *              ],
     *          ];
     *      });
     *
     * @param $toolsConfig
     * @return array
     */
    protected function handleExtendedConfigs($toolsConfig)
    {
        $configs = Event::fire('reazzon.editor.extend_editor_tools_config');
        if (empty($configs)) {
            return $toolsConfig;
        }

        foreach ($configs as $config) {
            foreach ($config as $key => $item) {
                $toolsConfig[$key] = $item;
            }
        }

        return $toolsConfig;
    }
}
