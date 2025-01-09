<?php namespace ReaZzon\Editor\Classes\Events;

use Backend\Widgets\Form;
use October\Rain\Events\Dispatcher;
use ReaZzon\Editor\Classes\JSONConverter;
use ReaZzon\Editor\FormWidgets\EditorJS;

class ExtendBlogPlugins
{
    public function subscribe(Dispatcher $event): void
    {
        $plugins = [
            [
                'controller' => \RainLab\Blog\Controllers\Posts::class,
                'model' => \RainLab\Blog\Models\Post::class,
                'field' => 'content'
            ]
        ];

        foreach ($plugins as $plugin) {
            $this->extendModel($plugin['model']);

            $event->listen('backend.form.extendFields', function (Form $widget) use ($plugin) {
                if (!$widget->getController() instanceof $plugin['controller'] || $widget->isNested) {
                    return;
                }

                if (!$widget->model instanceof $plugin['model']) {
                    return;
                }

                $this->replaceField($widget, $plugin['field']);
            });
        }
    }

    protected function replaceField($widget, $fieldName): void
    {
        $widget->getField($fieldName)->displayAs(EditorJS::class)->stretch(true);
    }

    protected function extendModel($modelClass)
    {
        $modelClass::extend(function ($model) {
            $model->bindEvent('model.getAttribute', function ($attribute) use ($model) {
                if ($attribute == 'content_html') {
                    if (empty($model->getAttribute('content'))) {
                        return $model->getAttribute('content');
                    }

                    $converter = new JSONConverter($model->getAttribute('content'));
                    return $converter->validate()->getHTML();
                }
            });
        });
    }
}
