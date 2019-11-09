<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
   protected $connection = 'mysql2';
    protected $table ='sys_organization';
    protected $fillable = [
        'id',
        'org_id',
        'admin_user_id',
        'activity_id',
        'plan_id',
        'plan_price',
        'name',
        'name_en',
        'country_id',
        'logo',
        'govornarate',
        'city',
        'address',
        'email',
        'subdomain_name',
        'telephone',
        'postal_code',
        'org_currency',
        'disp_language',
        'busines_resgister',
        'tax_card',
        'admin_user_mobile',
        'server_name',
        'server_ip',
        'sys_user_id',


    ];


    public $timestamps = true;


}
