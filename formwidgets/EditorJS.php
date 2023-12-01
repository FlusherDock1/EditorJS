<?php namespace ReaZzon\Editor\FormWidgets;

use Backend\Classes\FormWidgetBase;
use October\Rain\Support\Facades\Event;
use ReaZzon\Editor\Classes\Contracts\EditorJsBlock;
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

    public array $blocksSettings = [];

    public array $tunesSettings = [];

    public array $inlineToolbarSettings = [];

    public array $blocksScripts = [];

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
        $this->vars['blockSettings'] = e(json_encode($this->blocksSettings));
        $this->vars['tunesSettings'] = e(json_encode($this->tunesSettings));
        $this->vars['inlineToolbarSettings'] = e(json_encode($this->inlineToolbarSettings));
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
            $this->processEditorBlocks($plugin);
            $this->processEditorTunes($plugin);
            $this->processEditorInlineToolbar($plugin);

            /**
             * Extend config, add your own settings to already existing plugins.
             *
             * Event::listen(\ReaZzon\Editor\FormWidgets\EditorJs::EVENT_CONFIG_BUILT, function($blocks) {
             *
             *     foreach($blocks['settings'] as $settings) {
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
                'settings' => $this->blocksSettings,
                'scripts' => $this->blocksScripts,
                'tunes' => $this->tunesSettings,
                'inlineToolbar' => $this->inlineToolbarSettings
            ]);

            if (!empty($eventBlocks)) {
                $this->blocksSettings = $eventBlocks['settings'];
                $this->blocksScripts = $eventBlocks['scripts'];
                $this->tunesSettings = $eventBlocks['tunes'];
                $this->inlineToolbarSettings = $eventBlocks['inlineToolbar'];
            }

            if (!empty($this->blocksScripts)) {
                foreach ($this->blocksScripts as $script) {
                    $this->addJs($script);
                }
            }
        }
    }

    protected function processEditorBlocks($plugin): void
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
            $this->blocksSettings[$blockName] = $block->registerSettings();
            $this->blocksScripts = array_merge($this->blocksScripts, $block->registerScripts());
        }
    }

    protected function processEditorTunes($plugin): void
    {
        if (!method_exists($plugin, 'registerEditorJsTunes')) {
            return;
        }

        $editorTunes = $plugin->registerEditorJsTunes();
        if (empty($editorTunes) && !is_array($editorTunes)) {
            return;
        }

        foreach ($editorTunes as $tune) {
            $this->tunesSettings[] = $tune;
        }
    }

    protected function processEditorInlineToolbar($plugin): void
    {
        if (!method_exists($plugin, 'registerEditorJsInlineToolbar')) {
            return;
        }

        $inlineToolbarSettings = $plugin->registerEditorJsInlineToolbar();
        if (empty($inlineToolbarSettings) && !is_array($inlineToolbarSettings)) {
            return;
        }

        foreach ($inlineToolbarSettings as $inlineToolbarSetting) {
            $this->inlineToolbarSettings[] = $inlineToolbarSetting;
        }
    }
}
