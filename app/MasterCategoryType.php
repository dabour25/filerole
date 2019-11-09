<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterCategoryType extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'active_categories_type';
    protected $fillable = [
        'id', 'type','activity_id', 'name', 'name_en', 'description', 'active','sys_user_id'
    ];


    public $timestamps = true;

public function category(){
  return $this->hasMany('App\Models\Categories');
}
}
