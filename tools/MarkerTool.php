<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\AbstractTune;

class MarkerTool extends AbstractTune
{
    public function registerSettings(): array
    {
        return [
            'class' => 'Marker',
            'shortcut' => 'CMD+SHIFT+M'
        ];
    }

    public function registerValidations(): array
    {
        return [];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/tunes/js/markerTool.js'
        ];
    }
}
