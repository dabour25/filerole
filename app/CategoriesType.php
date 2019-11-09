<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriesType extends Model
{
    protected $table = "categories_type";
    public $timestamps = true;
    protected $fillable = [
         'id' , 'type','name', 'name_en', 'description', 'active','user_id', 'org_id','max_adult','max_kids','unit_type','kind','area',
        'no_rooms','no_bathrooms','no_kitchen','max_people','description_en'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function categories()
    {
    	return $this->hasMany('App\Category','category_type_id' ,'id');
    }
}
