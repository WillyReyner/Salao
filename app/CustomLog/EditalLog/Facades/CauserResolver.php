<?php

namespace App\CustomLog\EditalLog\Facades;

use Illuminate\Support\Facades\Facade;
use App\CustomLog\EditalLog\CauserResolver as ActivitylogCauserResolver;

/**
 * @method static \Illuminate\Database\Eloquent\Model|null resolve(\Illuminate\Database\Eloquent\Model|int|string|null $subject = null)
 * @method static \App\CustomLog\EditalLog\CauserResolver resolveUsing(\Closure $callback)
 * @method static \App\CustomLog\EditalLog\CauserResolver setCauser(\Illuminate\Database\Eloquent\Model|null $causer)
 *
 * @see \App\CustomLog\EditalLog\CauserResolver
 */
class CauserResolver extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ActivitylogCauserResolver::class;
    }
}
