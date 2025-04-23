<?php

namespace FF\NovaTools\Fields\Boolean;

use FF\NovaTools\Core\Fields\SupportRelationshipStore;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\Boolean as NovaBoolean;
use Laravel\Nova\Http\Requests\NovaRequest;

class Boolean extends NovaBoolean
{
    use SupportRelationshipStore;
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute): void
    {
        if (!isset($request[$requestAttribute])) {
            return;
        }

        $value = $request[$requestAttribute] == 1 ? $this->trueValue : $this->falseValue;

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