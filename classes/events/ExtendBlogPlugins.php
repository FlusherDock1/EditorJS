<?php namespace ReaZzon\Editor\Classes\Events;

use Backend\Widgets\Form;
use October\Rain\Database\Model;
use October\Rain\Events\Dispatcher;
use ReaZzon\Editor\Classes\JSONConverter;
use ReaZzon\Editor\FormWidgets\EditorJS;
use RainLab\Blog\Controllers\Posts;
use RainLab\Blog\Models\Post;

class ExtendBlogPlugins
{
    public function subscribe(Dispatcher $event): void
    {
        Post::extend(fn (Model $model) => $model->bindEvent('model.setAttribute', function ($name) use ($model) {
            if ($name === 'content') {
                if (empty($model->getAttribute('content'))) {
                    return $model->getAttribute('content');
                }

                $converter = new JSONConverter($model->getAttribute('content'));
                $model->content_html = html_entity_decode($converter->validate()->getHTML());
            }
        }));

        $event->listen('backend.form.extendFields', function (Form $widget) {
            if (!$widget->getController() instanceof Posts || $widget->isNested) {
                return;
            }

            if (!$widget->model instanceof Post) {
                return;
            }

            $widget->getField('content')->displayAs(EditorJS::class)->stretch(true);
        });
    }
}
