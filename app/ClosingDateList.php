<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClosingDateList extends Model
{

    protected $table='closing_dates_list';

	 protected $fillable = [
        'cat_id',
        'category_num_id',
        'date_from',
        'date_to',
        'org_id',
        'user_id'


    ];
	public $timestamps = true;


}
