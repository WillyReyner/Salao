<?php

namespace App\CustomLog\TurmaLog\Contracts;

use Closure;
use App\CustomLog\TurmaLog\EventLogBag;

interface LoggablePipe
{
    public function handle(EventLogBag $event, Closure $next): EventLogBag;
}
