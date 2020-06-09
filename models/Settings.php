<?php namespace ReaZzon\Editor\Models;

use Model;

/**
 * Class Settings
 * @package ReaZzon\Editor\Models
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    /**
     * @var string A unique code
     */
    public $settingsCode = 'reazzon_editor_settings';

    /**
     * @var string Reference to field configuration
     */
    public $settingsFields = 'fields.yaml';
}