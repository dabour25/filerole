<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Destinations extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'name_en', 'longitude', 'latitude', 'price_start', 'currency_id', 'infrontpage', 'active', 'org_id', 'description', 'user_id', 'image','description_en','video_id',
    ];
    public $timestamps = true;
    /**
     * The attributes that should be hidden for arrays.
     *
     *
     */
     public function photo()
      {
          return $this->belongsTo('App\Photo', 'image', 'id');
      }
      public function video()
       {
           return $this->belongsTo('App\Video', 'video_id', 'id');
       }




 // a.nabiil
}
