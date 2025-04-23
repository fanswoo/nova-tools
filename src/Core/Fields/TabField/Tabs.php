<?php

namespace FF\NovaTools\Core\Fields\TabField;

use Laravel\Nova\Tabs\Tab;

class Tabs
{
    static public function make(string $name, array $tabs)
    {
        return Tab::group($name, $tabs);
    }
}