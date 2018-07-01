<?php

namespace App\Kitano\Traits;


trait Monitorable
{
    public function bootDetectsChanges()
    {
        if (static::eventsToBeRecorded()->contains('updated')) {
            static::updating(function (Model $model) {
                //temporary hold the original attributes on the model
                //as we'll need these in the updating event
                $oldValues = $model->replicate()->setRawAttributes($model->getOriginal());
                $model->oldAttributes = static::logChanges($oldValues);
            });
        }
    }

    public static function logChanges(Model $model): array
    {
        $changes = [];

        foreach ($model->attributesToBeLogged() as $attribute) {
            if (str_contains($attribute, '.')) {
                $changes += self::getRelatedModelAttributeValue($model, $attribute);
            } else {
                $changes += collect($model)->only($attribute)->toArray();
            }
        }

        return $changes;
    }

    protected static function getRelatedModelAttributeValue(Model $model, string $attribute): array
    {
        if (substr_count($attribute, '.') > 1) {
            throw CouldNotLogChanges::invalidAttribute($attribute);
        }

        list($relatedModelName, $relatedAttribute) = explode('.', $attribute);

        $relatedModel = $model->$relatedModelName ?? $model->$relatedModelName();

        return ["{$relatedModelName}.{$relatedAttribute}" => $relatedModel->$relatedAttribute ?? null];
    }
}
