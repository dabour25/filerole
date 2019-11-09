<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersMessages extends Model
{
    protected $table = 'users_messages';
    protected $fillable = [
        'from_id', 'to_id','message', 'org_id'
    ];

    public $timestamps = true;
}
