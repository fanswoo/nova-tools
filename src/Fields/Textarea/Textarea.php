<?php

namespace FF\NovaTools\Fields\Textarea;

use FF\NovaTools\Core\Fields\SupportRelationshipStore;
use Laravel\Nova\Fields\Textarea as NovaTextarea;

class Textarea extends NovaTextarea
{
    use SupportRelationshipStore;
}
