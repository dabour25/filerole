<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'category_type_id',
        'name', 
        'name_en',
        'photo_id', 
        'description', 
        'expected_price',
        'cat_unit',
        'd_limit',
        'cloth_id',
        'color',
        'grouped',
        'barcode',
        'req_days',
        'active',
        'store_id',
        'brand',
        'required_time',
        'volume',
        'org_id',
        'user_id',
        'property_id',
    ];

    public $timestamps = true;

    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    public function type()
    {
        return $this->belongsTo(CategoriesType::CLASS,'category_type_id','id');
    }

}

