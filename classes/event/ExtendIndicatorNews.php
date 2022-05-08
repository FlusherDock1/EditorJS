<?php namespace ReaZzon\Editor\Classes\Event;

use Backend\Widgets\Form;
use System\Classes\PluginManager;
use ReaZzon\Editor\Models\Settings;

/**
 * Class ExtendIndicatorNews
 * @package ReaZzon\Editor\Classes\Event
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class ExtendIndicatorNews extends AbstractFormExtender
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
        \Indikator\News\Models\Posts::extend(function ($model) {
            /** @var \October\Rain\Database\Model $model */
            $model->implement[] = 'ReaZzon.Editor.Behaviors.ConvertToHtml';

            $model->addDynamicMethod('getContentRenderAttribute', function () use ($model) {
                return $model->convertJsonToHtml($model->getAttribute('content'));
            });
        });
    }

    protected function getControllerClass()
    {
        return \Indikator\News\Controllers\Posts::class;
    }

    protected function getModelClass()
    {
        return \Indikator\News\Models\Posts::class;
    }

    protected function isEnabled()
    {
        if (Settings::get('integration_indikator_news', false) &&
            PluginManager::instance()->hasPlugin('Indikator.News')) {
            return true;
        }

        return false;
    }
}
