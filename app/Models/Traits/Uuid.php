<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait Uuid
{
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->setAttribute($model->getKeyName(), Str::uuid());
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
