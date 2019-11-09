<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfferDetails extends Model
{
    protected $table = 'offer_details';
    public $timestamps = true;
    protected $fillable = [
        'cat_id', 'offer_id', 'org_id', 'user_id'
    ];
}
