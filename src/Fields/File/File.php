<?php

namespace Fields\File;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\SupportsDependentFields;

class File extends Field
{
    use SupportsDependentFields;

    public $component = 'relation-file-field';

    public $showOnIndex = false;

    public function fillModelWithData(mixed $model, mixed $value, string $attribute): void
    {
        $model->save();

        $fileIds = explode(',', $value);
        $model->{$attribute}('set', $fileIds);
    }
}
