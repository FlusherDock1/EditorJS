<?php namespace ReaZzon\Editor\Classes\Helper;

use System\Classes\PluginManager;

class ConverterHelper
{
    public $validationSettings;
    public $blocksViews;

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
}