<?php

namespace FF\NovaTools\Fields\Text;

use FF\NovaTools\Core\Fields\SupportRelationshipStore;
use Laravel\Nova\Fields\Text as NovaText;

class Text extends NovaText
{
    use SupportRelationshipStore;
}
