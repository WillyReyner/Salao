<?php

namespace App\CustomLog\CursoLog\Contracts;

use Closure;
use App\CustomLog\CursoLog\EventLogBag;

interface LoggablePipe
{
    public function handle(EventLogBag $event, Closure $next): EventLogBag;
}
