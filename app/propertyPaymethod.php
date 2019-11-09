<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class propertyPaymethod extends Model
{
    protected $table ='property_payment_setup';
    protected $fillable = [
        'property_id', 'gateway', 'acc_name', 'acc_password', 'acc_signature', 'notes', 'default','active','org_id','user_id'
    ];
    public $timestamps = true;





}
