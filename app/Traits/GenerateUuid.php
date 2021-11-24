<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait GenerateUuid {

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
