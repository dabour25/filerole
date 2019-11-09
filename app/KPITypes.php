<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KPITypes extends Model
{
    protected $table = 'kpi_types';
    public $timestamps = true;
    protected $fillable = [
        'role_id', 'code', 'name', 'name_en', 'weight', 'active', 'org_id', 'user_id',
    ];
}
