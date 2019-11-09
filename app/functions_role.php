<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class functions_role extends Model
{   protected $table='functions_role';
  protected $fillable = [

      'role_id','functions_id', 'funcname', 'funcname_en', 'technical_name', 'funcparent_id', 'org_id', 'appear', 'porder','font','func_name', 'created_by'
  
  ];
   public $timestamps = true;
}
