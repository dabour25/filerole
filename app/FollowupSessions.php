<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowupSessions extends Model
{
    protected $table = 'followup_sessions';
    protected $fillable = [ 
        'id' ,'followup_id', 'serial', 'session_dt', 'session_pay','session_inv_code','session_status','remarks','user_id', 'org_id'
    ];
    public $timestamps = true;
}
