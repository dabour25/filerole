<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrontMessagesReplay extends Model
{
    protected $table = 'front_messages_replay';
    public $timestamps = true;
    protected $fillable = [
        'parent_id',
        'message',
        'org_id',
        'user_id',
    ];
}
