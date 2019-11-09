<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{
    protected $table = 'followup';
    public $timestamps = true;
    protected $fillable = [
        'id' ,'cust_id', 'cat_id', 'secr_text','admin_text','request_dt', 'status', 'health_status','deposit','deposit_inv_code','user_id', 'org_id'
    ];
}
