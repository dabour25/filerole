<?php

namespace App\Exports;

use App\PermissionReceiving;
use App\PermissionReceivingPayments;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Auth;

class PurchasesBySupplierExport implements FromView
{
    private $date_from;
    private $date_to;
    private $id;
    private $type;

    public function __construct($id, $date_to, $date_from, $type, $user)
    {
        $this->date_from = $date_from;
        $this->date_to  = $date_to;
        $this->id  = $id;
        $this->type  = $type;
        $this->user = $user;

    }


    public function view(): View
    {
        if($this->user == 'supplier' && $this->type == 'total') {
            if ( !empty($this->id) != 0) {
                $list = PermissionReceiving::where(['supplier_id' => $this->id, 'org_id' => Auth::user()->org_id])->groupBy('supplier_id')->get();
            } else {
                $list = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->groupBy('supplier_id')->get();
            }
        }elseif ($this->user == 'supplier' && $this->type == 'detailed'){

            if ( !empty($this->id) != 0) {
                $list = PermissionReceiving::where(['supplier_id' => $this->id, 'org_id' => Auth::user()->org_id])->get();
                //dd($list);
            }else {
                $list = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->get();
            }
            //->whereBetween('supp_invoice_dt', [date('Y-m-d'), date('Y-m-d')])
        }elseif ($this->user == 'employee' && $this->type == 'total'){

            if ( !empty($this->id) != 0) {
                $list = PermissionReceiving::where(['user_id' => $this->id, 'org_id' => Auth::user()->org_id])->groupBy('user_id')->get();
                dd($list);
            } else {
                $list = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->groupBy('user_id')->get();
            }
        }elseif ($this->user == 'employee' && $this->type == 'detailed'){

            if ( !empty($this->id) != 0) {
                $list = PermissionReceiving::where(['user_id' => $this->id, 'org_id' => Auth::user()->org_id])->get();
            } else {
                $list = PermissionReceiving::where(['org_id' => Auth::user()->org_id])->get();
            }
        }

        $date_from = $this->date_from; $date_to = $this->date_to; $id = $this->id; $type = $this->type;  $user = $this->user;

        return view('exports.purchases', compact('list', 'date_from', 'date_to', 'id', 'type', 'user'));
    }
}
