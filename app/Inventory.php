<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{

    protected $table = 'inventory';
    public $timestamps = true;
    protected $fillable = [
        'id' , 'inv_date', 'cat_id','actual_qty', 'store_id', 'notes','user_id', 'org_id',
    ];

}
