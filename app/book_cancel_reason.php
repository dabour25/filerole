<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class  book_cancel_reason extends Model
{
    protected $table ='book_cancel_reason';

    protected $fillable = [
      'property_id','name', 'name_en', 'rank' ,'user_id','org_id','description',
    ];

    public $timestamps = true;


}
