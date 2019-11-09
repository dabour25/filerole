<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLabelSetup extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'activity_labels_setup';
    protected $fillable = [
        'type' , 'value','value_en','font','size','color','description','activity_id','sys_user_id','user_id', 'org_id',
    ];

    public $timestamps = true;
}
