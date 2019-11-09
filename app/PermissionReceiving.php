<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionReceiving extends Model
{
    protected $table = 'permission_receiving';
    public $timestamps = true;
    protected $fillable = [
        'supplier_id', 'file_id', 'total', 'deduction', 'other_payment', 'supp_invoice_no','supp_invoice_dt','org_id','user_id',
    ];


    public function transactions(){
        return $this->hasMany(Transactions::CLASS,'permission_receiving_id','id');
    }


}
