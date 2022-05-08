<?php namespace ReaZzon\Editor\Classes\Event;

use Backend\Widgets\Form;
use System\Classes\PluginManager;
use ReaZzon\Editor\Models\Settings;

/**
 * Class ExtendRainLabStaticPages
 * @package ReaZzon\Editor\Classes\Event
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class ExtendRainLabStaticPages extends AbstractFormExtender
{
    protected function replaceField(Form $widget)
    {
        $widget->removeField('markup');
        // Registering editorjs formWidget
        $widget->addSecondaryTabFields([
            'viewBag[editor]' => [
                'tab' => 'rainlab.pages::lang.editor.content',
                'type' => $this->fieldType,
                'stretch' => true
            ]
        ]);
    }

    protected function extendModel()
    {
        \RainLab\Pages\Classes\Page::extend(function ($model) {
            /** @var \October\Rain\Database\Model $model */
            $model->implement[] = 'ReaZzon.Editor.Behaviors.ConvertToHtml';

            $model->bindEvent('model.beforeSave', function () use ($model) {
                $model->markup = $model->convertJsonToHtml($model->viewBag['editor']);
            });
        });

        if (PluginManager::instance()->hasPlugin('RainLab.Translate')
            && !PluginManager::instance()->isDisabled('RainLab.Translate')) {

            \RainLab\Translate\Classes\MLStaticPage::extend(function ($model) {
                /** @var \October\Rain\Database\Model $model */
                $model->implement[] = 'ReaZzon.Editor.Behaviors.ConvertToHtml';

                $model->bindEvent('model.beforeSave', function () use ($model) {
                    if (isset($model->viewBag['editor']) && !empty($model->viewBag['editor'])) {
                        $model->markup = $model->convertJsonToHtml($model->viewBag['editor']);
                    }
                });
            });
        }
    }

    protected function getControllerClass()
    {
        return \RainLab\Pages\Controllers\Index::class;
    }

    protected function getModelClass()
    {
        return \RainLab\Pages\Classes\Page::class;
    }

    protected function isEnabled()
    {
        if (Settings::get('integration_static_pages', false) &&
            PluginManager::instance()->hasPlugin('RainLab.Pages')) {
            return true;
        }

        return false;
    }
}
