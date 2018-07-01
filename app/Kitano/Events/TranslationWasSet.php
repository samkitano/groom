<?php

namespace App\kitano\Events;

use Illuminate\Database\Eloquent\Model;

class TranslationWasSet
{
    /** @var \App\Kitano\Traits\Translatable */
    public $model;

    /** @var string */
    public $key;

    /** @var string */
    public $locale;

    public $oldValue;

    public $newValue;

    public function __construct(Model $model, string $key, string $locale, $oldValue, $newValue)
    {
        $this->model = $model;
        $this->key = $key;
        $this->locale = $locale;
        $this->oldValue = $oldValue;
        $this->newValue = $newValue;
    }
}