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
    use \ReaZzon\Editor\Traits\ConvertEditor;

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

                // Finding content field and changing it's type regardless whatever it already is.
                foreach ($widget->getFields() as $field) {
                    if ($field->fieldName === 'content') {
                        $field->config['type'] = 'editorjs';
                        $field->config['widget'] = 'ReaZzon\Editor\FormWidgets\EditorJS';
                        $field->config['stretch'] = true;
                    }
                }

            });

            // Replacing original content_html attribute.
            \RainLab\Blog\Models\Post::extend(function ($model) {
                $model->bindEvent('model.getAttribute', function ($attribute, $value) use ($model) {
                    if ($attribute == 'content_html') {
                        return $this->convertJsonToHtml($model->content);
                    }
                });
            });
        }
    }
}