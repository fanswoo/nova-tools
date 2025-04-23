<?php

namespace FF\NovaTools\Http\Requests;

use Illuminate\Database\Eloquent\Collection;
use Laravel\Nova\Contracts\QueryBuilder;
use Laravel\Nova\Http\Requests\ResourceSearchRequest;

class MorphTagSearchRequest extends ResourceSearchRequest
{
    public function searchIndex(): Collection
    {
        $resource = $this->resource();
        $model = $this->model();

        $limit = $resource::usesScout()
            ? $resource::$scoutSearchResults
            : $resource::$relatableSearchResults;

        $query = app()->make(QueryBuilder::class, [$resource]);

        if ($this->first === 'true') {
            $query->whereKey($model->newQueryWithoutScopes(), $this->current);
        } else {
            if ($this->allowDuplicateRelations === 'false' && $this->currentValue) {
                $query->tap(function ($query) {
                    $query->whereNotIn('id', $this->currentValue);
                });
            }

            $query->search(
                $this, $this->newQuery(), $this->search,
                $this->filters()->all(), $this->orderings(), $this->trashed()
            );
        }

        return $query->take($limit)->get();
    }
}