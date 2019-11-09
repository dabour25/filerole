<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceTemplate extends Model
{
    protected $table = 'invoice_template';
    protected $fillable = [
        'name', 'value', 'preview', 'org_id', 'user_id'
    ];
    public $timestamps = true;
}
