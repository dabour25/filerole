<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowupPhotos extends Model
{
    protected $table = 'followup_photos';
    public $timestamps = true;
    protected $fillable = [ 
        'id' ,'followup_id', 'fimage', 'image_type','user_id', 'org_id'
    ];
}
