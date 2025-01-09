<?php namespace ReaZzon\Editor\Tools;

use ReaZzon\Editor\Classes\Tool;

class MarkerTool extends Tool
{
    public function registerSettings(): array
    {
        return [
            'class' => 'Marker',
            'shortcut' => 'CMD+SHIFT+M',
        ];
    }

    public function registerValidations(): array
    {
        return [];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/assets/js/markerTool.js'
        ];
    }

    public function registerView(): ?string
    {
        return null;
    }
}
