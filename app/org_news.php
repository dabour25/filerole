<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class org_news extends Model
{
     protected $fillable = ['news_title', 'news_desc', 'news_date','news_desc_en', 'image_id','active','news_title_en'];
	 
	 public $timestamps = true;
	 
	 public function photo()
    {
        return $this->belongsTo('App\Photo', 'image_id', 'id');
    }
}
 