<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemLogs extends Model
{
    protected $table='system_logs';

	 protected $fillable = [
        'screen_name',
        'action',
        'description',
        'table_name',
        'record_id',
        'org_id',
        'user_id'

    ];
	public $timestamps = true;


}
