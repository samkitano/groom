<?php

namespace App\kitano\Traits;

use Illuminate\Support\Str;
use App\Kitano\Events\TranslationWasSet;
use App\Kitano\Exceptions\AttributeNotTranslatable;

trait Translatable
{
    /**
     * @param string $key
     * @return mixed
     * @throws AttributeNotTranslatable
     */
    public function getAttributeValue($key)
    {
        if (!$this->isTranslatableAttribute($key)) {
            return parent::getAttributeValue($key);
        }

        return $this->getTranslation($key, $this->getLocale());
    }

    /**
     * Set a given attribute on the model.
     *
     * @param string $key
     * @param mixed  $value
     * @return $this
     * @throws AttributeNotTranslatable
     */
    public function setAttribute($key, $value)
    {
        // pass arrays and untranslatable attributes to the parent method
        if (!$this->isTranslatableAttribute($key) || is_array($value)) {
            return parent::setAttribute($key, $value);
        }

        // if the attribute is translatable and not already translated (=array),
        // set a translation for the current app locale
        return $this->setTranslation($key, $this->getLocale(), $value);
    }

    /**
     * @param string $key
     * @param string $locale
     * @return mixed
     * @throws AttributeNotTranslatable
     */
    public function translate(string $key, string $locale = '')
    {
        return $this->getTranslation($key, $locale);
    }

    /***
     * @param string $key
     * @param string $locale
     * @param bool   $useFallbackLocale
     * @return mixed
     * @throws AttributeNotTranslatable
     */
    public function getTranslation(string $key, string $locale, bool $useFallbackLocale = true)
    {
        $locale = $this->normalizeLocale($key, $locale, $useFallbackLocale);

        $translations = $this->getTranslations($key);
        $translation = $translations[$locale] ?? '';

        if ($this->hasGetMutator($key)) {
            return $this->mutateAttribute($key, $translation);
        }

        return $translation;
    }

    /**
     * @param string $key
     * @param string $locale
     * @return mixed
     * @throws AttributeNotTranslatable
     */
    public function getTranslationWithFallback(string $key, string $locale)
    {
        return $this->getTranslation($key, $locale, true);
    }

    /**
     * @param string $key
     * @param string $locale
     * @return mixed
     * @throws AttributeNotTranslatable
     */
    public function getTranslationWithoutFallback(string $key, string $locale)
    {
        return $this->getTranslation($key, $locale, false);
    }

    /**
     * @param null $key
     * @return array
     * @throws AttributeNotTranslatable
     */
    public function getTranslations($key = null): array
    {
        if ($key !== null) {
            $this->guardAgainstUntranslatableAttribute($key);

            return json_decode(
                $this->getAttributes()[$key] ?? '' ?: '{}', true
            ) ?: [];
        }

        return array_reduce($this->getTranslatableAttributes(), function ($result, $item) {
            $result[$item] = $this->getTranslations($item);
            return $result;
        });
    }

    /**
     * @param string $key
     * @param string $locale
     * @param mixed  $value
     * @return self
     * @throws AttributeNotTranslatable
     */
    public function setTranslation(string $key, string $locale, $value): self
    {
        $this->guardAgainstUntranslatableAttribute($key);

        $translations = $this->getTranslations($key);
        $oldValue = $translations[$locale] ?? '';

        if ($this->hasSetMutator($key)) {
            $method = 'set'.Str::studly($key).'Attribute';
            $this->{$method}($value, $locale);
            $value = $this->attributes[$key];
        }

        $translations[$locale] = $value;

        $this->attributes[$key] = $this->asJson($translations);

        event(new TranslationWasSet($this, $key, $locale, $oldValue, $value));

        return $this;
    }

    /**
     * @param string $key
     * @param array  $translations
     * @return $this
     * @throws AttributeNotTranslatable
     */
    public function setTranslations(string $key, array $translations)
    {
        $this->guardAgainstUntranslatableAttribute($key);

        foreach ($translations as $locale => $translation) {
            $this->setTranslation($key, $locale, $translation);
        }

        return $this;
    }

    /**
     * @param string $key
     * @param string $locale
     * @return $this
     * @throws AttributeNotTranslatable
     */
    public function forgetTranslation(string $key, string $locale)
    {
        $translations = $this->getTranslations($key);

        unset($translations[$locale]);

        $this->setAttribute($key, $translations);

        return $this;
    }

    /**
     * @param string $locale
     */
    public function forgetAllTranslations(string $locale)
    {
        collect($this->getTranslatableAttributes())->each(function (string $attribute) use ($locale) {
            $this->forgetTranslation($attribute, $locale);
        });
    }

    /**
     * @param string $key
     * @return array
     * @throws AttributeNotTranslatable
     */
    public function getTranslatedLocales(string $key): array
    {
        return array_keys($this->getTranslations($key));
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isTranslatableAttribute(string $key): bool
    {
        return in_array($key, $this->getTranslatableAttributes());
    }

    /**
     * @param string $key
     * @throws AttributeNotTranslatable
     */
    protected function guardAgainstUntranslatableAttribute(string $key)
    {
        if (! $this->isTranslatableAttribute($key)) {
            throw AttributeNotTranslatable::make($key, $this);
        }
    }

    /**
     * @param string $key
     * @param string $locale
     * @param bool   $useFallbackLocale
     * @return string
     * @throws AttributeNotTranslatable
     */
    protected function normalizeLocale(string $key, string $locale, bool $useFallbackLocale): string
    {
        if (in_array($locale, $this->getTranslatedLocales($key))) {
            return $locale;
        }

        if (! $useFallbackLocale) {
            return $locale;
        }

        if (! is_null($fallbackLocale = config('app.fallback_locale'))) {
            return $fallbackLocale;
        }

        return $locale;
    }

    /**
     * @return string
     */
    protected function getLocale(): string
    {
        return config('app.locale');
    }

    /**
     * @return array
     */
    public function getTranslatableAttributes(): array
    {
        return is_array($this->translatable)
            ? $this->translatable
            : [];
    }

    /**
     * @return array
     */
    public function getCasts(): array
    {
        return array_merge(
            parent::getCasts(),
            array_fill_keys($this->getTranslatableAttributes(), 'array')
        );
    }
}
