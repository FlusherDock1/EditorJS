<?php namespace ReaZzon\Editor\Tunes;

use ReaZzon\Editor\Classes\Tune;

class TextVariantTune extends Tune
{
    public function registerSettings(): string
    {
        return 'TextVariantTune';
    }

    public function registerAppliedTools(): array
    {
        return [
            'paragraph'
        ];
    }

    public function registerScripts(): array
    {
        return [
            '/plugins/reazzon/editor/assets/js/text-variant-tuneTune.js'
        ];
    }
}
