<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SewingReqLog extends Model
{
    protected $table = 'sewing_req_log';
    public $timestamps = true;
    protected $fillable = [
        'sewing_req_id', 'status', 'active', 'org_id', 'user_id'
    ];


}
