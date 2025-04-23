<?php

namespace FF\NovaTools\Core;

use Laravel\Nova\Menu\MenuGroup as NovaMenuGroup;

class MenuGroup extends NovaMenuGroup
{
    public $collapsedByDefault = true;
}