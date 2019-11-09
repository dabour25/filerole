<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribers extends Model
{

    protected $table='front_subscribers';

	 protected $fillable = [
        'sub_email',
        'url',
        


    ];
	public $timestamps = true;


}
