<?php

namespace FF\NovaTools\Fields\HtmlEditor;

use FF\NovaTools\Core\Fields\SupportRelationshipStore;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\SupportsDependentFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaTranslatable\FieldServiceProvider;

class HtmlEditor extends Field
{
    use SupportsDependentFields;

    use SupportRelationshipStore {
        fillModelWithData as fillModelWithRelationshipData;
    }

    public $component = 'html-editor-field';

    public $showOnIndex = false;

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->withMeta(['mode' => 'simple']);
    }

    public function pics(string $pics)
    {
        return $this->withMeta(['pics' => $pics]);
    }

    public function mode(string $mode)
    {
        return $this->withMeta(['mode' => $mode]);
    }

    public function fillModelWithData(mixed $model, mixed $value, string $attribute): void
    {
        $picIds = [];
        $values = json_decode($value, true);

        if (
            array_key_exists('picIds', $values) &&
            array_key_exists('pics', $this->meta)
        ) {
            $picIds = $values['picIds'];
        }

        $this->fillModelWithRelationshipData($model, $values['content'], $attribute);

        if (array_key_exists('picIds', $values)) {
            if (!array_key_exists('pics', $this->meta)) {
                throw new \Exception('Please set the pics relationship name first');
            }
            $model->save();
            $metaPics = $this->meta['pics'];
            $model->{$metaPics}('set', $picIds);
        }
    }

    public function translatable($overrideLocales = [], $options = [])
    {
        $locales = FieldServiceProvider::getLocales($overrideLocales);
        $component = $this->component;
        $this->__translatable = true;

        $originalResolveCallback = $this->resolveCallback;
        $this->resolveUsing(function ($value, $resource, $attribute) use ($locales, $component, $originalResolveCallback, $options) {
            if ($originalResolveCallback) $this->resolveCallback = $originalResolveCallback;
            $attribute = FieldServiceProvider::normalizeAttribute($attribute);

            // Load value from either the model or from the given $value
            if (isset($resource) && (is_object($resource) || is_string($resource)) && method_exists($resource, 'getTranslations')) {
                // In case a model has the HasTranslations trait, but some fields are wrapped
                // we must be prepared to get an Exception here
                try {
                    $value = $resource->getTranslations($attribute);
                } catch (Exception $e) {
                    $value = [];
                }
            }

            if (empty($value)) {
                $value = data_get($resource, str_replace('->', '.', $attribute)) ?? [];
            }

            try {
                if (!is_array($value)) {
                    if (is_object($value)) {
                        if ($value instanceof Arrayable) {
                            $value = $value->toArray();
                        } else {
                            $value = (array)$value;
                        }
                    } else {
                        $testValue = json_decode($value, true);
                        if (is_array($testValue)) $value = $testValue;
                    }
                }
            } catch (Exception $e) {
            }

            if (!empty($value)) {
                $value = array_map(function ($val) {
                    return !is_numeric($val) || (is_string($val) && ($val[0] === '0' || $val[0] === '+')) ? $val : (float)$val;
                }, (array)$value);
            }

            // Nova 2.9 support
            $request = app(NovaRequest::class);
            $defaultValue = method_exists($this, 'resolveDefaultValue') ? $this->resolveDefaultValue($request) : '';

            $prioritizeNovaLocale = isset($options['prioritizeNovaLocale'])
                ? $options['prioritizeNovaLocale']
                : config('nova-translatable.prioritize_nova_locale', true);

            $displayType = isset($options['displayType'])
                ? $options['displayType']
                : config('nova-translatable.display_type', 'row');

            $fillOtherLocalesFrom = isset($options['fillOtherLocalesFrom'])
                ? $options['fillOtherLocalesFrom']
                : config('nova-translatable.fill_other_locales_from', null);

            // Fix strings being casted to floats
            if ($this instanceof Text && !$this instanceof Number && !empty($value)) {
                foreach ($value as $key => $val) {
                    $value[$key] = ($val === null ? null : (string)$val);
                }
            }

            $translatable = [
                'original_attribute' => $this->attribute,
                'original_component' => $component,
                'locales' => $locales,
                'value' => $value ?: $defaultValue,
                'prioritize_nova_locale' => $prioritizeNovaLocale,
                'display_type' => $displayType,
            ];

            if ($this instanceof Markdown) {
                $translatable['previewFor'] = $translatable['value'] ? Arr::map($translatable['value'], fn($value) => $this->previewFor($value)) : [];
            }

            $this->withMeta(['translatable' => $translatable]);

            $this->component = 'translatable-field';

            // If it's a CREATE or UPDATE request, we need to trick the validator a bit
            $hasValidationTrick = property_exists($this, '__validationTrick') && $this->__validationTrick;
            if (in_array(request()->method(), ['PUT', 'POST']) && !$hasValidationTrick) {
                $translations = $request->input($this->attribute);
                if (!empty($fillOtherLocalesFrom) && !empty($translations[$fillOtherLocalesFrom])) {
                    foreach ($locales as $localeKey => $localeName) {
                        if (empty($translations[$localeKey])) $translations[$localeKey] = $translations[$fillOtherLocalesFrom];
                    }
                }
                $request->merge([$this->attribute => $translations]);

                $this->attribute = "{$this->attribute}.*";
                $this->__validationTrick = true;
            }

            if ($originalResolveCallback) return $this->resolve($resource, $attribute);
        });

        $originalDisplayCallback = $this->displayCallback;
        $this->displayUsing(function ($value, $resource, $attribute) use ($originalDisplayCallback) {
            $this->displayCallback = $originalDisplayCallback;

            /**
             * Avoid calling resolveForDisplay on the main Textarea instance as it contains a call to e()
             * and it only accepts string, passing an array will cause a crash
             */
            if ($this instanceof Textarea) {
                $this->displayCallback = null;
                parent::resolveForDisplay($resource, $attribute);

                if (is_string($value)) return $value;
                return collect(array_values((array)($value ?? [])))->filter()->first() ?? '';
            }

            $this->resolveForDisplay($resource, $attribute);
            return $value;
        });

        $this->fillUsing(function ($request, $model, $attribute, $requestAttribute) use ($locales) {
            $realAttribute = FieldServiceProvider::normalizeAttribute($this->meta['translatable']['original_attribute'] ?? $attribute);
            $value = $request->input($realAttribute);
            $translations = is_string($value) ? json_decode($value, true) : $value;

            $isTranslatableAttribute = method_exists($model, 'isTranslatableAttribute') && $model->isTranslatableAttribute($realAttribute);
            if ($isTranslatableAttribute && is_array($translations)) {
                $translationContents = [];
                $picIds = [];
                foreach($translations as $locale => $translation) {
                    $fillContent = json_decode($translation, true);
                    $translationContents[$locale] = $fillContent['content'];
                    if(array_key_exists('picIds', $fillContent)) {
                        $picIds = [
                            ...$picIds,
                            ...$fillContent['picIds']
                        ];
                    }
                }
                $model->setTranslations($realAttribute, $translationContents);

                if ($picIds) {
                    if (!array_key_exists('pics', $this->meta)) {
                        throw new \Exception('Please set the pics relationship name first');
                    }
                    $model->save();
                    $metaPics = $this->meta['pics'];
                    $model->{$metaPics}('set', $picIds);
                }
            } else {
                $model->{$realAttribute} = $translations;
            }
        });

        return $this;
    }
}
