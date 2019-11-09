<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'sys_pages';

    protected $fillable = [
        'name', 'name_en','title', 'title_en', 'content', 'content_en', 'slug', 'status', 'image_id'
    ];

    public $timestamps = true;

}
