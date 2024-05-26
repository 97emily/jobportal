<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait AttachmentConcern
{
    public static function bootHasUuid()
    {
        static::creating(function (Model $model) {
            /** @var \Spatie\MediaLibrary\MediaCollections\Models\Media $model */
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    public static function findByUuid(string $uuid): ?Model
    {
        return static::where('uuid', $uuid)->first();
    }
}
