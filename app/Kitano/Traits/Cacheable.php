<?php

namespace App\Kitano\Traits;

trait Cacheable
{
    public function remember($key, $callback)
    {
        return cache()->rememberForever($key, function () use ($callback) {
            return $callback;
        });
    }

    public function forget($key)
    {
        cache()->forget($key);
    }
}
