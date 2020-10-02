<?php namespace ReaZzon\Editor\Classes\Event;

use System\Classes\PluginManager;
use ReaZzon\Editor\Models\Settings;

/**
 * Class ExtendRainLabBlog
 * @package ReaZzon\Editor\Classes\Event
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class ExtendRainLabBlog
{
    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $event
     */
    public function subscribe($event)
    {
        if (Settings::get('integration_blog', false) &&
            PluginManager::instance()->hasPlugin('RainLab.Blog')) {

            $event->listen('backend.form.extendFields', function ($widget) {

                // Only for RainLab.Blog Posts controller
                if (!$widget->getController() instanceof \RainLab\Blog\Controllers\Posts) {
                    return;
                }

                // Only for RainLab.Blog Post model
                if (!$widget->model instanceof \RainLab\Blog\Models\Post) {
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

            // Replacing original content_html attribute.
            \RainLab\Blog\Models\Post::extend(function ($model) {
                /** @var \October\Rain\Database\Model $model */
                $model->implement[] = 'ReaZzon.Editor.Behaviors.ConvertToHtml';

                $model->bindEvent('model.getAttribute', function ($attribute, $value) use ($model) {
                    if ($attribute == 'content_html') {
                        return $model->convertJsonToHtml($model->getAttribute('content'));
                    }
                });
            });
        }
    }
}