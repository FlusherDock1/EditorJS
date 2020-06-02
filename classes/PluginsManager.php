<?php namespace ReaZzon\Editor\Classes;

use Str, App;
use System\Classes\PluginManager;
use October\Rain\Support\Collection;
use October\Rain\Support\Traits\Singleton;

class PluginsManager
{
    use Singleton;

    protected $editorPlugins;

    public function init() {
        $this->initPlugins();
    }

    protected function initPlugins() {
        $pluginManager = PluginManager::instance();
        $plugins = $pluginManager->getPlugins();

        $editorPluginsCollection = [];
        foreach ($plugins as $plugin) {
            if (!method_exists($plugin, 'registerEditorJSPlugins')) {
                continue;
            }

            $editorPlugins = $plugin->registerEditorJSPlugins();
            if (!is_array($editorPlugins)) {
                continue;
            }

            foreach ($editorPlugins as $className => $alias) {
                $editorPluginsCollection[] = new Collection([
                    'className'   => $className,
                    'alias'       => $alias,
                    'pluginClass' => get_class($plugin)
                ]);
            }
        }

        $this->editorPlugins = $editorPluginsCollection;
    }

    protected function findPlugin($code)
    {
        foreach ($this->editorPlugins as $plugin){
            if ($plugin->contains($code)){
                $className = Str::normalizeClassName($plugin->get('className'));
                return App::make($className);
            }
        }
    }

    public function getPluginResponse($code) {
        return $this->findPlugin($code)->createResponse(\Input::all());
    }
}