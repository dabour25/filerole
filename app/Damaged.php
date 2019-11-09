<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Damaged extends Model
{
    protected $table = 'damaged_req';
    public $timestamps = true;
    protected $fillable = [
        'damage_date', 'supervisor_id', 'remarks', 'org_id', 'user_id',
    ];


    public function transactions()
    {
        return $this->hasMany(Transactions::CLASS, 'damage_id', 'id');
    }


}
