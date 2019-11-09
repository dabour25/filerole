<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'name_en', 'phone_number', 'email', 'password', 'address', 'birthday', 'type','section_id', 'role_id', 'is_active', 'photo_id', 'user_id', 'code', 'org_id', 'used_type', 'welcome',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function section()
    {
        return $this->belongsTo('App\Sections');
    }

    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }
    public function functions(){
        return $this->hasMany('App\FunctionsUser', 'user_id', 'id');
    }
}
