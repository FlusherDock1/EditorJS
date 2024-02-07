<?php namespace ReaZzon\Editor\FormWidgets;

use Backend\Classes\FormWidgetBase;
use October\Rain\Support\Facades\Event;
use ReaZzon\Editor\Classes\Contracts\EditorJsTool;
use ReaZzon\Editor\Classes\Contracts\EditorJsTune;
use System\Classes\PluginManager;

/**
 * EditorJs Form Widget
 *
 * @link https://docs.octobercms.com/3.x/extend/forms/form-widgets.html
 */
class EditorJs extends FormWidgetBase
{
    const EVENT_CONFIG_BUILT = 'reazzon.editorjs.config.built';

    protected $defaultAlias = 'reazzon_editor_js';

    public array $settings = [];

    public array $tools = [];

    public array $tunes = [];

    public array $additionalScripts = [];

    public function init(): void
    {
        $this->prepareBlocks();
    }

    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('editorjs');
    }

    public function prepareVars(): void
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;

        $this->vars['settings'] = e(json_encode($this->settings));
        $this->vars['tools'] = e(json_encode($this->tools));
        $this->vars['tunes'] = e(json_encode($this->tunes));
    }

    public function loadAssets(): void
    {
        $this->addCss('css/editorjs.css');
        $this->addJs('js/vendor.js');
        $this->addJs('js/editorjs.js');
    }

    public function getSaveValue($value)
    {
        return $value;
    }

    protected function prepareBlocks(): void
    {
        $pluginManager = PluginManager::instance();
        $plugins = $pluginManager->getPlugins();

        foreach ($plugins as $plugin) {
            $this->processTools($plugin);
            $this->processTunes($plugin);

            /**
             * Extend config, add your own settings to already existing plugins.
             *
             * Event::listen(\ReaZzon\Editor\FormWidgets\EditorJs::EVENT_CONFIG_BUILT, function($config) {
             *
             *     foreach($config['tools'] as $tool) {
             *          // ...
             *     }
             *
             *     foreach($config['scripts'] as $script) {
             *         // ...
             *     }
             *
             *     foreach($config['tunes'] as $tuneItem) {
             *         // ...
             *     }
             *
             *     return $config;
             * });
             */
            $eventConfig = Event::fire(self::EVENT_CONFIG_BUILT, [
                'scripts' => $this->additionalScripts,
                'tools' => $this->tools,
                'tunes' => $this->tunes
            ]);

            if (!empty($eventConfig)) {
                $this->tools = $eventConfig['settings'];
                $this->additionalScripts = $eventConfig['scripts'];
                $this->tunes = $eventConfig['tunes'];
            }

            if (!empty($this->additionalScripts)) {
                foreach ($this->additionalScripts as $script) {
                    $this->addJs($script);
                }
            }
        }
    }

    protected function processTools($plugin): void
    {
        if (!method_exists($plugin, 'registerEditorJsTools')) {
            return;
        }

        $editorTools = $plugin->registerEditorJsTools();
        if (!is_array($editorTools) || empty($editorTools)) {
            return;
        }

        foreach ($editorTools as $toolClass => $toolName) {
            /** @var EditorJsTool $tool */
            $tool = app($toolClass);
            $this->tools[$toolName] = $tool->registerSettings();
            $this->additionalScripts = array_merge($this->additionalScripts, $tool->registerScripts());
        }
    }

    protected function processTunes($plugin): void
    {
        if (!method_exists($plugin, 'registerEditorJsTunes')) {
            return;
        }

        $editorTunes = $plugin->registerEditorJsTunes();
        if (empty($editorTunes) && !is_array($editorTunes)) {
            return;
        }

        foreach ($editorTunes as $tuneClass => $tuneName) {
            /** @var EditorJsTune $tune */
            $tune = app($tuneClass);
            $this->tunes[$tuneName] = $tune->registerSettings();
            $this->additionalScripts = array_merge($this->additionalScripts, $tune->registerScripts());
        }
    }
}
