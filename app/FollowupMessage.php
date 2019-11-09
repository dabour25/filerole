<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowupMessage extends Model
{
    protected $table = 'followup_msg';
    public $timestamps = true;
    protected $fillable = [
        'id' ,'followup_id', 'msg_dt', 'msg_media','msg_status','msg_content','user_id', 'org_id'
    ];
}
