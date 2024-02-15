<?php

namespace App\CustomLog\TurmaLog\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\CustomLog\TurmaLog\ActivitylogServiceProvider;

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
