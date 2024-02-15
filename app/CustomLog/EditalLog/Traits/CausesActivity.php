<?php

namespace App\CustomLog\EditalLog\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\CustomLog\EditalLog\ActivitylogServiceProvider;

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
