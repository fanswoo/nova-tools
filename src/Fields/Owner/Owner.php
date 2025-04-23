<?php

namespace FF\NovaTools\Fields\Owner;

use FF\NovaTools\Fields\BelongsTo\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Http\Requests\NovaRequest;

class Owner extends BelongsTo
{
    public function __construct(string $name, string $attribute, string $resolveCallback)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this
            ->withSubtitles()
            ->withoutTrashed()
            ->sortable()
            ->default(function () {
                return request()->user()->id;
            });
    }

    public function setPermission(array $optionPermission, array $managerPermission): self
    {
        $this->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($optionPermission, $managerPermission) {
            return $query
                ->purview(array_merge($optionPermission, $managerPermission))
                ->orWhere(function ($query) use ($request, $managerPermission) {
                    $query->where('id', $request->query('current'));
                });
        });

        $this->readonly(function () use ($managerPermission) {
            if (
                request()->query('editMode') === 'create'
            ) {
                return false;
            }
            return !request()->user()->checkPurview($managerPermission);
        });

        return $this;
    }
}