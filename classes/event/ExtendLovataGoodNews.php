<?php namespace ReaZzon\Editor\Classes\Event;

use Backend\Widgets\Form;
use System\Classes\PluginManager;
use ReaZzon\Editor\Models\Settings;

/**
 * Class ExtendLovataGoodNews
 * @package ReaZzon\Editor\Classes\Event
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class ExtendLovataGoodNews extends AbstractFormExtender
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
        \Lovata\GoodNews\Classes\Item\ArticleItem::extend(function ($elementItem) {
            /** @var \October\Rain\Database\Model $elementItem */
            $elementItem->implement[] = 'ReaZzon.Editor.Behaviors.ConvertToHtml';

            $elementItem->addDynamicMethod('getContentAttribute', function () use ($elementItem) {
                return $elementItem->convertJsonToHtml($elementItem->getAttribute('content'));
            });
        });
    }

    protected function getControllerClass()
    {
        return \Lovata\GoodNews\Controllers\Articles::class;
    }

    protected function getModelClass()
    {
        return \Lovata\GoodNews\Models\Article::class;
    }

    protected function isEnabled()
    {
        if (Settings::get('integration_good_news', false) &&
            PluginManager::instance()->hasPlugin('Lovata.GoodNews')) {
            return true;
        }

        return false;
    }
}
