<?php

namespace FF\NovaTools\Fields\URL;

use Laravel\Nova\Fields\URL as NovaURL;

class URL extends NovaURL
{
    public $component = 'url-field';

    public function __construct($name = null, $attribute = null, $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);
        $this->withMeta([
            'newWindow' => true,
        ]);
    }

    public function newWindow($enable = null) {
        return $this->withMeta(['newWindow' => $enable]);
    }
}