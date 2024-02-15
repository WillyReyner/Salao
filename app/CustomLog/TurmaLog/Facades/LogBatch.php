<?php

namespace App\CustomLog\TurmaLog\Facades;

use Illuminate\Support\Facades\Facade;
use App\CustomLog\TurmaLog\LogBatch as ActivityLogBatch;

/**
 * @method static string getUuid()
 * @method static mixed withinBatch(\Closure $callback)
 * @method static void startBatch()
 * @method static void setBatch(string $uuid): void
 * @method static bool isOpen()
 * @method static void endBatch()
 *
 * @see \App\CustomLog\TurmaLog\LogBatch
 */
class LogBatch extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ActivityLogBatch::class;
    }
}
