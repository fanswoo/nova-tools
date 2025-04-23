<?php

namespace FF\NovaTools\Fields\Updated;

use FF\NovaTools\Fields\Display\Display;

class Updated
{
    public static function make(): Display
    {
        return Display::make('更新時間', 'updatedAt')
            ->hideWhenCreating()
            ->sortable();
    }
}