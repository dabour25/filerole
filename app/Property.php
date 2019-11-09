<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table ='property';

    public function myphoto()
    {
        return $this->belongsTo('App\Photo','image','id');
    }


}