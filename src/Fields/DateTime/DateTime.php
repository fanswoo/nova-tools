<?php

namespace FF\NovaTools\Fields\DateTime;

use FF\NovaTools\Core\Fields\SupportRelationshipStore;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\SupportsDependentFields;

class DateTime extends Field
{
    use SupportRelationshipStore,
        SupportsDependentFields;

    public $component = 'date-time-field';

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta([
            'mode' => 'DateTime',
        ]);
    }

    public function mode(string $mode)
    {
        return $this->withMeta([
            'mode' => $mode,
        ]);
    }
}
