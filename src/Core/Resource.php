<?php

namespace FF\NovaTools\Core;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;

abstract class Resource extends NovaResource
{
    public static $tableStyle = 'tight';

    public static $clickAction = 'select';

    public static array $indexDefaultOrder = [];

    public static $perPageOptions = [30, 60, 90];

    public static $relatableSearchResults = 30;

    protected static array $attributeOwnRelationshipFields = [];

    public static function indexQuery(NovaRequest $request, $query)
    {
        if (
            static::$indexDefaultOrder &&
            empty($request->get('orderBy'))
        ) {
            $query->getQuery()->orders = [];
            foreach( static::$indexDefaultOrder as $attribute => $value) {
                $query->orderBy($attribute, $value);
            }
        }
        return $query;
    }

    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query);
    }

    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/'.static::uriKey();
    }

    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return '/resources/'.static::uriKey();
    }

    public static function redirectAfterDelete(NovaRequest $request)
    {
        return '/resources/'.static::uriKey();
    }

    public static function redirectAfterForceDelete(NovaRequest $request)
    {
        return '/resources/'.static::uriKey();
    }
}
