<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class org_function extends Model
{
  
  protected $fillable = [
      'funcname', 'funcname_en', 'technical_name', 'funcparent_id', 'porder', 'function_id', 'org_id',
  ];
   public $timestamps = true;
   
   function childs()
            {
            return $this->hasMany('App\org_function','funcparent_id', 'function_id');
           
            }
   
}
