<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SuppliersItems extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supplier_id', 'cat_id', 'org_id', 'active', 'user_id'
    ];
    public $timestamps = true;
    public function supplier()
    {
        return $this->belongsTo('App\Suppliers');
    }

}
