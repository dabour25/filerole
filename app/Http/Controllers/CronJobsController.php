<?php

namespace App\Http\Controllers;

use App\CustomerHead;
use Illuminate\Http\Request;

class CronJobsController extends Controller
{

    public function Check_Invoices_status(Request $request){
        foreach ($list = CustomerHead::where(['org_id' => \Auth::user()->org_id])->with('transactions')->whereNotNull('cust_id')->get() as $v){
            CustomerHead::where('id', $v->id)->update([ 'invoice_status' => Invoice_status($v->id) ]);
        }

        return "Check Invoices status job Done!";
    }
}
