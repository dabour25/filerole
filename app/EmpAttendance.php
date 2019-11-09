<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class EmpAttendance extends Model
{

    protected $table = 'emp_attendance';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = true;

    protected $fillable = [
        'emp_id', 'date', 'month', 'year', 'time_from', 'yvac_id', 'time_to', 'day_value', 'attend_type', 'active', 'sal_flag_colsed','user_id', 'org_id',
    ];





}
