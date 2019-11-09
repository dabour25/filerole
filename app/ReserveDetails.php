<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReserveDetails extends Model
{
    //
    protected $table = 'reserve_details';
    protected $fillable = [
        'country_id',
         'reserve_id',
         'reservation_dt',
         'av_day',
         'av_time_from',
         'av_time_to',
         'org_id',
         'user_id',
    ];

    public $timestamps = true;

}
