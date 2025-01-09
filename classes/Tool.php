<?php namespace ReaZzon\Editor\Classes;

use October\Rain\Extension\ExtendableTrait;
use ReaZzon\Editor\Classes\Contracts\EditorJsTool;

abstract class Tool implements EditorJsTool
{
    use ExtendableTrait;
}
