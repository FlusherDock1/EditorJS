<?php namespace ReaZzon\Editor\Classes\Event;

use ReaZzon\Editor\Models\Settings;
use System\Classes\PluginManager;

/**
 * Class ExtendRainLabStaticPages
 * @package ReaZzon\Editor\Classes\Event
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class ExtendRainLabStaticPages
{
    use \ReaZzon\Editor\Traits\ConvertEditor;

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
                $editorType = PluginManager::instance()->hasPlugin('RainLab.Translate') ? 'mleditorjs' : 'editorjs';

                // Registering editorjs formWidget
                $widget->addSecondaryTabFields([
                    'viewBag[editor]' => [
                        'tab' => 'rainlab.pages::lang.editor.content',
                        'type' => $editorType,
                        'stretch' => true
                    ]
                ]);
            });

            \RainLab\Pages\Classes\Page::extend(function ($model) {
                $model->bindEvent('model.beforeSave', function () use ($model) {
                    $model->markup = $this->convertJsonToHtml($model->viewBag['editor']);
                });
            });
        }
    }
}