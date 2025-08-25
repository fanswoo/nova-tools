<?php

namespace FF\NovaTools\Fields\Select;

use FF\NovaTools\Core\Fields\SupportRelationshipStore;
use Laravel\Nova\Fields\Select as NovaSelect;

class Select extends NovaSelect
{
    use SupportRelationshipStore;
}
