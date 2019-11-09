<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Locations extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'name', 'name_en', 'longitude', 'latitude', 'active', 'org_id', 'description', 'user_id','destination_id','description_en',
    ];
    public $timestamps = true;
    /**
     * The attributes that should be hidden for arrays.
     *
     *
     */
     public function locataion_destination()
      {
          return $this->belongsTo('App\Destinations', 'destination_id', 'id');
      }





 
}
