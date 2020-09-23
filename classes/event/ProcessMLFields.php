<?php namespace ReaZzon\Editor\Classes\Event;

/**
 * Class ProcessMLFields
 * @package ReaZzon\Editor\Classes\Event
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class ProcessMLFields
{
    public function subscribe($event)
    {
        $event->listen('backend.form.extendFieldsBefore', function($widget){

            if (!$model = $widget->model) {
                return;
            }

            if (!method_exists($model, 'isClassExtendedWith')) {
                return;
            }

            if (
                !$model->isClassExtendedWith('RainLab.Translate.Behaviors.TranslatableModel') &&
                !$model->isClassExtendedWith('RainLab.Translate.Behaviors.TranslatablePage') &&
                !$model->isClassExtendedWith('RainLab.Translate.Behaviors.TranslatableCmsObject')
            ) {
                return;
            }


            if (!$model->hasTranslatableAttributes()) {
                return;
            }

            if (!empty($widget->config->fields) && !$widget->isNested) {
                $widget->fields = $this->processFormMLFields($widget->fields, $model);
            }

            if (!empty($widget->config->tabs['fields'])) {
                $widget->tabs['fields'] = $this->processFormMLFields($widget->tabs['fields'], $model);
            }

            if (!empty($widget->config->secondaryTabs['fields'])) {
                $widget->secondaryTabs['fields'] = $this->processFormMLFields($widget->secondaryTabs['fields'], $model);
            }
        });
    }

    /**
     * Helper function to replace standard fields with multi lingual equivalents
     * @param  array $fields
     * @param  Model $model
     * @return array
     */
    protected function processFormMLFields($fields, $model)
    {
        $translatable = array_flip($model->getTranslatableAttributes());

        foreach ($fields as $name => $config) {

            if (!array_key_exists($name, $translatable)) {
                continue;
            }

            if (array_get($config, 'type') == 'editorjs') {
                $fields[$name]['type'] = 'mleditorjs';
            }
        }

        return $fields;
    }
}