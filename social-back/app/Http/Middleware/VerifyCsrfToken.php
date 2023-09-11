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
        'fb-page-webhook', 'instagram-webhook', 'whatsapp-webhook', 'agent-assign-in-queues','get-sms','test'
    ];
}
