<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KPIEmp extends Model
{
    protected $table = 'kpi_emp';
    public $timestamps = true;
    protected $fillable = [
        'emp_id','role_id', 'kpi_month', 'kpi_year', 'kpi_id', 'kpi_weight', 'kpi_val', 'kpi_by', 'sal_flag_active', 'org_id', 'user_id',
    ];
}
