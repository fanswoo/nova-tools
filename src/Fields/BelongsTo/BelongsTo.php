<?php

namespace FF\NovaTools\Fields\BelongsTo;

use FF\NovaTools\Core\Fields\RelatableQueryUsingFixed;
use Laravel\Nova\Fields\BelongsTo as NovaBelongsTo;

class BelongsTo extends NovaBelongsTo
{
    use RelatableQueryUsingFixed;
}