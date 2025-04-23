<?php

namespace FF\NovaTools\Fields\HasManyButton;

use Laravel\Nova\Fields\Tag as NovaTag;
use Laravel\Nova\Http\Requests\NovaRequest;

class HasManyButton extends NovaTag
{
    public $component = 'has-many-button';

    public function __construct($name, $attribute = null, $resource = null)
    {
        parent::__construct($name, $attribute, $resource);
    }

    public function withSubtitles()
    {
        return $this->withMeta([
            'withSubtitles' => true,
        ]);
    }

    protected function deleteOtherRelations($model, $attribute, $values)
    {
        $currentRelationIds = $model->{$attribute}->pluck('id')->toArray();
        foreach ($currentRelationIds as $value) {
            if (!in_array($value, $values)) {
                $result[] = $value;
            }
        }

        if (isset($result)) {
            $relationModelName = $this->resourceClass::$model;
            $needsDeleteModels = $relationModelName::find($result);
            foreach ($needsDeleteModels as $model) {
                $model->delete();
            }
        }
    }

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute): \Closure
    {
        return function () use ($model, $attribute, $request, $requestAttribute) {
            $values = $this->prepareRelations($request, $requestAttribute);

            $relationModelName = $this->resourceClass::$model;
            $relationModels = $relationModelName::find($values);

            $this->deleteOtherRelations($model, $attribute, $values);
            $model->{$attribute}()->saveMany($relationModels);
        };
    }

    protected function resolveAttribute($resource, $attribute): array
    {
        return $resource->{$attribute}
            ->map(function ($model) {
                $resource = new $this->resourceClass($model);
                return $this->transformResult(
                    app(NovaRequest::class), $resource
                );
            })->values()->all();
    }
}
