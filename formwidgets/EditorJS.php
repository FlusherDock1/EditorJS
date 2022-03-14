<?php namespace ReaZzon\Editor\FormWidgets;

use Event;
use System\Classes\PluginManager;
use Backend\Classes\FormWidgetBase;

/**
 * EditorJS Form Widget
 * @package ReaZzon\Editor\FormWidgets
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class EditorJS extends FormWidgetBase
{
    const EVENT_CONFIG_BUILT = 'reazzon.editorjs.config.built';

    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'editorjs';

    public $stretch;

    public $settings = [];

    public $blocksSettings = [];

    public $tunesSettings = [];

    public $inlineToolbarSettings = [];

    public $blocksScripts = [];

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
            'settings'
        ]);
        $this->prepareVars();
        return $this->makePartial('editorjs');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['settings'] = e(json_encode($this->settings));
        $this->vars['blockSettings'] = e(json_encode($this->blocksSettings));
        $this->vars['tunesSettings'] = e(json_encode($this->tunesSettings));
        $this->vars['inlineToolbarSettings'] = e(json_encode($this->inlineToolbarSettings));
    }

    /**
     * @inheritDoc
     */
    protected function loadAssets()
    {
        $this->prepareBlocks();
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
            $this->processEditorBlocks($plugin);
            $this->processEditorTunes($plugin);
            $this->processEditorInlineToolbar($plugin);

            /**
             * Extend config, add your own settings to already existing plugins.
             *
             * Event::listen(\ReaZzon\Editor\FormWidgets\EditorJS::EVENT_CONFIG_BUILT, function($blocks) {
             *
             *     foreach($blocks['settings'] as $settings) {
             *          // ..
             *     }
             *
             *     foreach($blocks['scripts'] as $script) {
             *         // ..
             *     }
             *
             *     foreach($blocks['tunes'] as $tuneItem) {
             *         // ..
             *     }
             *
             *     foreach($blocks['inlineToolbar'] as $inlineToolbarItem) {
             *         // ..
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
        if (!method_exists($plugin, 'registerEditorBlocks')) {
            return;
        }

        $editorPlugins = $plugin->registerEditorBlocks();
        if (!is_array($editorPlugins) && !empty($editorPlugins)) {
            return;
        }

        /**
         * @var string $block
         * @var array $section
         */
        foreach ($editorPlugins as $block => $sections) {
            foreach ($sections as $name => $section) {
                if ($name === 'settings') {
                    $this->blocksSettings = array_add($this->blocksSettings, $block, $section);
                }
                if ($name === 'scripts') {
                    foreach ($section as $script) {
                        $this->blocksScripts[] = $script;
                    }
                }
            }
        }
    }

    protected function processEditorTunes($plugin): void
    {
        if (!method_exists($plugin, 'registerEditorTunes')) {
            return;
        }

        $editorTunes = $plugin->registerEditorTunes();
        if (empty($editorTunes) && !is_array($editorTunes)) {
            return;
        }

        foreach ($editorTunes as $tune) {
            $this->tunesSettings[] = $tune;
        }
    }

    protected function processEditorInlineToolbar($plugin): void
    {
        if (!method_exists($plugin, 'registerEditorInlineToolbar')) {
            return;
        }

        $inlineToolbarSettings = $plugin->registerEditorInlineToolbar();
        if (empty($inlineToolbarSettings) && !is_array($inlineToolbarSettings)) {
            return;
        }

        foreach ($inlineToolbarSettings as $inlineToolbarSetting) {
            $this->inlineToolbarSettings[] = $inlineToolbarSetting;
        }
    }
}
