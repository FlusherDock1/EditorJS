<?php namespace ReaZzon\Editor\FormWidgets;

use Backend\Classes\FormWidgetBase;
use October\Rain\Support\Facades\Event;
use ReaZzon\Editor\Classes\Contracts\EditorJsBlock;
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

    public array $blocks = [];

    public array $tunes = [];

    public array $inlineToolbars = [];

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
        $this->vars['blocks'] = e(json_encode($this->blocks));
        $this->vars['tunes'] = e(json_encode($this->tunes));
        $this->vars['inlineToolbars'] = e(json_encode($this->inlineToolbars));
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
            $this->processBlocks($plugin);
            $this->processTunes($plugin);
            $this->processInlineToolbar($plugin);

            /**
             * Extend config, add your own settings to already existing plugins.
             *
             * Event::listen(\ReaZzon\Editor\FormWidgets\EditorJs::EVENT_CONFIG_BUILT, function($blocks) {
             *
             *     foreach($blocks['blocks'] as $block) {
             *          // ...
             *     }
             *
             *     foreach($blocks['scripts'] as $script) {
             *         // ...
             *     }
             *
             *     foreach($blocks['tunes'] as $tuneItem) {
             *         // ...
             *     }
             *
             *     foreach($blocks['inlineToolbar'] as $inlineToolbarItem) {
             *         // ...
             *     }
             *
             *     return $blocks;
             * });
             */
            $eventBlocks = Event::fire(self::EVENT_CONFIG_BUILT, [
                'scripts' => $this->additionalScripts,
                'blocks' => $this->blocks,
                'tunes' => $this->tunes,
                'inlineToolbars' => $this->inlineToolbars
            ]);

            if (!empty($eventBlocks)) {
                $this->blocks = $eventBlocks['settings'];
                $this->additionalScripts = $eventBlocks['scripts'];
                $this->tunes = $eventBlocks['tunes'];
                $this->inlineToolbars = $eventBlocks['inlineToolbar'];
            }

            if (!empty($this->additionalScripts)) {
                foreach ($this->additionalScripts as $script) {
                    $this->addJs($script);
                }
            }
        }
    }

    protected function processBlocks($plugin): void
    {
        if (!method_exists($plugin, 'registerEditorJsBlocks')) {
            return;
        }

        $editorBlocks = $plugin->registerEditorJsBlocks();
        if (!is_array($editorBlocks) || empty($editorBlocks)) {
            return;
        }

        foreach ($editorBlocks as $blockClass => $blockName) {
            /** @var EditorJsBlock $block */
            $block = app($blockClass);
            $this->blocks[$blockName] = $block->registerSettings();
            $this->additionalScripts = array_merge($this->additionalScripts, $block->registerScripts());
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

    protected function processInlineToolbar($plugin): void
    {
        if (!method_exists($plugin, 'registerEditorJsInlineToolbar')) {
            return;
        }

        $inlineToolbars = $plugin->registerEditorJsInlineToolbar();
        if (empty($inlineToolbars) && !is_array($inlineToolbars)) {
            return;
        }

        foreach ($inlineToolbars as $inlineToolbarSetting) {
            $this->inlineToolbars[] = $inlineToolbarSetting;
        }
    }
}
