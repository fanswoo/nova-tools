<?php

namespace FF\NovaTools\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use Laravel\Nova\Util;
use FF\NovaTools\Http\Requests\MorphTagSearchRequest;

class MorphTagSearchController extends Controller
{
    public function __invoke(MorphTagSearchRequest $request)
    {
        $resource = $request->resource();

        return response()->json([
            'resources' => $request->searchIndex()
                ->mapInto($resource)
                ->map(function ($resource) use ($request) {
                    return $this->transformResult($request, $resource);
                })->values(),
            'softDeletes' => $resource::softDeletes(),
        ]);
    }

    protected function transformResult(NovaRequest $request, Resource $resource)
    {
        return array_filter([
            'avatar' => $resource->resolveAvatarUrl($request),
            'display' => (string) $resource->title(),
            'subtitle' => $resource->subtitle(),
            'value' => Util::safeInt($resource->getKey()),
        ]);
    }
}