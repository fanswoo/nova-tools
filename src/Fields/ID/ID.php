<?php

namespace FF\NovaTools\Fields\ID;

use Laravel\Nova\Fields\ID as NovaID;

class ID extends NovaID
{
    public $component = 'id-field';

    public function __construct($name = null, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
        $this->withMeta([
            'sortable' => true,
            'alwaysLinkToViewPage' => false,
            'displayText' => null,
        ]);
    }

    public function displayText($attribute)
    {
        return $this->withMeta(['displayText' => $attribute]);
    }

    public function alwaysLinkToViewPage($value = true)
    {
        return $this->withMeta(['alwaysLinkToViewPage' => $value]);
    }

    protected function resolveAttribute($resource, string $attribute): string|int|null
    {
        if($this->meta['displayText']) {
            $this->displayText = $resource->{$this->meta['displayText']};
        }
        return parent::resolveAttribute($resource, $attribute);
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), array_filter([
            'pivotValue' => $this->pivotValue ?? null,
            'displayText' => $this->displayText ?? null,
        ]));
    }
}