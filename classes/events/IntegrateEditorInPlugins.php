<?php namespace ReaZzon\Editor\Classes\Events;

use Backend\Widgets\Form;
use October\Rain\Database\Model;
use October\Rain\Events\Dispatcher;
use ReaZzon\Editor\Classes\JSONConverter;
use ReaZzon\Editor\FormWidgets\EditorJS;
use ReaZzon\Editor\Settings\Settings;
use System\Classes\PluginManager;

class IntegrateEditorInPlugins
{
    public function subscribe(Dispatcher $event): void
    {
        if (Settings::get('integrations.rainlab_blog', false) &&
            PluginManager::instance()->hasPlugin('RainLab.Blog')) {
            $this->extendRainlabBlog($event);
        }
        if (Settings::get('integrations.lovata_good_news', false) &&
            PluginManager::instance()->hasPlugin('Lovata.GoodNews')) {
            $this->extendLovataGoodNews($event);
        }
    }

    protected function extendRainlabBlog($event): void
    {
        \RainLab\Blog\Models\Post::extend(function (Model $model) {
            $model->bindEvent('model.setAttribute', function ($name) use ($model) {
                if ($name === 'content') {
                    if (empty($model->getAttribute('content'))) {
                        return $model->getAttribute('content');
                    }

                    $converter = new JSONConverter($model->getAttribute('content'));
                    $model->content_html = html_entity_decode($converter->validate()->getHTML());
                }
            });
        });

        $event->listen('backend.form.extendFields', function (Form $widget) {
            if (!$widget->getController() instanceof \RainLab\Blog\Controllers\Posts || $widget->isNested) {
                return;
            }

            if (!$widget->model instanceof \RainLab\Blog\Models\Post) {
                return;
            }

            $widget->getField('content')->displayAs(EditorJS::class)->stretch(true);
        });
    }

    protected function extendLovataGoodNews($event): void
    {
        \Lovata\GoodNews\Classes\Item\ArticleItem::extend(function ($elementItem) {
            $elementItem->addDynamicMethod('getContentAttribute', function () use ($elementItem) {
                $converter = new JSONConverter($elementItem->getAttribute('content'));
                return $converter->validate()->getHTML();
            });
        });

        \Lovata\GoodNews\Models\Article::extend(function (Model $model) {
            $model->bindEvent('model.getAttribute', function ($name) use ($model) {
                if ($name === 'content_html') {
                    if (empty($model->getAttribute('content'))) {
                        return $model->getAttribute('content');
                    }

                    $converter = new JSONConverter($model->getAttribute('content'));
                    return $converter->validate()->getHTML();
                }
            });
        });

        $event->listen('backend.form.extendFields', function (Form $widget) {
            if (!$widget->getController() instanceof \Lovata\GoodNews\Controllers\Articles || $widget->isNested) {
                return;
            }

            if (!$widget->model instanceof \Lovata\GoodNews\Models\Article) {
                return;
            }

            $widget->getField('content')->displayAs(EditorJS::class)->stretch(true);
        });
    }
}
