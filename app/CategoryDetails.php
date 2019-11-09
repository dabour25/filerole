<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryDetails extends Model
{
    protected $fillable = [
        'cat_id', 'catsub_id', 'age_from', 'age_to', 'price','org_id', 'user_id',
    ];
    protected $table = 'categories_detail';

    public $timestamps = true;

}

