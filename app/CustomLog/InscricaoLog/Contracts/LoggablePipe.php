<?php

namespace App\CustomLog\InscricaoLog\Contracts;

use Closure;
use App\CustomLog\InscricaoLog\EventLogBag;

interface LoggablePipe
{
    public function handle(EventLogBag $event, Closure $next): EventLogBag;
}
