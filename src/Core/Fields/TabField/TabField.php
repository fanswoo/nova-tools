<?php

namespace FF\NovaTools\Core\Fields\TabField;

use Closure;
use FF\NovaTools\Core\Resource;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Tabs\Tab;

abstract class TabField implements TabFieldContract
{
    protected Resource $resource;

    protected ?Closure $seeCallback = null;

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function make(): Tab {
        $request = app(NovaRequest::class);

        if(
            $this->seeCallback &&
            !($this->seeCallback)($request)
        ) {
            return Tab::make(
                '',
                [],
                ''
            );
        }

        return Tab::make(
            $this->title(),
            $this->fields(),
            $this->name()
        );
    }

    public function canSee(Closure $callback): self {
        $this->seeCallback = $callback;

        return $this;
    }
}