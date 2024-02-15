<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array
     */
    protected $proxies = '*'; // Trust all proxies

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;

    /**
     * The current proxy header mappings.
     *
     * @var array
     */
    protected $headersToTrust = [
        Request::HEADER_FORWARDED => 'FORWARDED',
        Request::HEADER_X_FORWARDED_FOR => 'X-FORWARDED-FOR',
        Request::HEADER_X_FORWARDED_HOST => 'X-FORWARDED-HOST',
        Request::HEADER_X_FORWARDED_PROTO => 'X-FORWARDED-PROTO',
    ];
}