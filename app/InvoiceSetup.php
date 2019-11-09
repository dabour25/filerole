<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceSetup extends Model
{
    protected $table = 'invoice_setup';
    protected $fillable = [
        'type', 'value', 'description', 'org_id', 'user_id'
    ];
    public $timestamps = true;
}
