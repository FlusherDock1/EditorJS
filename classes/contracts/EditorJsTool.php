<?php namespace ReaZzon\Editor\Classes\Contracts;

interface EditorJsTool
{
    public function registerSettings(): array;
    public function registerValidations(): array;
    public function registerScripts(): array;
    public function registerViews(): array;
}
