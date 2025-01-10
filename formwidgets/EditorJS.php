<?php namespace ReaZzon\Editor\FormWidgets;

use Backend\Classes\FormWidgetBase;
use October\Contracts\Support\OctoberPackage;
use October\Rain\Support\Facades\Event;
use ReaZzon\Editor\Classes\Contracts\EditorJsTool;
use ReaZzon\Editor\Classes\Contracts\EditorJsTune;
use System\Classes\PluginManager;

/**
 * EditorJs Form Widget
 *
 * @link https://docs.octobercms.com/3.x/extend/forms/form-widgets.html
 */
class EditorJS extends FormWidgetBase
{
    protected $defaultAlias = 'reazzon_editor_js';

    public array $settings = [];

    public array $tools = [];

    public array $tunes = [];

    public array $additionalScripts = [];

    public function init(): void
    {
        $this->buildConfig();
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

        $this->vars['settings'] = $this->settings;
        $this->vars['tools'] = $this->tools;
        $this->vars['tunes'] = $this->tunes;
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

    protected function buildConfig(): void
    {
        $pluginManager = PluginManager::instance();
        $plugins = $pluginManager->getPlugins();

        foreach ($plugins as $plugin) {
            $this->processTools($plugin);
            $this->processTunes($plugin);

            /**
             * Extend config, add your own settings to already existing plugins.
             *
             * Event::listen('reazzon.editor.formwidget.config', function(&$config) {
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
            $eventConfig = Event::fire('reazzon.editor.formwidget.config', [
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

    protected function processTools(OctoberPackage $plugin): void
    {
        if (!method_exists($plugin, 'registerEditorJsTools')) {
            return;
        }

        $editorTools = $plugin->registerEditorJsTools();
        if (empty($editorTools) || !is_array($editorTools)) {
            return;
        }

        foreach ($editorTools as $toolClass => $toolName) {
            /** @var EditorJsTool $tool */
            $tool = app($toolClass);
            $this->tools[$toolName] = $tool->registerSettings();
            $this->additionalScripts = array_merge($this->additionalScripts, $tool->registerScripts());
        }
    }

    protected function processTunes(OctoberPackage $plugin): void
    {
        if (!method_exists($plugin, 'registerEditorJsTunes')) {
            return;
        }

        $editorTunes = $plugin->registerEditorJsTunes();
        if (empty($editorTunes) || !is_array($editorTunes)) {
            return;
        }

        foreach ($editorTunes as $tuneClass => $tuneName) {
            /** @var EditorJsTune $tune */
            $tune = app($tuneClass);
            $this->tools[$tuneName] = $tune->registerSettings();
            $this->additionalScripts = array_merge($this->additionalScripts, $tune->registerScripts());

            $appliedTools = $tune->registerAppliedTools();
            if (empty($appliedTools)) {
                $this->tunes[] = $tuneName;
                continue;
            }

            foreach ($appliedTools as $toolName) {
                $this->tools[$toolName]['tunes'] = array_merge(array_get($this->tools[$toolName], 'tunes', []), [$tuneName]);
            }
        }
    }
}
