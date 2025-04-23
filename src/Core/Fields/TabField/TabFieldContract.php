<?php

namespace FF\NovaTools\Core\Fields\TabField;

use Laravel\Nova\Tabs\Tab;

interface TabFieldContract
{
    public function title(): string;

    public function name(): string;

    public function make(): Tab;

    public function fields(): array;
}