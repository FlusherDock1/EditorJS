<?php namespace ReaZzon\Editor\Classes\Contracts;

interface EditorJsTune
{
    public function registerSettings(): array;
    public function registerValidations(): array;
    public function registerScripts(): array;
}
