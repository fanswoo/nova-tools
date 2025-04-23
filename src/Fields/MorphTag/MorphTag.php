<?php

namespace FF\NovaTools\Fields\MorphTag;

use App\Common\ClassTag\ClassTaggable;
use Laravel\Nova\Fields\Tag as NovaTag;
use Laravel\Nova\Http\Requests\NovaRequest;

class MorphTag extends NovaTag
{
    public $component = 'morph-tag-field';

    public function __construct($name, $attribute = null, $resource = null)
    {
        parent::__construct($name, $attribute, $resource);

        $this->withMeta([
            'allowDuplicateRelations' => false,
        ]);
    }

    public function withSubtitles()
    {
        return $this->withMeta([
            'withSubtitles' => true,
        ]);
    }

    public function allowDuplicateRelations()
    {
        return $this->withMeta([
            'allowDuplicateRelations' => true,
        ]);
    }

    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute): \Closure
    {
        return function () use ($model, $attribute, $request, $requestAttribute) {
            $values = $this->prepareRelations($request, $requestAttribute);
            $model->{$attribute}()->sync($values);
            ClassTaggable::whereIn('classTagId', $values)
                ->where('classTaggableType', $model->getMorphClass())
                ->update([
                    'classTaggableAttribute' => $requestAttribute
                ]);
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
