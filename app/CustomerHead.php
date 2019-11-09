<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerHead extends Model
{
    protected $table = 'customer_req_head';

    protected $fillable = [
        'date', 'invoice_no', 'invoice_code', 'invoice_template', 'cust_id', 'date', 'org_id','user_id', 'invoice_user', 'invoice_date', 'share_code', 'invoice_status', 'due_date'
    ];
    public $timestamps = true;

    public function transactions(){
        return $this->hasMany(Transactions::CLASS,'cust_req_id','id');
    }

    public function customer(){
        return $this->belongsTo(Customers::CLASS,'cust_id','id');
    }
    
    public function get_table_name(){
      return $this->table;
    }

}
