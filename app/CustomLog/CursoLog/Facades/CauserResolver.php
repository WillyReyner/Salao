<?php

namespace App\CustomLog\CursoLog\Facades;

use Illuminate\Support\Facades\Facade;
use App\CustomLog\CursoLog\CauserResolver as ActivitylogCauserResolver;

/**
 * @method static \Illuminate\Database\Eloquent\Model|null resolve(\Illuminate\Database\Eloquent\Model|int|string|null $subject = null)
 * @method static \App\CustomLog\CursoLog\CauserResolver resolveUsing(\Closure $callback)
 * @method static \App\CustomLog\CursoLog\CauserResolver setCauser(\Illuminate\Database\Eloquent\Model|null $causer)
 *
 * @see \App\CustomLog\CursoLog\CauserResolver
 */
class CauserResolver extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ActivitylogCauserResolver::class;
    }
}
