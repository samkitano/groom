<?php

namespace App\kitano\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Model;

class AttributeNotTranslatable extends Exception
{
    public static function make(string $key, Model $model)
    {
        $translatable = implode(', ', $model->getTranslatableAttributes());

        return new static("Cannot translate attribute `{$key}` as it's not one of the translatable attributes: `$translatable`");
    }
}
