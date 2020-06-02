<?php namespace ReaZzon\Editor\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * EditorJS Form Widget
 */
class EditorJS extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'reazzon_editor_editor_js';

    public $placeholder;

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
            'placeholder',
        ]);
        $this->prepareVars();
        return $this->makePartial('editorjs');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['placeholder'] = $this->placeholder;
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/editor.css', 'ReaZzon.Editor');
        $this->addJs('js/vendor.js', 'ReaZzon.Editor');
        $this->addJs('js/tools/link.js', 'ReaZzon.Editor');
        $this->addJs('js/editor.js', 'ReaZzon.Editor');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
