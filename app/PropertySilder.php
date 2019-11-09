<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class PropertySilder extends Model
{
    protected $table ="poroperty_slider";

    public function photo()
    {
        return $this->belongsTo('App\Photo','image','id');
    }
}