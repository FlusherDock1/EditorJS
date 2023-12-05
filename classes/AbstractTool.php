<?php namespace ReaZzon\Editor\Classes;

use October\Rain\Extension\ExtendableTrait;
use ReaZzon\Editor\Classes\Contracts\EditorJsTune;

abstract class AbstractTool implements EditorJsTune
{
    use ExtendableTrait;
}
