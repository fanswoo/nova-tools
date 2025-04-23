<?php

namespace Fields\HtmlEditor;

use FF\Nova\Core\Fields\SupportRelationshipStore;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\SupportsDependentFields;

class HtmlEditor extends Field
{
    use SupportsDependentFields;

    use SupportRelationshipStore {
        fillModelWithData as fillModelWithRelationshipData;
    }

    public $component = 'html-editor-field';

    public $showOnIndex = false;

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta(['mode' => 'simple']);
    }

    public function pics(string $pics)
    {
        return $this->withMeta(['pics' => $pics]);
    }

    public function mode(string $mode)
    {
        return $this->withMeta(['mode' => $mode]);
    }

    public function fillModelWithData(mixed $model, mixed $value, string $attribute): void
    {
        $picIds = [];
        $values = json_decode($value, true);

        if (
            array_key_exists('picIds', $values) &&
            array_key_exists('pics', $this->meta)
        ) {
            $picIds = $values['picIds'];
        }

        $this->fillModelWithRelationshipData($model, $values['content'], $attribute);

        if (array_key_exists('picIds', $values)) {
            if (!array_key_exists('pics', $this->meta)) {
                throw new \Exception('Please set the pics relationship name first');
            }
            $model->save();
            $metaPics = $this->meta['pics'];
            $model->{$metaPics}('set', $picIds);
        }
    }
}
