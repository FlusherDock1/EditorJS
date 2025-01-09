<?php namespace ReaZzon\Editor\Classes;

use ReaZzon\Editor\Classes\Contracts\EditorJsTool;
use ReaZzon\Editor\Classes\Contracts\EditorJsTune;
use View;
use Cms\Classes\CmsException;
use Cms\Classes\Controller;
use Cms\Classes\Partial;
use Cms\Classes\Theme;
use EditorJS\EditorJS;
use EditorJS\EditorJSException;
use System\Classes\PluginManager;

class JSONConverter
{
    private array $partialsCache = [];

    public function __construct(
        protected string $JSONContent,
        protected ?array $blocks = null,
        protected array $validations = [],
        protected array $views = []
    ) {
        $this->prepareToolsAndTunes();
    }

    /**
     * @throws EditorJSException
     */
    public function validate(): self
    {
        $validated = new EditorJS($this->JSONContent, json_encode([
            'tools' => array_get($this->validations, 'tools', [])
        ]));

        // Get sanitized blocks (according to the rules from configuration)
        $this->blocks = $validated->getBlocks();
        dd($this->blocks);
        return $this;
    }

    public function getBlocks(): array
    {
        // If you don't want to validate your blocks
        if (empty($this->blocks)) {
            $this->blocks = array_get(json_decode($this->JSONContent, true), 'blocks');
        }

        return $this->blocks;
    }

    /**
     * @throws CmsException
     */
    public function getHTML(): string
    {
        // If you don't want to validate your blocks
        if (empty($this->blocks)) {
            $this->blocks = array_get(json_decode($this->JSONContent, true), 'blocks');
        }

        $output = '';

        foreach ($this->blocks as $block) {
            $output .= $this->renderBlockToHTML($block);
        }

        return $output;
    }

    protected function prepareToolsAndTunes(): void
    {
        $pluginManager = PluginManager::instance();
        $plugins = $pluginManager->getPlugins();

        foreach ($plugins as $plugin) {
            // tools and tunes has same methods
            foreach (['tools', 'tunes'] as $extensionType) {
                $methodName = 'registerEditorJs'. ucfirst($extensionType);
                if (method_exists($plugin, $methodName)) {
                    $editorExtensions = $plugin->$methodName();
                    if (!is_array($editorExtensions) || empty($editorExtensions)) {
                        continue;
                    }

                    foreach ($editorExtensions as $extensionClass => $extensionName) {
                        /** @var EditorJsTool|EditorJsTune $extension */
                        $extension = app($extensionClass);
                        if (method_exists($extension, 'registerValidations')) {
                            $this->validations[$extensionType][$extensionName] = $extension->registerValidations();
                        }

                        if (method_exists($extension, 'registerView')) {
                            $this->views[$extensionType][$extensionName] = $extension->registerView();
                        }
                    }
                }
            }
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
        $blockFileName = 'editorjs/' . $type . '.htm';
        $theme = Theme::getEditTheme();
        $partial = Partial::listInTheme($theme)->filter(fn($partial) => $partial->fileName == $blockFileName)->first();

        if (!empty($partial)) {
            $this->partialsCache[$type] = $partial->fileName;
            return (new Controller)->renderPartial($partial->fileName, $block['data']);
        }

        // Render bock with default view
        return View::make($this->views['tools'][$type], [
            ...array_get($block, 'data'),
            'tunes' => array_get($block, 'tunes')
        ]);
    }
}
