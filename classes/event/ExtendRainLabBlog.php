<?php namespace ReaZzon\Editor\Classes\Event;

use Backend\Widgets\Form;
use System\Classes\PluginManager;
use ReaZzon\Editor\Models\Settings;

/**
 * Class ExtendRainLabBlog
 * @package ReaZzon\Editor\Classes\Event
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class ExtendRainLabBlog extends AbstractFormExtender
{
    protected function replaceField(Form $widget)
    {
        if ($field = $widget->getField('content')) {
            $field->displayAs($this->fieldWidgetPath);
            $field->stretch = true;
        }
    }

    protected function extendModel()
    {
        // Replacing original content_html attribute.
        $this->modelClass::extend(function ($model) {
            $model->implement[] = 'ReaZzon.Editor.Behaviors.ConvertToHtml';

            $model->bindEvent('model.getAttribute', function ($attribute, $value) use ($model) {
                if ($attribute == 'content_html') {
                    return $model->convertJsonToHtml($model->getAttribute('content'));
                }
            });

            $model->bindEvent('model.translate.resolveComputedFields', function ($locale) use ($model) {
                return [
                    'content_html' => $model->convertJsonToHtml($model->asExtension('TranslatableModel')->getAttributeTranslated('content', $locale))
                ];
            });
        });
    }

    protected function getControllerClass()
    {
        return \RainLab\Blog\Controllers\Posts::class;
    }

    protected function getModelClass()
    {
        return \RainLab\Blog\Models\Post::class;
    }

    protected function isEnabled()
    {
        if (Settings::get('integration_blog', false) &&
            PluginManager::instance()->hasPlugin('RainLab.Blog')) {
            return true;
        }

        return false;
    }
}
