<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferDays extends Model
{
    protected $table = 'offer_days';
    public $timestamps = true;
    protected $fillable = [
        'cat_id', 'offer_id', 'day', 'time_from', 'time_to', 'offer_dt_from','offer_dt_to', 'org_id', 'user_id'
    ];
}
