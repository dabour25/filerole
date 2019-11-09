<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class org extends Model
{
    protected $table = 'organizations';
    protected $primarykey = 'id';
    protected $fillable = [
        'name', 'name_en', 'phone', 'address', 'description', 'description_en', 'extra_emp', 'due_date', 'mobile1', 'mobile2', 'email_crm', 'twitter', 'facebook', 'instgram', 'email', 'image_id', 'front_image', 'location_map', 'about_us', 'aboutus_en','attendance_start_day','currency','work_time'
    ];
    public $timestamps = true;

    public function photo()
    {
        return $this->belongsTo('App\Photo', 'image_id', 'id');
    }

    public function map()
    {
        return $this->belongsTo('App\Photo', 'location_map', 'id');
    }

    public function front()
    {
        return $this->belongsTo('App\Photo', 'front_image', 'id');
    }

}
