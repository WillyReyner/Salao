<?php

namespace App\CustomLog\TurmaLog\Facades;

use Illuminate\Support\Facades\Facade;
use App\CustomLog\TurmaLog\CauserResolver as ActivitylogCauserResolver;

/**
 * @method static \Illuminate\Database\Eloquent\Model|null resolve(\Illuminate\Database\Eloquent\Model|int|string|null $subject = null)
 * @method static \App\CustomLog\TurmaLog\CauserResolver resolveUsing(\Closure $callback)
 * @method static \App\CustomLog\TurmaLog\CauserResolver setCauser(\Illuminate\Database\Eloquent\Model|null $causer)
 *
 * @see \App\CustomLog\TurmaLog\CauserResolver
 */
class CauserResolver extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ActivitylogCauserResolver::class;
    }
}
