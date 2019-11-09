<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class emp_loan_head extends Model
{
    protected $fillable = [
       'description', 'loan_amount','loan_dt', 'inst_no', 'emp_id', 'active', 'org_id', 'user_id',
    ];
    public $timestamps = true;
	protected $table = 'emp_loan_head';
    public function emp_loan_instalments(){
        return $this->hasMany(emp_loan_instalments::CLASS,'loan_id','id');
    }


    


}
