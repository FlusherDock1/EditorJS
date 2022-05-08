<?php namespace ReaZzon\Editor\Classes\Event;

use Backend\Widgets\Form;
use October\Rain\Events\Dispatcher;
use System\Classes\PluginManager;

abstract class AbstractFormExtender
{
    protected $controllerClass;
    protected $modelClass;

    protected $fieldType;
    protected $fieldWidgetPath;

    public function subscribe(Dispatcher $event)
    {
        $this->controllerClass = $this->getControllerClass();
        $this->modelClass = $this->getModelClass();

        $this->fieldType = 'editorjs';
        $this->fieldWidgetPath = 'ReaZzon\Editor\FormWidgets\EditorJS';

        if (PluginManager::instance()->hasPlugin('RainLab.Translate')
            && !PluginManager::instance()->isDisabled('RainLab.Translate')) {
            $this->fieldType = 'mleditorjs';
            $this->fieldWidgetPath = 'ReaZzon\Editor\FormWidgets\MLEditorJS';
        }

        if ($this->isEnabled()) {
            $event->listen('backend.form.extendFields', function (Form $widget) {

                if (!$widget->getController() instanceof $this->controllerClass) {
                    return;
                }

                if (!$widget->model instanceof $this->modelClass) {
                    return;
                }

                $this->replaceField($widget);

            });

            $this->extendModel();
        }
    }

    abstract protected function replaceField(Form $widget);

    abstract protected function extendModel();

    abstract protected function getControllerClass();

    abstract protected function getModelClass();

    abstract protected function isEnabled();
}
