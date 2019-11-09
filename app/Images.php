<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    //
    protected $connection = 'mysql2';
    protected $public_images = "/images/";

    protected $fillable = ['file'];
    public $timestamps = true;
}
