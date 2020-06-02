<?php namespace ReaZzon\Editor\Classes;

class EditorSave
{
    public static function save()
    {
        $data = \Input::all();
        return true;
    }
}