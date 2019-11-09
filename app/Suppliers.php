<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'name_en', 'phone_number', 'email', 'account_no', 'address', 'payment_terms', 'file','condition_of_supply', 'org_id', 'active', 'user_id'
    ];
    public $timestamps = true;

    public function items()
    {
        return $this->hasMany('App\SuppliersItems', 'supplier_id', 'id');
    }

    public function invoices()
    {
        return $this->hasMany('App\PermissionReceiving', 'supplier_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transactions', 'supplier_id', 'id');
    }
}
