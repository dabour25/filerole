<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SewingRequest extends Model
{
    protected $table = 'sewing_request';
    public $timestamps = true;
    protected $fillable = [
        'date', 'cust_id','cat_id','deal_price', 'other_price', 'cloth_store','tax_val','cloth_type','color','emp_id','brova_dt','advance_payment','buy_cloth','cloth_id','cloth_qty','remarks','cust_req_id','sew_status','invoice_no','delivery_dt','delivery_user','received_by', 'org_id', 'user_id'
    ];


}
