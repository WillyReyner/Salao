<?php

namespace App\CustomLog\EditalLog\Contracts;

use Closure;
use App\CustomLog\EditalLog\EventLogBag;

interface LoggablePipe
{
    public function handle(EventLogBag $event, Closure $next): EventLogBag;
}
