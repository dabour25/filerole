<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{


    protected $fillable = [
        'id' , 'name', 'name_en', 'description', 'user_id', 'org_id',
    ];
    public $timestamps = true;
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function functions(){
        return $this->hasMany('App\UsersType');
    }
      

}