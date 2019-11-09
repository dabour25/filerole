<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    //
	 protected $connection = 'mysql2';
	 protected $fillable = [
        'activity_image', 'dashboard_type','name_en', 'name','description','active',
    ];
	public $timestamps = true;
	 public function photo()
    {
        return $this->belongsTo('App\Models\Photo', 'activity_image', 'id');
    }
	public function type()
    {
        return $this->hasMany('App\Models\ActivitiesType');
    }

}
