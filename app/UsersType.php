<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersType extends Model
{

    protected $table = "roles_functions";
    public $timestamps = true;
    protected $fillable = [
        'id' , 'role_id', 'function_id', 'user_id', 'org_id','active',
    ];

    public function role()
    {
        return $this->hasMany('App\Role');
    }
}
