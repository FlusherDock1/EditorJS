<?php namespace ReaZzon\Editor\Classes\Event;

use System\Classes\PluginManager;
use ReaZzon\Editor\Models\Settings;

/**
 * Class ExtendIndicatorNews
 * @package ReaZzon\Editor\Classes\Event
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class ExtendIndicatorNews
{
    use \ReaZzon\Editor\Traits\ConvertEditor;

    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $event
     */
    public function subscribe($event)
    {
        if (Settings::get('integration_indikator_news', false) &&
            PluginManager::instance()->hasPlugin('Indikator.News')) {

            $event->listen('backend.form.extendFields', function ($widget) {

                // Only for Indikator.News Posts controller
                if (!$widget->getController() instanceof \Indikator\News\Controllers\Posts) {
                    return;
                }

                // Only for Indikator.News Post model
                if (!$widget->model instanceof \Indikator\News\Models\Posts) {
                    return;
                }

                // Finding content field and changing it's type regardless whatever it already is.
                foreach ($widget->getFields() as $field) {
                    if ($field->fieldName === 'content') {
                        $field->config['type'] = 'editorjs';
                        $field->config['widget'] = 'ReaZzon\Editor\FormWidgets\EditorJS';
                        $field->config['stretch'] = true;
                    }
                }
            });

            // Replacing original content_render attribute.
            \Indikator\News\Models\Posts::extend(function ($model) {
                $model->addDynamicMethod('getContentRenderAttribute', function () use ($model) {
                    return $this->convertJsonToHtml($model->getAttribute('content'));
                });
            });
        }
    }
}