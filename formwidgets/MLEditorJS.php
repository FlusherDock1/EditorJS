<?php namespace ReaZzon\Editor\FormWidgets;

use RainLab\Translate\Models\Locale;

/**
 * MLEditorJS Form Widget
 * @package ReaZzon\Editor\FormWidgets
 * @author Nick Khaetsky, rzzsapb@gmail.com
 */
class MLEditorJS extends EditorJS
{
    use \RainLab\Translate\Traits\MLControl;

    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'mleditorjs';

    public $originalAssetPath;
    public $originalViewPath;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        $this->initLocale();
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->actAsParent();
        $parentContent = parent::render();
        $this->actAsParent(false);

        if (!$this->isAvailable) {
            return $parentContent;
        }

        $this->vars['editorjs'] = $parentContent;
        return $this->makePartial('mleditorjs');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        parent::prepareVars();
        $this->prepareLocaleVars();
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $this->getLocaleSaveValue($value);
    }

    /**
     * @inheritDoc
     */
    protected function loadAssets()
    {
        $this->actAsParent();
        parent::loadAssets();
        $this->actAsParent(false);

        if (Locale::isAvailable()) {
            $this->loadLocaleAssets();
            $this->addJs('js/mleditorjs.js');
        }
    }

    /**
     * @inheritDoc
     */
    protected function getParentViewPath()
    {
        return base_path().'/plugins/reazzon/editor/formwidgets/editorjs/partials';
    }

    /**
     * @inheritDoc
     */
    protected function getParentAssetPath()
    {
        return '/plugins/reazzon/editor/formwidgets/editorjs/assets';
    }
}
