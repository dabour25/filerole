<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $public_images = "/images/";

    protected $fillable = ['file'];
    public $timestamps = true;

    public function getFileAttribute($photo)
    {
        return $this->public_images . trim($photo);
    }
}