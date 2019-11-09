<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPayments extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'client_payments';
    protected $fillable = [
        'id',
        'org_id',
        'payment_date',
        'payment_tot',
        'plan_type',
        'pay_gateway',
        'card_owner_name',
        'card_no',
        'check_code',
        'card_exp_date',
        'activity_id',
        'plan_id',
        'renewable'
    ];


    public $timestamps = true;


}
