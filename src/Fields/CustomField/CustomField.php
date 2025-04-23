<?php

namespace FF\NovaTools\Fields\CustomField;

use Laravel\Nova\Fields\Field;

/**
 * @method static static make(mixed $name = null, string|callable|object|null $attribute = null, callable|null $resolveCallback = null)
 */
abstract class CustomField extends Field implements CustomFieldContract
{
    public function __construct(string $name = null)
    {
        $name = $name ?? $this->name;
        parent::__construct(
            $name ?? $this->transferClassName(static::class),
            null,
            null
        );
    }

    protected function transferClassName(string $className): string {
        $classNameArray = explode('\\', $className);

        $newName = '';
        foreach($classNameArray as $key => $value) {
            if( $key === 0) {
                $newName = strtolower($value);
                continue;
            }
            $newName .= '-' . strtolower($value);
        }

        return $newName;
    }

    protected function resolveAttribute($resource, $attribute): mixed
    {
        return $this->customResolve($resource);
    }

    public function fillModelWithData($model, $value, string $attribute): void
    {
        if(!$model->id) {
            $model->save();
        }
        $newValue = json_decode($value, true);
        $this->customFill($model, $newValue);
    }
}