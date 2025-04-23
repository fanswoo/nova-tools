<?php

namespace FF\NovaTools\Core\Fields;

use Illuminate\Support\Str;

trait SupportRelationshipStore
{

    public function fillModelWithData(mixed $model, mixed $value, string $attribute): void {
        if(str_contains($attribute, '->') ) {
            $relationshipAndAttribute = explode('->', $attribute);
            $relationship = $relationshipAndAttribute[0];
            $relationshipAttribute = $relationshipAndAttribute[1];

            $model->$relationship()->updateOrCreate(
                [],
                [
                    $relationshipAttribute => $value
                ]
            );
            return;
        }

        $attributes = [Str::replace('.', '->', $attribute) => $value];
        $model->forceFill($attributes);
    }
}