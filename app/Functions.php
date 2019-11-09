<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Functions extends Model
{

    protected $table='function_new';
    protected $fillable = [
        'id' , 'name', 'name_en','description', 'type', 'technical_name', 'parent_id', 'org_id', 'user_id','func_name',
    ];
    public $timestamps = true;

    public function role()
    {
        return $this->hasMany('App\Role');
    }
}
