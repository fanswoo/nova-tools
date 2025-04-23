<?php

namespace FF\NovaTools\Core\Fields;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Http\Requests\NovaRequest;

trait RelatableQueryUsingFixed
{
    protected function applyAssociatableCallbacks(Builder $query, NovaRequest $request, string $resourceClass, Model $model)
    {
        if (
            is_callable($this->relatableQueryCallback) &&
            $request->query('first') === 'false'
        ) {
            call_user_func($this->relatableQueryCallback, $request, $query);

            return;
        }

        forward_static_call($this->relatableQueryCallable($request, $model, $resourceClass), $request, $query, $this);
    }
}