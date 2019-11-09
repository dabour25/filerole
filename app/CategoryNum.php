<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryNum extends Model
{
    protected $table='category_num'; 

  protected $fillable = [
      'cat_id',
      'cat_num',
      'floor_num',
      'operation_status',
      'check_status',
      'meal_plan',
      'org_id',
      'user_id'
  ];

  public function Cate_id()
  {
      return $this->belongsTo('App\Category', 'cat_id', 'id');
  }

  public function cloth()
  {
      return $this->hasMany('App\ClosingDateList', 'category_num_id', 'id');
  }

  public function facility()
  {
      return $this->hasMany('App\FacilityList', 'category_num_id', 'id');


  }

  public $timestamps = true;
}
