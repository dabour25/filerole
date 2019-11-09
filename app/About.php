<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
   protected $connection = 'mysql2';
    protected $table='sys_about';

	 protected $fillable = [
        'title',
        'title_en',
        'introduction',
        'introduction_en',
        'about_us',
        'about_us_en',
        'support_email',
        'crm_email',
        'facebook',
        'twitter',
        'whatsapp',
        'bank_name',
        'bank_no',
        'bsnk_branch',
        'bank_swift_code',
        'bank_logo',
        'about_image',
        'sys_user_id'


    ];
	public $timestamps = true;


}
