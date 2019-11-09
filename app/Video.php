<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $public_videos = "/videos/";

    protected $fillable = ['file'];
    public $timestamps = true;

    public function getFileAttribute($video)
    {
        return $this->public_videos . trim($video);
    }
}
