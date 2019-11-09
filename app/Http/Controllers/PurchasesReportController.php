<?php

namespace App\Http\Controllers;

use App\Banking;
use App\CategoriesType;
use App\Category;
use App\Customers;
use App\Functions;
use App\Offers;
use App\PermissionReceivingPayments;
use App\PermissionReceiving;
use App\PriceList;
use App\CustomerHead;
use App\Transactions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use Illuminate\Validation\Rule;
use Input;
use App\Charts\Purchases;
use App\Suppliers;
use Excel;
use App\Exports\PurchasesBySupplierExport;

class PurchasesReportController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Categories Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing booking categories views
    | to admin, to show all categories, provide ability to edit and delete
    | specific category.
    |
    */


    function sum_total($id, $from, $to){
        $total = 0;
        if($from != null && $to == null){
            foreach (Transactions::where(['supplier_id' => $id, 'date' => $from])->get() as $value){
                $total += $value->price * $value->quantity * $value->req_flag;
            }
        }elseif($to != null && $from == null){
            foreach (Transactions::where(['supplier_id' => $id, 'date' => $to])->get() as $value){
                $total += $value->price * $value->quantity * $value->req_flag;
            }
        }elseif ($from != null && $to != null){

            foreach (Transactions::where(['supplier_id' => $id])->whereBetween('date', [$from, $to])->get() as $value){
                $total += $value->price * $value->quantity * $value->req_flag;
            }
        }else{
            foreach (Transactions::where(['supplier_id' => $id])->get() as $value){
                $total += $value->price * $value->quantity * $value->req_flag;
            }
        }
        return $total;
    }


    /*function sum_total_employee($id, $from, $to){
        $total = 0;
        if($from != null && $to == null){
            foreach (Transactions::where(['invoice_user' => $id, 'date' => $from])->get() as $value){
                $total += $value->price * $value->quantity * $value->req_flag;
            }
        }elseif($to != null && $from == null){
            foreach (Transactions::where(['invoice_user' => $id, 'date' => $to])->get() as $value){
                $total += $value->price * $value->quantity * $value->req_flag;
            }
        }elseif ($from != null && $to != null){

            foreach (Transactions::where(['invoice_user' => $id])->whereBetween('date', [$from, $to])->get() as $value){
                $total += $value->price * $value->quantity * $value->req_flag;
            }
        }else{
            foreach (Transactions::where(['invoice_user' => $id])->get() as $value){
                $total += $value->price * $value->quantity * $value->req_flag;
            }
        }
        return $total;
    }*/

    function sum_total_invoice($id){
        $total = 0;
            foreach (Transactions::where(['permission_receiving_id' => $id])->get() as $value){
                $total += $value->price * $value->quantity * $value->req_flag;
            }

        return $total;
    }

    function sum_total_invoice2($id, $from, $to){
        $total = 0;
        if($from != null && $to == null){
            foreach (PermissionReceiving::where(['supplier_id' => $id, 'supp_invoice_dt' => $from])->get() as $vv) {
                foreach (Transactions::where(['permission_receiving_id' => $vv->id])->get() as $value) {
                    $total += $value->price * $value->quantity * $value->req_flag;
                }
                $total += $vv->other_payment;
            }
        }elseif($to != null && $from == null){
            foreach (PermissionReceiving::where(['supplier_id' => $id, 'supp_invoice_dt' => $to])->get() as $vv) {
                foreach (Transactions::where(['permission_receiving_id' => $vv->id])->get() as $value) {
                    $total += $value->price * $value->quantity * $value->req_flag;
                }
                $total += $vv->other_payment;
            }
        }elseif ($from != null && $to != null){
            foreach (PermissionReceiving::where(['supplier_id' => $id])->whereBetween('supp_invoice_dt', [$from, $to])->get() as $vv) {
                foreach (Transactions::where(['permission_receiving_id' => $vv->id])->get() as $value) {
                    $total += $value->price * $value->quantity * $value->req_flag;
                }
                $total += $vv->other_payment;
            }

        }else{
            foreach (PermissionReceiving::where(['supplier_id' => $id])->get() as $vv) {
                foreach (Transactions::where(['permission_receiving_id' => $vv->id])->get() as $value) {
                    $total += $value->price * $value->quantity * $value->req_flag;
                }
                $total += $vv->other_payment;
            }
        }
        //dd($total);
        return $total;
    }

    function sum_total_employee($id, $from, $to){
        $total = 0;
        if($from != null && $to == null){
            foreach (PermissionReceiving::where(['user_id' => $id, 'supp_invoice_dt' => $from])->get() as $vv) {
                foreach (Transactions::where(['permission_receiving_id' => $vv->id])->get() as $value) {
                    $total += $value->price * $value->quantity * $value->req_flag;
                }
            }
        }elseif($to != null && $from == null){
            foreach (PermissionReceiving::where(['user_id' => $id, 'supp_invoice_dt' => $to])->get() as $vv) {
                foreach (Transactions::where(['permission_receiving_id' => $vv->id])->get() as $value) {
                    $total += $value->price * $value->quantity * $value->req_flag;
                }
            }
        }elseif ($from != null && $to != null){
            foreach (PermissionReceiving::where(['user_id' => $id])->whereBetween('supp_invoice_dt', [$from, $to])->get() as $vv) {
                foreach (Transactions::where(['permission_receiving_id' => $vv->id])->get() as $value) {
                    $total += $value->price * $value->quantity * $value->req_flag;
                }
            }
        }else{
            foreach (PermissionReceiving::where(['user_id' => $id])->get() as $vv) {
                foreach (Transactions::where(['permission_receiving_id' => $vv->id])->get() as $value) {
                    $total += $value->price * $value->quantity * $value->req_flag;
                }
            }
        }

        return $total;
    }

    function sum_paid($id, $from, $to){
        $total = 0;
        if($from != null && $to == null){
            foreach (PermissionReceiving::where(['supplier_id' => $id, 'supp_invoice_dt' => $from])->get() as $v) {
                $total += PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'supplier_id' => $id, 'pay_flag' => -1])->sum('pay_amount');
            }
        }elseif($to != null && $from == null){
            foreach (PermissionReceiving::where(['supplier_id' => $id, 'supp_invoice_dt' => $to])->get() as $v) {
                $total += PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'supplier_id' => $id, 'pay_flag' => -1])->sum('pay_amount');
            }
        }elseif ($from != null && $to != null){
            foreach (PermissionReceiving::where(['supplier_id' => $id])->whereBetween('supp_invoice_dt', [$from, $to])->get() as $v) {
                $total += PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
            }
        }else{
            foreach (PermissionReceiving::where(['supplier_id' => $id])->get() as $v) {
                $total += PermissionReceivingPayments::where(['permission_receiving_id' => $v->id,'supplier_id' => $id, 'pay_flag' => -1])->sum('pay_amount');
            }
        }

        return $total;
    }

    function sum_paid_employee($id, $from,$to){
        $total = 0;
        if($from != null && $to == null){
            foreach (PermissionReceiving::where(['user_id' => $id, 'supp_invoice_dt' => $from])->get() as $v) {
                $total += PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
            }
        }elseif($to != null && $from == null){
            foreach (PermissionReceiving::where(['user_id' => $id, 'supp_invoice_dt' => $to])->get() as $v) {
                $total += PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
            }
        }elseif ($from != null && $to != null){
            foreach (PermissionReceiving::where(['user_id' => $id])->whereBetween('supp_invoice_dt', [$from, $to])->get() as $v) {
                $total += PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
            }
        }else{
            foreach (PermissionReceiving::where(['user_id' => $id])->get() as $v) {
                $total += PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
            }
        }
        return $total;
    }

    public function Purchases(Request $request, $iuser, $type){
        //return $request->all();

        //if(!empty($request->save) && $request->save != 1) {
            $labels = null; $total = null; $paid = null; $remaining = null;
            $date_from = date('Y-m-d', strtotime($request->search_date_from));
            $date_to = date('Y-m-d', strtotime($request->search_date_to));

            if ($iuser == 'supplier') {
                if (empty($request->search_date_from) && empty($request->search_date_to) && $request->search_name == 0) {
                    $supplier_invoice = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->whereBetween('supp_invoice_dt', [date('Y-m-d'), date('Y-m-d')])->groupBy('supplier_id')->get();

                    foreach ($suppliers = $supplier_invoice as $value) {
                        $sum = $this->sum_total_invoice2($value->supplier_id, date('Y-m-d'), date('Y-m-d'));
                        $user = Suppliers::findOrFail($value->supplier_id);

                        $labels[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                        $total[] = $sum + $value->other_payment;
                        $paid[] = $this->sum_paid($value->supplier_id, date('Y-m-d'), date('Y-m-d'));
                        $remaining[] = $sum - $this->sum_paid($value->supplier_id, date('Y-m-d'), date('Y-m-d'));

                        //list
                        if ($type == 'total') {
                            $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                            $value->total = $sum;
                            $value->paid = $this->sum_paid($value->supplier_id, date('Y-m-d'), date('Y-m-d'));
                            $value->remaining = $sum - $this->sum_paid($value->supplier_id, date('Y-m-d'), date('Y-m-d'));
                        }
                    }

                    if ($type == 'detailed') {
                        foreach ($supplier_invoice = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->whereBetween('supp_invoice_dt', [date('Y-m-d'), date('Y-m-d')])->get() as $v) {
                            $v->total_invoice = $this->sum_total_invoice($v->id);
                            $v->total_paid = $this->sum_total_invoice($v->id) + $v->other_payment;
                            $v->paid = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
                            $v->refund = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount');
                            $v->remaining = $this->sum_total_invoice($v->id) + $v->other_payment - (PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount') - PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount'));
                        }
                    }

                }
                if (empty($request->search_date_from) && empty($request->search_date_to) && !empty($request->search_name)) {
                    $supplier_invoice = PermissionReceiving::where(['supplier_id' => $request->search_name])->groupBy('supplier_id')->get();
                    foreach ($suppliers = $supplier_invoice as $value) {
                        $sum = $this->sum_total_invoice2($value->supplier_id, null, null);
                        $user = Suppliers::findOrFail($value->supplier_id);

                        $labels[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                        $total[] = $sum;
                        $paid[] = PermissionReceivingPayments::where(['supplier_id' => $value->supplier_id, 'pay_flag' => -1])->sum('pay_amount');
                        $remaining[] = $sum - PermissionReceivingPayments::where(['supplier_id' => $value->supplier_id, 'pay_flag' => -1])->sum('pay_amount');
                        //list
                        if ($type == 'total') {
                            $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                            $value->total = $sum;
                            $value->paid = PermissionReceivingPayments::where(['supplier_id' => $value->supplier_id, 'pay_flag' => -1])->sum('pay_amount');
                            $value->remaining = $sum - PermissionReceivingPayments::where(['supplier_id' => $value->supplier_id, 'pay_flag' => -1])->sum('pay_amount');
                        }
                    }

                    if ($type == 'detailed') {
                        foreach ($supplier_invoice = PermissionReceiving::where(['supplier_id' => $request->search_name])->get() as $v) {
                            $v->total_invoice = $this->sum_total_invoice($v->id);
                            $v->total_paid = $this->sum_total_invoice($v->id) + $v->other_payment;
                            $v->paid = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
                            $v->refund = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount');
                            $v->remaining = $this->sum_total_invoice($v->id) + $v->other_payment - (PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount') - PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount'));
                        }
                    }

                }
                if (!empty($request->search_date_from) && empty($request->search_date_to) && !empty($request->search_name)) {
                    $supplier_invoice = PermissionReceiving::where(['supplier_id' => $request->search_name, 'supp_invoice_dt' => $date_from])->groupBy('supplier_id')->get();
                    foreach ($suppliers = $supplier_invoice as $value) {
                        $sum = $this->sum_total_invoice2($value->supplier_id, $date_from, null);
                        $user = Suppliers::findOrFail($value->supplier_id);

                        $labels[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                        $total[] = $sum;
                        $paid[] = $this->sum_paid($value->supplier_id, $date_from, null);
                        $remaining[] = $sum - $this->sum_paid($value->supplier_id, $date_from, null);

                        //list
                        if ($type == 'total') {
                            $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                            $value->total = $sum;
                            $value->paid = $this->sum_paid($value->supplier_id, $date_from, null);
                            $value->remaining = $sum - $this->sum_paid($value->supplier_id, $date_from, null);
                        }
                    }

                    if ($type == 'detailed') {
                        foreach ($supplier_invoice = PermissionReceiving::where(['supplier_id' => $request->search_name, 'supp_invoice_dt' => $date_from])->get() as $v) {
                            $v->total_invoice = $this->sum_total_invoice($v->id);
                            $v->total_paid = $this->sum_total_invoice($v->id) + $v->other_payment;
                            $v->paid = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
                            $v->refund = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount');
                            $v->remaining = $this->sum_total_invoice($v->id) + $v->other_payment - (PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount') - PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount'));
                        }
                    }
                }
                if (empty($request->search_date_from) && !empty($request->search_date_to) && !empty($request->search_name)) {
                    $supplier_invoice = PermissionReceiving::where(['supplier_id' => $request->search_name, 'supp_invoice_dt' => $date_to])->groupBy('supplier_id')->get();

                    foreach ($suppliers = $supplier_invoice as $value) {
                        $sum = $this->sum_total_invoice2($value->supplier_id, null, $date_to);
                        $user = Suppliers::findOrFail($value->supplier_id);

                        $labels[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                        $total[] = $sum;
                        $paid[] = $this->sum_paid($value->supplier_id, null, $date_to);
                        $remaining[] = $sum - $this->sum_paid($value->supplier_id,  null, $date_to);

                        //list
                        if ($type == 'total') {
                            $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                            $value->total = $sum;
                            $value->paid = $this->sum_paid($value->supplier_id, null, $date_to);
                            $value->remaining = $sum - $this->sum_paid($value->supplier_id, null, $date_to);
                        }
                    }

                    if ($type == 'detailed') {
                        foreach ($supplier_invoice = PermissionReceiving::where(['supplier_id' => $request->search_name, 'supp_invoice_dt' => $date_to])->get() as $v) {
                            $v->total_invoice = $this->sum_total_invoice($v->id);
                            $v->total_paid = $this->sum_total_invoice($v->id) + $v->other_payment;
                            $v->paid = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
                            $v->refund = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount');
                            $v->remaining = $this->sum_total_invoice($v->id) + $v->other_payment - (PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount') - PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount'));
                        }
                    }
                }
                if (!empty($request->search_date_from) && !empty($request->search_date_to) && !empty($request->search_name)) {
                    $supplier_invoice = PermissionReceiving::where(['supplier_id' => $request->search_name])->whereBetween('supp_invoice_dt', [$date_from, $date_to])->groupBy('supplier_id')->get();
                    foreach ($suppliers = $supplier_invoice as $value) {
                        $sum = $this->sum_total_invoice2($value->supplier_id, $date_from, $date_to);
                        $user = Suppliers::findOrFail($value->supplier_id);

                        $labels[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                        $total[] = $sum;
                        $paid[] = $this->sum_paid($value->supplier_id, $date_from, $date_to);
                        $remaining[] = $sum - $this->sum_paid($value->supplier_id, $date_from, $date_to);

                        //list
                        if ($type == 'total') {
                            $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                            $value->total = $sum;
                            $value->paid = $this->sum_paid($value->supplier_id, $date_from, $date_to);
                            $value->remaining = $sum - $this->sum_paid($value->supplier_id, $date_from, $date_to);
                        }
                    }

                    if ($type == 'detailed') {
                        foreach ($supplier_invoice = PermissionReceiving::where(['supplier_id' => $request->search_name])->whereBetween('supp_invoice_dt', [$date_from, $date_to])->get() as $v) {
                            $v->total_invoice = $this->sum_total_invoice($v->id);
                            $v->total_paid = $this->sum_total_invoice($v->id) + $v->other_payment;
                            $v->paid = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
                            $v->refund = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount');
                            $v->remaining = $this->sum_total_invoice($v->id) + $v->other_payment - (PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount') - PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount'));
                        }
                    }
                }
                if (!empty($request->search_date_from) && !empty($request->search_date_to) && $request->search_name == 0) {

                    $supplier_invoice = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->whereBetween('supp_invoice_dt', [$date_from, $date_to])->groupBy('supplier_id')->get();

                    foreach ($suppliers = $supplier_invoice as $value) {
                        $sum = $this->sum_total_invoice2($value->supplier_id, $date_from, $date_to);
                        $user = Suppliers::findOrFail($value->supplier_id);

                        $labels[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                        $total[] = $sum;
                        $paid[] = $this->sum_paid($value->supplier_id, $date_from, $date_to);
                        $remaining[] = $sum - $this->sum_paid($value->supplier_id, $date_from, $date_to);

                        //list
                        if ($type == 'total') {
                            $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                            $value->total = $sum;
                            $value->paid = $this->sum_paid($value->supplier_id, $date_from, $date_to);
                            $value->remaining = $sum - $this->sum_paid($value->supplier_id, $date_from, $date_to);
                        }
                    }

                    if ($type == 'detailed') {
                        foreach ($supplier_invoice = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->whereBetween('supp_invoice_dt', [$date_from, $date_to])->get() as $v) {
                            $v->total_invoice = $this->sum_total_invoice($v->id);
                            $v->total_paid = $this->sum_total_invoice($v->id) + $v->other_payment;
                            $v->paid = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
                            $v->refund = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount');
                            $v->remaining = $this->sum_total_invoice($v->id) + $v->other_payment - (PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount') - PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount'));
                        }
                    }


                }
                if (!empty($request->search_date_from) && empty($request->search_date_to) && $request->search_name == 0) {
                    $supplier_invoice = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->whereDate('supp_invoice_dt', $date_from)->groupBy('supplier_id')->get();
                    foreach ($suppliers = $supplier_invoice as $value) {
                        $sum = $this->sum_total_invoice2($value->supplier_id, null, $date_from);
                        $user = Suppliers::findOrFail($value->supplier_id);

                        $labels[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                        $total[] = $sum;
                        $paid[] = $this->sum_paid($value->supplier_id, null, $date_from);
                        $remaining[] = $sum - $this->sum_paid($value->supplier_id, null, $date_from);

                        //list
                        if ($type == 'total') {
                            $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                            $value->total = $sum;
                            $value->paid = $this->sum_paid($value->supplier_id, null, $date_from);
                            $value->remaining = $sum - $this->sum_paid($value->supplier_id, null, $date_from);
                        }
                    }

                    if ($type == 'detailed') {
                        foreach ($supplier_invoice = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->whereDate('supp_invoice_dt', $date_from)->get() as $v) {
                            $v->total_invoice = $this->sum_total_invoice($v->id);
                            $v->total_paid = $this->sum_total_invoice($v->id) + $v->other_payment;
                            $v->paid = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
                            $v->refund = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount');
                            $v->remaining = $this->sum_total_invoice($v->id) + $v->other_payment - (PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount') - PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount'));
                        }
                    }
                }
                if (empty($request->search_date_from) && !empty($request->search_date_to) && $request->search_name == 0) {
                    $supplier_invoice = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->whereDate('supp_invoice_dt', $date_to)->groupBy('supplier_id')->get();

                    foreach ($suppliers = $supplier_invoice as $value) {
                        $sum = $this->sum_total_invoice2($value->supplier_id, $date_to, null);
                        $user = Suppliers::findOrFail($value->supplier_id);

                        $labels[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                        $total[] = $sum;
                        $paid[] = $this->sum_paid($value->supplier_id, $date_to, null);
                        $remaining[] = $sum - $this->sum_paid($value->supplier_id, $date_to, null);

                        //list
                        if ($type == 'total') {
                            $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                            $value->total = $sum;
                            $value->paid = $this->sum_paid($value->supplier_id, $date_to, null);
                            $value->remaining = $sum - $this->sum_paid($value->supplier_id, $date_to, null);
                        }
                    }

                    if ($type == 'detailed') {
                        foreach ($supplier_invoice = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->whereDate('supp_invoice_dt', $date_to)->get() as $v) {
                            $v->total_invoice = $this->sum_total_invoice($v->id);
                            $v->total_paid = $this->sum_total_invoice($v->id) + $v->other_payment;
                            $v->paid = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
                            $v->refund = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount');
                            $v->remaining = $this->sum_total_invoice($v->id) + $v->other_payment - (PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount') - PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount'));
                        }
                    }
                }
            }
            elseif ($iuser == 'employee') {
                if (empty($request->search_date_from) && empty($request->search_date_to) && $request->search_name == 0) {
                    foreach ($suppliers = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->groupBy('user_id')->get() as $value) {
                        $sum = $this->sum_total_employee($value->user_id, date('Y-m-d'), date('Y-m-d'));
                        if($sum != 0) {
                            $other_payment = PermissionReceiving::where(['user_id' => $value->user_id, 'supp_invoice_dt' => date('Y-m-d')])->sum('other_payment');
                            $user = User::findOrFail($value->user_id);

                            $labels[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                            $total[] = $sum + $other_payment;
                            $paid[] = $this->sum_paid_employee($value->user_id, date('Y-m-d'), date('Y-m-d'));
                            $remaining[] = $sum + $other_payment - $this->sum_paid_employee($value->user_id, date('Y-m-d'), date('Y-m-d'));

                            //list
                            if ($type == 'total') {
                                $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                                $value->total = $sum + PermissionReceiving::where('user_id', $value->user_id)->sum('other_payment');
                                $value->paid = $this->sum_paid_employee($value->user_id, date('Y-m-d'), date('Y-m-d'));
                                $value->remaining = $sum + $other_payment - $this->sum_paid_employee($value->user_id, date('Y-m-d'), date('Y-m-d'));
                            }
                        }
                    }

                    if ($type == 'detailed') {
                        foreach ($supplier_invoice = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->whereBetween('supp_invoice_dt', [date('Y-m-d'), date('Y-m-d')])->get() as $v) {
                            $v->total_invoice = $this->sum_total_invoice($v->id);
                            $v->total_paid = $this->sum_total_invoice($v->id) + $v->other_payment;
                            $v->paid = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
                            $v->refund = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount');
                            $v->remaining = $this->sum_total_invoice($v->id) + $v->other_payment - (PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount') - PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount'));
                        }
                    }

                }
                if (empty($request->search_date_from) && empty($request->search_date_to) && !empty($request->search_name)) {
                    foreach ($suppliers = PermissionReceiving::where(['user_id' => $request->search_name])->groupBy('user_id')->get() as $value) {
                        $sum = $this->sum_total_employee($value->user_id, null, null);
                        $other_payment = PermissionReceiving::where('user_id', $value->user_id)->sum('other_payment');
                        $user = User::findOrFail($value->user_id);

                        $labels[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                        $total[] = $sum + $other_payment;
                        $paid[] = $this->sum_paid_employee($value->user_id, null, null);
                        $remaining[] = $sum + $other_payment - $this->sum_paid_employee($value->user_id, null, null);

                        //list
                        if ($type == 'total') {
                            $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                            $value->total = $sum + PermissionReceiving::where('user_id', $value->user_id)->sum('other_payment');
                            $value->paid = $this->sum_paid_employee($value->user_id, null, null);
                            $value->remaining = $sum + PermissionReceiving::where('user_id', $value->user_id)->sum('other_payment') - $this->sum_paid_employee($value->user_id, null, null);
                        }
                    }

                    if ($type == 'detailed') {
                        foreach ($supplier_invoice = PermissionReceiving::where(['user_id' => $request->search_name])->get() as $v) {
                            $v->total_invoice = $this->sum_total_invoice($v->id);
                            $v->total_paid = $this->sum_total_invoice($v->id) + $v->other_payment;
                            $v->paid = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
                            $v->refund = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount');
                            $v->remaining = $this->sum_total_invoice($v->id) + $v->other_payment - (PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount') - PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount'));
                        }
                    }
                    //return $supplier_invoice;

                }
                if (!empty($request->search_date_from) && empty($request->search_date_to) && !empty($request->search_name)) {

                    foreach ($suppliers = PermissionReceiving::where(['user_id' => $request->search_name])->groupBy('user_id')->get() as $value) {
                        $sum = $this->sum_total_employee($value->user_id, null, $date_from);
                        $other_payment = PermissionReceiving::where('user_id', $value->user_id)->whereDate('supp_invoice_dt', $date_from)->sum('other_payment');
                        $user = User::findOrFail($value->user_id);

                        $labels[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                        $total[] = $sum + $other_payment;
                        $paid[] = $this->sum_paid_employee($value->user_id, $date_from,null);
                        $remaining[] = $sum + $other_payment - $this->sum_paid_employee($value->user_id, $date_from,null);

                        //list
                        if ($type == 'total') {
                            $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                            $value->total = $sum + $other_payment;
                            $value->paid = $this->sum_paid_employee($value->user_id, $date_from,null);
                            $value->remaining = $sum + $other_payment - $this->sum_paid_employee($value->user_id, $date_from,null);
                        }
                    }

                    if ($type == 'detailed') {
                        foreach ($supplier_invoice = PermissionReceiving::where(['user_id' => $request->search_name])->whereDate('supp_invoice_dt', $date_from)->get() as $v) {
                            $v->total_invoice = $this->sum_total_invoice($v->id);
                            $v->total_paid = $this->sum_total_invoice($v->id) + $v->other_payment;
                            $v->paid = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
                            $v->refund = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount');
                            $v->remaining = $this->sum_total_invoice($v->id) + $v->other_payment - (PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount') - PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount'));
                        }
                    }
                }
                if (empty($request->search_date_from) && !empty($request->search_date_to) && !empty($request->search_name)) {
                    foreach ($suppliers = PermissionReceiving::where(['user_id' => $request->search_name])->groupBy('user_id')->get() as $value) {
                        $sum = $this->sum_total_employee($value->user_id, null, $date_to);
                        $other_payment = PermissionReceiving::where('user_id', $value->user_id)->whereDate('supp_invoice_dt', $date_to)->sum('other_payment');
                        $user = User::findOrFail($value->user_id);

                        $labels[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                        $total[] = $sum + $other_payment;
                        $paid[] = $this->sum_paid_employee($value->user_id, null, $date_to);
                        $remaining[] = $sum + $other_payment - $this->sum_paid_employee($value->user_id, null, $date_to);

                        //list
                        if ($type == 'total') {
                            $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                            $value->total = $sum + $other_payment;
                            $value->paid = $this->sum_paid_employee($value->user_id, null, $date_to);
                            $value->remaining = $sum + $other_payment - $this->sum_paid_employee($value->user_id, null, $date_to);
                        }
                    }

                    if ($type == 'detailed') {
                        foreach ($supplier_invoice = PermissionReceiving::where(['user_id' => $request->search_name])->whereDate('supp_invoice_dt', $date_to)->get() as $v) {
                            $v->total_invoice = $this->sum_total_invoice($v->id);
                            $v->total_paid = $this->sum_total_invoice($v->id) + $v->other_payment;
                            $v->paid = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
                            $v->refund = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount');
                            $v->remaining = $this->sum_total_invoice($v->id) + $v->other_payment - (PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount') - PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount'));
                        }
                    }
                }
                if (!empty($request->search_date_from) && !empty($request->search_date_to) && !empty($request->search_name)) {

                    foreach ($suppliers = PermissionReceiving::where(['user_id' => $request->search_name])->groupBy('user_id')->get() as $value) {
                        $sum = $this->sum_total_employee($value->user_id, $date_from, $date_to);
                        $other_payment = PermissionReceiving::where('user_id', $value->user_id)->whereBetween('supp_invoice_dt', [$date_from, $date_to])->sum('other_payment');
                        $user = User::findOrFail($value->user_id);

                        $labels[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                        $total[] = $sum + $other_payment;
                        $paid[] = $this->sum_paid_employee($value->user_id, $date_from, $date_to);
                        $remaining[] = $sum + $other_payment - $this->sum_paid_employee($value->user_id, $date_from, $date_to);

                        //list
                        if ($type == 'total') {
                            $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                            $value->total = $sum + $other_payment;
                            $value->paid = $this->sum_paid_employee($value->user_id, $date_from, $date_to);
                            $value->remaining = $sum + $other_payment - $this->sum_paid_employee($value->user_id, $date_from, $date_to);
                        }
                    }

                    if ($type == 'detailed') {
                        foreach ($supplier_invoice = PermissionReceiving::where(['user_id' => $request->search_name])->whereBetween('supp_invoice_dt', [$date_from, $date_to])->get() as $v) {
                            $v->total_invoice = $this->sum_total_invoice($v->id);
                            $v->total_paid = $this->sum_total_invoice($v->id) + $v->other_payment;
                            $v->paid = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
                            $v->refund = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount');
                            $v->remaining = $this->sum_total_invoice($v->id) + $v->other_payment - (PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount') - PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount'));
                        }
                    }
                }
                if (!empty($request->search_date_from) && !empty($request->search_date_to) && $request->search_name == 0) {
                    foreach ($suppliers = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->groupBy('user_id')->get() as $value) {
                        $sum = $this->sum_total_employee($value->user_id, $date_from, $date_to);
                        $other_payment = PermissionReceiving::where('user_id', $value->user_id)->whereBetween('supp_invoice_dt', [$date_from, $date_to])->sum('other_payment');
                        $user = User::findOrFail($value->user_id);

                        $labels[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                        $total[] = $sum + $other_payment;
                        $paid[] = $this->sum_paid_employee($value->user_id, $date_from, $date_to);
                        $remaining[] = $sum + $other_payment - $this->sum_paid_employee($value->user_id, $date_from, $date_to);

                        //list
                        if ($type == 'total') {
                            $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                            $value->total = $sum + $other_payment;
                            $value->paid = $this->sum_paid_employee($value->user_id, $date_from, $date_to);
                            $value->remaining = $sum + $other_payment - $this->sum_paid_employee($value->user_id, $date_from, $date_to);
                        }
                    }
                    if ($type == 'detailed') {
                        foreach ($supplier_invoice = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->whereBetween('supp_invoice_dt', [$date_from, $date_to])->get() as $v) {
                            $v->total_invoice = $this->sum_total_invoice($v->id);
                            $v->total_paid = $this->sum_total_invoice($v->id) + $v->other_payment;
                            $v->paid = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
                            $v->refund = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount');
                            $v->remaining = $this->sum_total_invoice($v->id) + $v->other_payment - (PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount') - PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount'));
                        }
                    }
                }
                if (!empty($request->search_date_from) && empty($request->search_date_to) && $request->search_name == 0) {

                    foreach ($suppliers = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->groupBy('user_id')->get() as $value) {
                        $sum = $this->sum_total_employee($value->user_id, $date_from, null);
                        $other_payment = PermissionReceiving::where('user_id', $value->user_id)->whereDate('supp_invoice_dt', $date_from)->sum('other_payment');
                        $user = User::findOrFail($value->user_id);

                        $labels[] = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                        $total[] = $sum + $other_payment;
                        $paid[] = $this->sum_paid_employee($value->user_id, $date_from, null);
                        $remaining[] = $sum + $other_payment - $this->sum_paid_employee($value->user_id, $date_from, null);

                        //list
                        if ($type == 'total') {
                            $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                            $value->total = $sum + $other_payment;
                            $value->paid = $this->sum_paid_employee($value->user_id, $date_from, null);
                            $value->remaining = $sum + $other_payment - $this->sum_paid_employee($value->user_id, $date_from, null);
                        }
                    }

                    if ($type == 'detailed') {
                        foreach ($supplier_invoice = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->whereDate('supp_invoice_dt', $date_from)->get() as $v) {
                            $v->total_invoice = $this->sum_total_invoice($v->id);
                            $v->total_paid = $this->sum_total_invoice($v->id) + $v->other_payment;
                            $v->paid = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
                            $v->refund = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount');
                            $v->remaining = $this->sum_total_invoice($v->id) + $v->other_payment - (PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount') - PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount'));
                        }
                    }
                }
                if (empty($request->search_date_from) && !empty($request->search_date_to) && $request->search_name == 0) {
                    foreach ($suppliers = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->groupBy('user_id')->get() as $value) {
                        $sum = $this->sum_total_employee($value->user_id, null, $date_to);
                        $other_payment = PermissionReceiving::where('user_id', $value->user_id)->whereDate('supp_invoice_dt', $date_to)->sum('other_payment');
                        $user = User::findOrFail($value->user_id);

                        $labels[] = app()->getLocale() == 'ar' ? $value->name : $value->name_en;
                        $total[] = $sum + $other_payment;
                        $paid[] = $this->sum_paid_employee($value->user_id, null, $date_to);
                        $remaining[] = $sum + $other_payment - $this->sum_paid_employee($value->user_id, null, $date_to);

                        //list
                        if ($type == 'total') {
                            $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
                            $value->total = $sum + $other_payment;
                            $value->paid = $this->sum_paid_employee($value->user_id, null, $date_to);
                            $value->remaining = $sum + $other_payment - $this->sum_paid_employee($value->user_id, null, $date_to);
                        }
                    }

                    if ($type == 'detailed') {
                        foreach ($supplier_invoice = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->whereDate('supp_invoice_dt', $date_to)->get() as $v) {
                            $v->total_invoice = $this->sum_total_invoice($v->id);
                            $v->total_paid = $this->sum_total_invoice($v->id) + $v->other_payment;
                            $v->paid = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount');
                            $v->refund = PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount');
                            $v->remaining = $this->sum_total_invoice($v->id) + $v->other_payment - (PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => -1])->sum('pay_amount') - PermissionReceivingPayments::where(['permission_receiving_id' => $v->id, 'pay_flag' => 1])->sum('pay_amount'));
                        }
                    }
                }
            }

            if (!empty($labels) && !empty($total) && !empty($paid) && !empty($remaining)) {
                $chart = new Purchases();
                $chart->labels($labels);
                $chart->dataset(app()->getLocale() == 'ar' ? 'الاجمالى' : 'Total', 'bar', $total)->color('#e6270c');
                $chart->dataset(app()->getLocale() == 'ar' ? 'المدفوع' : 'Paid', 'bar', $paid)->color('#1dad1f');
                $chart->dataset(app()->getLocale() == 'ar' ? 'المتبقى' : 'Remaining', 'bar', $remaining)->color('#04c');
            }

        //}

        if(!empty($request->save) && $request->save == 2){
            $request->search_date_from == null ? $date_from = null : $date_from = date('Y-m-d', strtotime($request->search_date_from));
            $request->search_date_to == null ? $date_to = null : $date_to = date('Y-m-d', strtotime($request->search_date_to));

            if($iuser == 'supplier' && $type == 'total') {
                if(!empty($date_to) && !empty($date_to)){
                    return Excel::download(new PurchasesBySupplierExport($request->search_name, $date_to, $date_from, $type, $iuser), 'purchases_supplier_total.xlsx');
                }elseif (empty($date_to) && !empty($date_to)){
                    return Excel::download(new PurchasesBySupplierExport($request->search_name,null, $date_from, $type, $iuser), 'purchases_supplier_total.xlsx');
                }elseif (!empty($date_to) && empty($date_to)){
                    return Excel::download(new PurchasesBySupplierExport($request->search_name,$date_to, null, $type, $iuser), 'purchases_supplier_total.xlsx');
                }else{
                    return Excel::download(new PurchasesBySupplierExport($request->search_name, null, null, $type, $iuser), 'purchases_supplier_total.xlsx');
                }
            }elseif ($iuser == 'supplier' && $type == 'detailed'){
                if(!empty($date_to) && !empty($date_to)){
                    return Excel::download(new PurchasesBySupplierExport($request->search_name, $date_to, $date_from, $type, $iuser), 'purchases_supplier_detailed.xlsx');
                }elseif (empty($date_to) && !empty($date_to)){
                    return Excel::download(new PurchasesBySupplierExport($request->search_name,null, $date_from, $type, $iuser), 'purchases_supplier_detailed.xlsx');
                }elseif (!empty($date_to) && empty($date_to)){
                    return Excel::download(new PurchasesBySupplierExport($request->search_name,$date_to, null, $type, $iuser), 'purchases_supplier_detailed.xlsx');
                }else{
                    return Excel::download(new PurchasesBySupplierExport($request->search_name, null, null, $type, $iuser), 'purchases_supplier_detailed.xlsx');
                }
            }elseif ($iuser == 'employee' && $type == 'total'){
                if(!empty($date_to) && !empty($date_to)){
                    return Excel::download(new PurchasesBySupplierExport($request->search_name, $date_to, $date_from, $type, $iuser), 'purchases_employee_total.xlsx');
                }elseif (empty($date_to) && !empty($date_to)){
                    return Excel::download(new PurchasesBySupplierExport($request->search_name,null, $date_from, $type, $iuser), 'purchases_employee_total.xlsx');
                }elseif (!empty($date_to) && empty($date_to)){
                    return Excel::download(new PurchasesBySupplierExport($request->search_name,$date_to, null, $type, $iuser), 'purchases_employee_total.xlsx');
                }else{
                    return Excel::download(new PurchasesBySupplierExport($request->search_name, null, null, $type, $iuser), 'purchases_employee_total.xlsx');
                }
            }elseif ($iuser == 'employee' && $type == 'detailed'){
                if(!empty($date_to) && !empty($date_to)){
                    return Excel::download(new PurchasesBySupplierExport($request->search_name, $date_to, $date_from, $type, $iuser), 'purchases_employee_detailed.xlsx');
                }elseif (empty($date_to) && !empty($date_to)){
                    return Excel::download(new PurchasesBySupplierExport($request->search_name,null, $date_from, $type, $iuser), 'purchases_employee_detailed.xlsx');
                }elseif (!empty($date_to) && empty($date_to)){
                    return Excel::download(new PurchasesBySupplierExport($request->search_name,$date_to, null, $type, $iuser), 'purchases_employee_detailed.xlsx');
                }else{
                    return Excel::download(new PurchasesBySupplierExport($request->search_name, null, null, $type, $iuser), 'purchases_employee_detailed.xlsx');
                }
            }
        }

        return view('reports.purchases', compact('chart', 'suppliers', 'iuser', 'type', 'supplier_invoice'));

    }

    public function exports(Request $request, $user, $type){
        if($user == 'supplier' && $type == 'total') {
            return Excel::download(new PurchasesBySupplierExport, 'invoices.xlsx');
        }elseif ($user == 'supplier' && $type == 'detailed'){
            return Excel::download(new PurchasesBySupplierExport, 'invoices.xlsx');
        }
    }




}
