<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierCompanies extends Model
{
    protected $table = 'supplier_comp';
    public $timestamps = true;
    protected $fillable = [
        'supplier_id' ,'comp_id', 'register_no', 'file', 'active','user_id', 'org_id'
    ];

}
