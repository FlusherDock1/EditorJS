<?php namespace ReaZzon\Editor\Classes\Contracts;

interface EditorJsTune
{
    public function registerSettings(): string|array;
    public function registerAppliedTools(): array;
    public function registerScripts(): array;
}
