<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class emp_loan_instalments extends Model
{
    protected $fillable = [
       'loan_id', 'inst_dt','inst_val', 'inst_status', 'sal_flag_closed', 'org_id', 'user_id',
    ];
    public $timestamps = true;
    protected $table = 'emp_loan_instalments';
     public function head(){
        return $this->belongsTo(emp_loan_head::CLASS,'loan_id','id');
    }


    


}
