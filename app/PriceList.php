<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
    protected $table = 'price_list';
    public $timestamps = true;
    protected $fillable = [
        'cat_id', 'date', 'price','tax_value', 'tax', 'final_price', 'active', 'org_id', 'user_id',
    ];

    public function categories()
    {
        return $this->hasMany('App\Category');
    }

}
