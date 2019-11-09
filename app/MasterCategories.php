<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterCategories extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'active_categories';
    protected $fillable = [
        'id',
        'category_type_id',
        'name',
        'name_en',
        'description',
        'description_en',
        'cat_unit',
        'cat_image',
        'active',
        'sys_user_id'
    ];


    public $timestamps = true;


}
