<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentSetup extends Model
{
    protected $table = 'payment_setup';

    protected $fillable = [
        'id', 'gateway', 'acc_name','acc_password','acc_signature','notes','default','active','org_id','user_id	'
    ];

public $timestamps = true;

}
