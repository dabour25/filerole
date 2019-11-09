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
        'admin/transactions/item-details',
        'admin/transactions/transactions-item-price',
        'admin/suppliers/price/',
        'weblogin',
        'admin/inbox/users/messages/search',
        'admin/inbox/messages/fetch',
        'admin/inbox/customers/messages/search',
        'admin/settings/invoice_template',
        'admin/session_log_out',
        'ajax/logout',
        'ajax/login',
        'check-invoices-status',
        'admin/ajax/availability_update_price/{cat_id}/{date}/{old}/{value}',
    ];
}
