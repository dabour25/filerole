<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionReceivingPayments extends Model
{
    protected $table = 'permission_receiving_payments';
    public $timestamps = true;
    protected $fillable = [
        'supplier_id', 'permission_receiving_id', 'pay_amount', 'pay_date', 'pay_flag', 'description', 'remarks', 'supp_invoice_no', 'pay_method', 'customer_req_id', 'customer_id', 'customer_invoice_no', 'bank_treasur_id','org_id','user_id',
    ];

}
