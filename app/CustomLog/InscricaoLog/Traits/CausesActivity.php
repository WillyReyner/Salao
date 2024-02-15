<?php

namespace App\CustomLog\InscricaoLog\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\CustomLog\InscricaoLog\ActivitylogServiceProvider;

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
