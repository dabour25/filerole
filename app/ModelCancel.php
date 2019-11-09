<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelCancel extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cancel', 'cat_id','period', 'org_id', 'active', 'user_id', 'setup_dt'
    ];
    public $timestamps = true;
    protected $table = 'setup_model_cancel';

}
