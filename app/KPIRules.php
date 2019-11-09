<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KPIRules extends Model
{
    protected $table = 'kpi_rules';
    public $timestamps = true;
    protected $fillable = [
        'role_id','year', 'p_from', 'p_to', 'p_sal', 'active', 'org_id', 'user_id',
    ];
}
