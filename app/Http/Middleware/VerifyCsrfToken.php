<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'https://paytabs.com/*',
        'https://www.paytabs.com/*',
        'http://paytabs.com/*',
        'http://www.paytabs.com/*',
        'www.paytabs.com/*',
        'paytabs.com/*',
        'https://airbook.aero/user/payment-history',
        'https://www.airbook.aero/user/payment-history',
        'http://jala.microdreamit.net/user/payment-history'
    ];
}
