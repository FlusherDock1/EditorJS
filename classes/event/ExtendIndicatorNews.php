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

                $fieldType = 'editorjs';
                $fieldWidgetPath = 'ReaZzon\Editor\FormWidgets\EditorJS';

                if (PluginManager::instance()->hasPlugin('RainLab.Translate')
                    && !PluginManager::instance()->isDisabled('RainLab.Translate')) {
                    $fieldType = 'mleditorjs';
                    $fieldWidgetPath = 'ReaZzon\Editor\FormWidgets\MLEditorJS';
                }

                // Finding content field and changing it's type regardless whatever it already is.
                foreach ($widget->getFields() as $field) {
                    if ($field->fieldName === 'content') {
                        $field->config['type'] = $fieldType;
                        $field->config['widget'] = $fieldWidgetPath;
                        $field->config['stretch'] = true;
                    }
                }
            });

            // Replacing original content_render attribute.
            \Indikator\News\Models\Posts::extend(function ($model) {
                /** @var \October\Rain\Database\Model $model */
                $model->implement[] = 'ReaZzon.Editor.Behaviors.ConvertToHtml';

                $model->addDynamicMethod('getContentRenderAttribute', function () use ($model) {
                    return $model->convertJsonToHtml($model->getAttribute('content'));
                });
            });
        }
    }
}