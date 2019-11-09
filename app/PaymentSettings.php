<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class PaymentSettings extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'payment_settings';
    protected $fillable = [
        'key', 'value'
    ];
}
