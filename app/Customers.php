<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Customers extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
          'name', 'name_en', 'phone_number', 'email', 'password', 'address', 'marriage_date', 'birth_date', 'org_id', 'active', 'user_id', 'cust_code', 'photo_id', 'gender','country_id','city','hear_about_us','Notifications_email','Notifications_phone', 'share_code','person_id','person_idtype','person_image'
    ];
    public $timestamps = true;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function customers()
    {
        return $this->hasMany('App\User');
    }

    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }
    // a.nabiil
      public function requests()
    {
      return $this->hasMany('App\externalReq','cust_id');
    }
    
 // a.nabiil
}
