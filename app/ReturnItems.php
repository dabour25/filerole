<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnItems extends Model
{
    protected $table = 'setup_return_items';
    public $timestamps = true;
    protected $fillable = [
        'role_id', 'return_item_flag', 'org_id', 'user_id'
    ];
}
