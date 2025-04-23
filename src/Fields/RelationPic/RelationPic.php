<?php

namespace Fields\RelationPic;

use FF\Nova\Core\Fields\SupportRelationshipStore;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\SupportsDependentFields;

class RelationPic extends Field
{
    use SupportsDependentFields, SupportRelationshipStore;

    public $component = 'relation-pic-field';

    protected function resolveAttribute($resource, $attribute): array {
        $this->withMeta([
            'postMaxSize' => getPostMaxSize(),
            'uploadMaxSize' => getUploadMaxSize(),
            'relatedPicName' => $resource->{$attribute}()->getRelated()::class,
        ]);
        return parent::resolveAttribute($resource, $attribute)->toArray();
    }

    public function fillModelWithData(mixed $model, mixed $value, string $attribute): void
    {
        $model->save();

        $values = json_decode($value, true);
        $picIds = collect($values)->pluck('id')->toArray();
        $model->{$attribute}('set', $picIds);
    }
}
