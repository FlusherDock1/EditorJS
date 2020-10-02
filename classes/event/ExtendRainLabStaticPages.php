<?php namespace ReaZzon\Editor\Classes\Event;

use RainLab\Translate\Classes\MLStaticPage;
use ReaZzon\Editor\Models\Settings;
use System\Classes\PluginManager;

/**
 * Class ExtendRainLabStaticPages
 * @package ReaZzon\Editor\Classes\Event
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class ExtendRainLabStaticPages
{
    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $event
     */
    public function subscribe($event)
    {
        if (Settings::get('integration_static_pages', false) &&
            PluginManager::instance()->hasPlugin('RainLab.Pages')) {

            $event->listen('backend.form.extendFields', function ($widget) {

                // Only for RainLab.StaticPages Index controller
                if (!$widget->getController() instanceof \RainLab\Pages\Controllers\Index) {
                    return;
                }

                // Only for RainLab.StaticPages Page model
                if (!$widget->model instanceof \RainLab\Pages\Classes\Page) {
                    return;
                }

                $widget->removeField('markup');

                $fieldType = 'editorjs';

                if (PluginManager::instance()->hasPlugin('RainLab.Translate')
                    && !PluginManager::instance()->isDisabled('RainLab.Translate')) {
                    $fieldType = 'mleditorjs';
                }

                // Registering editorjs formWidget
                $widget->addSecondaryTabFields([
                    'viewBag[editor]' => [
                        'tab' => 'rainlab.pages::lang.editor.content',
                        'type' => $fieldType,
                        'stretch' => true
                    ]
                ]);
            });

            \RainLab\Pages\Classes\Page::extend(function ($model) {
                /** @var \October\Rain\Database\Model $model */
                $model->implement[] = 'ReaZzon.Editor.Behaviors.ConvertToHtml';

                $model->bindEvent('model.beforeSave', function () use ($model) {
                    $model->markup = $model->convertJsonToHtml($model->viewBag['editor']);
                });
            });

            if (PluginManager::instance()->hasPlugin('RainLab.Translate')
                && !PluginManager::instance()->isDisabled('RainLab.Translate')) {

                MLStaticPage::extend(function (MLStaticPage $model) {
                    /** @var \October\Rain\Database\Model $model */
                    $model->implement[] = 'ReaZzon.Editor.Behaviors.ConvertToHtml';

                    $model->bindEvent('model.beforeSave', function () use ($model) {
                        $model->markup = $model->convertJsonToHtml($model->viewBag['editor']);
                    });
                });
            }
        }
    }
}