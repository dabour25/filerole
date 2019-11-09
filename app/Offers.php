<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable = [
        'cat_id', 'name', 'name_en','description_en', 'description','grouped','date_from', 'date_to', 'orig_price', 'grouped','discount_type', 'infrontpage', 'discount_value', 'discount_price', 'offer_price', 'nights', 'tax', 'active', 'org_id', 'user_id',
    ];


}
