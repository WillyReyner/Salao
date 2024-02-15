<?php

namespace App\CustomLog\CursoLog\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\CustomLog\CursoLog\ActivitylogServiceProvider;

trait CausesActivity
{
    public function actions(): MorphMany
    {
        return $this->morphMany(
            ActivitylogServiceProvider::determineActivityModel(),
            'causer'
        );
    }
}
