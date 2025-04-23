<?php

namespace FF\NovaTools\Fields\CustomField;

/**
 * @var string $component component name
 */
interface CustomFieldContract
{
    function customResolve($resource);

    function customFill($model, $value): void;
}