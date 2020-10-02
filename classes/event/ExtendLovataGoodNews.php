<?php namespace ReaZzon\Editor\Classes\Event;

use System\Classes\PluginManager;
use ReaZzon\Editor\Models\Settings;

/**
 * Class ExtendLovataGoodNews
 * @package ReaZzon\Editor\Classes\Event
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class ExtendLovataGoodNews
{
    /**
     * Add listeners
     * @param \Illuminate\Events\Dispatcher $event
     */
    public function subscribe($event)
    {
        if (Settings::get('integration_good_news', false) &&
            PluginManager::instance()->hasPlugin('Lovata.GoodNews')) {

            $event->listen('backend.form.extendFields', function ($widget) {

                // Only for Lovata.GoodNews Articles controller
                if (!$widget->getController() instanceof \Lovata\GoodNews\Controllers\Articles) {
                    return;
                }

                // Only for Lovata.GoodNews Article model
                if (!$widget->model instanceof \Lovata\GoodNews\Models\Article) {
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

            // Replacing original content attribute.
            \Lovata\GoodNews\Classes\Item\ArticleItem::extend(function ($elementItem) {
                /** @var \October\Rain\Database\Model $elementItem */
                $elementItem->implement[] = 'ReaZzon.Editor.Behaviors.ConvertToHtml';

                $elementItem->addDynamicMethod('getContentAttribute', function () use ($elementItem) {
                    return $elementItem->convertJsonToHtml($elementItem->getAttribute('content'));
                });
            });
        }
    }
}