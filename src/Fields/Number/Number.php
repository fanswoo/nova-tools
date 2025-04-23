<?php

namespace FF\NovaTools\Fields\Number;

use FF\NovaTools\Core\Fields\SupportRelationshipStore;
use Laravel\Nova\Fields\Number as NovaNumber;

class Number extends NovaNumber
{
    use SupportRelationshipStore;
}
