<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = [
        'date', 'description', 'permission_receiving_id', 'emp_id', 'tax_id','sew_deal_price','cust_req_id', 'supplier_id','cust_id', 'damage_id', 'cat_id','quantity','price','tax_val','deal_price','store_id','locator_id','status','trans_type','notes','pay_method','bank_treasur_id','check_no','req_flag','invoice_no','invoice_date','invoice_user','sewing_req_id','org_id','user_id','userupd_id'
    ];
    public $timestamps = true;

    public function head(){
        return $this->belongsTo(CustomerHead::CLASS,'cust_req_id','id');
    }
}
