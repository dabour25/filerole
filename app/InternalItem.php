<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class InternalItem extends Model
{

    protected $table = 'internal_item_setup';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = true;
    protected $fillable = [
        'appear', 'user_id', 'org_id',
    ];





}
