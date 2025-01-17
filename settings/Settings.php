<?php namespace ReaZzon\Editor\Settings;

use System\Models\SettingModel;

class Settings extends SettingModel
{
    public $settingsCode = 'reazzon_editor_settings';

    public $settingsFields = 'fields.yaml';
}
