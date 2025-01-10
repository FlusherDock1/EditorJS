<?php namespace ReaZzon\Editor\Classes;

use October\Rain\Support\Facades\Event;
use View;
use Cms\Classes\CmsException;
use Cms\Classes\Controller;
use Cms\Classes\Partial;
use Cms\Classes\Theme;
use EditorJS\EditorJS;
use EditorJS\EditorJSException;
use System\Classes\PluginManager;
use ReaZzon\Editor\Classes\Contracts\EditorJsTool;

class JSONConverter
{
    private array $partialsCache = [];

    public function __construct(
        protected string $JSONContent,
        protected bool $isRenderWithThemeDisabled = false,
        protected ?array $blocks = null,
        protected array $validations = [],
        protected array $views = []
    ) {
        $this->fillValidationsAndViews();
        $this->blocks = $this->blocks ?: array_get(json_decode($this->JSONContent, true), 'blocks');
    }

    /**
     * @throws EditorJSException
     */
    public function validate(): self
    {
        new EditorJS($this->JSONContent, json_encode([
            'tools' => $this->validations
        ]));

        return $this;
    }

    public function getBlocks(): array
    {
        return $this->blocks;
    }

    /**
     * @throws CmsException
     */
    public function getHTML(): string
    {
        $output = '';
        foreach ($this->blocks as $block) {
            $output .= $this->renderBlockToHTML($block);
        }

        return $output;
    }

    protected function fillValidationsAndViews(): void
    {
        $pluginManager = PluginManager::instance();
        $plugins = $pluginManager->getPlugins();

        $skipValidations = !empty($this->validations);
        $skipViews = !empty($this->views);

        // if converter booted with predefined values
        if ($skipValidations && $skipViews) {
            return;
        }

        foreach ($plugins as $plugin) {
            if (!method_exists($plugin, 'registerEditorJsTools')) {
                continue;
            }

            $editorExtensions = $plugin->registerEditorJsTools();
            if (!is_array($editorExtensions) || empty($editorExtensions)) {
                continue;
            }

            foreach ($editorExtensions as $extensionClass => $extensionName) {
                /** @var EditorJsTool $extension */
                $extension = app($extensionClass);

                if (!$skipValidations && method_exists($extension, 'registerValidations')) {
                    $this->validations[$extensionName] = $extension->registerValidations();
                }

                if (!$skipViews && method_exists($extension, 'registerView')) {
                    $this->views[$extensionName] = $extension->registerView();
                }
            }
        }

        /**
         * Extend config, add your own validations and tools.
         *
         * Event::listen('reazzon.editor.converter.config', function(&$config) {
         *
         *     foreach($config['views'] as $toolName => $view) {
         *          // ...
         *     }
         *
         *     foreach($config['validations'] as $toolName => $validation) {
         *         // ...
         *     }
         *
         *     return $config;
         * });
         */
        $eventConfig = Event::fire('reazzon.editor.converter.config', [
            'views' => $this->views,
            'validations' => $this->validations
        ]);

        if (!empty($eventConfig)) {
            $this->views = $eventConfig['views'];
            $this->validations = $eventConfig['validations'];
        }
    }

    /**
     * @throws CmsException
     */
    protected function renderBlockToHTML($block): string
    {
        $type = strtolower($block['type']);

        if (!empty($this->partialsCache[$type])) {
            return (new Controller)->renderPartial($this->partialsCache[$type], $block['data']);
        }

        // Render block to partial from active theme
        if (!$this->isRenderWithThemeDisabled) {
            $blockFileName = 'editorjs/' . $type . '.htm';
            $theme = Theme::getEditTheme();
            $partial = Partial::listInTheme($theme)->filter(fn($partial) => $partial->fileName == $blockFileName)->first();

            if (!empty($partial)) {
                $this->partialsCache[$type] = $partial->fileName;
                return (new Controller)->renderPartial($partial->fileName, $block['data']);
            }
        }

        // Render block with default view
        return View::make($this->views[$type], [
            ...array_get($block, 'data', []),
            'tunes' => array_get($block, 'tunes', [])
        ])->render();
    }
}
