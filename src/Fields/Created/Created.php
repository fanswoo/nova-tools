<?php

namespace FF\NovaTools\Fields\Created;

use FF\NovaTools\Fields\Display\Display;

class Created
{
    public static function make(): Display
    {
        return Display::make('建立時間', 'createdAt')
            ->hideWhenCreating()
            ->sortable();
    }
}