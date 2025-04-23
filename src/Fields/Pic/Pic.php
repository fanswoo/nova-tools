<?php

namespace FF\NovaTools\Fields\Pic;

use FF\NovaTools\Core\Fields\SupportRelationshipStore;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\SupportsDependentFields;

class Pic extends Field
{
    use SupportsDependentFields, SupportRelationshipStore;

    public $component = 'pic-field';

    protected function resolveAttribute($resource, $attribute): array {
        return parent::resolveAttribute($resource, $attribute)->toArray();
    }
}
