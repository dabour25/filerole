<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\externalTrans as external_trans;

class externalReq extends Model
{
  protected $table = 'external_req';

  public function Customer()
  {
    return $this->belongsTo('App\Customers','cust_id');
  }
  public function trans()
  {
    return $this->hasMany('App\externalTrans','external_req_id');
  }
  
  public function get_table_name(){
    return $this->table;
  }
  
}
