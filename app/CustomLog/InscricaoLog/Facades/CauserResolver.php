<?php

namespace App\CustomLog\InscricaoLog\Facades;

use Illuminate\Support\Facades\Facade;
use App\CustomLog\InscricaoLog\CauserResolver as ActivitylogCauserResolver;

/**
 * @method static \Illuminate\Database\Eloquent\Model|null resolve(\Illuminate\Database\Eloquent\Model|int|string|null $subject = null)
 * @method static \App\CustomLog\InscricaoLog\CauserResolver resolveUsing(\Closure $callback)
 * @method static \App\CustomLog\InscricaoLog\CauserResolver setCauser(\Illuminate\Database\Eloquent\Model|null $causer)
 *
 * @see \App\CustomLog\InscricaoLog\CauserResolver
 */
class CauserResolver extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ActivitylogCauserResolver::class;
    }
}
