<?php

namespace FF\NovaTools\Fields\Display;

use DateTimeInterface;
use FF\NovaTools\Core\Fields\SupportRelationshipStore;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\SupportsDependentFields;

class Display extends Field
{
    use SupportRelationshipStore;
    use SupportsDependentFields;

    public $component = 'display-field';

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta([
            'asHtml' => false,
        ]);
    }

    protected function resolveAttribute($resource, $attribute): mixed
    {
        $newAttribute = parent::resolveAttribute($resource, $attribute);

        return $newAttribute instanceof DateTimeInterface
            ? $resource->serializeDate($newAttribute)
            : $newAttribute;
    }

    public function displayUsingLabels(array|callable $switchValue)
    {
        if (is_callable($switchValue)) {
            $switchValue = $switchValue();
        }
        return $this->resolveUsing(function ($value) use ($switchValue) {
            return $switchValue[$value] ?? '';
        });
    }

    public function nl2br(bool $value = true)
    {
        $this->withMeta([
            'nl2br' => $value,
            'asHtml' => true,
        ]);

        return $this->resolveUsing(function ($value) {
            return nl2br($value);
        });
    }

    public function width(int $value)
    {
        return $this->withMeta(['width' => $value]);
    }

    public function asHtml(bool $value = true)
    {
        return $this->withMeta(['asHtml' => $value]);
    }

    public function fillModelWithData(mixed $model, mixed $value, string $attribute): void
    {
    }
}
