<table>
    @if($user == 'supplier' && $type == 'total')
        <thead>
            <tr>
                <th>{{ __('strings.Name') }}</th>
                <th>{{ __('strings.Total') }}</th>
                <th>{{ __('strings.Paid') }}</th>
                <th>{{ __('strings.Remaining') }}</th>
            </tr>
        </thead>

        <tbody>
        @foreach($list as $value)
            @php
                $user = App\Suppliers::findOrFail($value->supplier_id);
                $total = 0; $paid = 0;

                if($date_from != null && $date_to == null){
                    foreach (App\PermissionReceiving::where(['supplier_id' => $value->supplier_id, 'supp_invoice_dt' => $date_from])->get() as $vv) {
                        foreach (App\Transactions::where(['permission_receiving_id' => $vv->id])->get() as $va) {
                            $total += $va->price * $va->quantity * $va->req_flag;
                        }
                        $paid += App\PermissionReceivingPayments::where(['permission_receiving_id' => $vv->id,'supplier_id' => $value->supplier_id, 'pay_flag' => -1])->sum('pay_amount');
                        $total += $vv->other_payment;
                    }
                }elseif($date_to != null && $date_from == null){

                    foreach (App\PermissionReceiving::where(['supplier_id' => $value->supplier_id, 'supp_invoice_dt' => $date_to])->get() as $vv) {
                        foreach (App\Transactions::where(['permission_receiving_id' => $vv->id])->get() as $va) {
                            $total += $va->price * $va->quantity * $va->req_flag;
                        }
                        $paid += App\PermissionReceivingPayments::where(['permission_receiving_id' => $vv->id,'supplier_id' => $value->supplier_id, 'pay_flag' => -1])->sum('pay_amount');
                        $total += $vv->other_payment;
                    }
                }elseif ($date_from != null && $date_to != null){
                    foreach (App\PermissionReceiving::where(['supplier_id' => $value->supplier_id])->whereBetween('supp_invoice_dt', [$date_to, $date_from])->get() as $vv) {
                        foreach (App\Transactions::where(['permission_receiving_id' => $vv->id])->get() as $va) {
                            $total += $va->price * $va->quantity * $va->req_flag;
                        }
                        $paid += App\PermissionReceivingPayments::where(['permission_receiving_id' => $vv->id,'supplier_id' => $value->supplier_id, 'pay_flag' => -1])->sum('pay_amount');
                        $total += $vv->other_payment;
                    }
                }elseif ($date_from == null && $date_to == null){
                    foreach (App\PermissionReceiving::where(['supplier_id' => $value->supplier_id])->get() as $vv) {
                        foreach (App\Transactions::where(['permission_receiving_id' => $vv->id])->get() as $va) {
                            $total += $va->price * $va->quantity * $va->req_flag;
                        }
                        $paid += App\PermissionReceivingPayments::where(['permission_receiving_id' => $vv->id,'supplier_id' => $value->supplier_id, 'pay_flag' => -1])->sum('pay_amount');
                        $total += $vv->other_payment;
                    }
                }else{
                    foreach (App\PermissionReceiving::where(['supplier_id' => $value->supplier_id])->get() as $vv) {
                        foreach (App\Transactions::where(['permission_receiving_id' => $vv->id])->get() as $va) {
                            $total += $va->price * $va->quantity * $va->req_flag;
                        }
                        $paid += App\PermissionReceivingPayments::where(['permission_receiving_id' => $vv->id,'supplier_id' => $value->supplier_id, 'pay_flag' => -1])->sum('pay_amount');
                        $total += $vv->other_payment;
                    }

                }
            @endphp
            <tr>
                <td>{{ app()->getLocale() == 'ar' ? $user->name : $user->name_en }}</td>
                <td>{{ $total }}</td>
                <td>{{ $paid }}</td>
                <td>{{ $total - $paid }}</td>
            </tr>
        @endforeach
        </tbody>
    @elseif($user == 'supplier' && $type == 'detailed')
        @if(!empty($id) && $id != 0)
            @php $suppliers = App\PermissionReceiving::where(['supplier_id' => $id,'org_id' => Auth::user()->org_id])->groupBy('supplier_id')->get(); @endphp
        @else
            @php $suppliers = App\PermissionReceiving::where(['org_id' => Auth::user()->org_id])->groupBy('supplier_id')->get(); @endphp
        @endif
        @foreach($suppliers as $v)
        <thead>
            <tr>
                <th>{{ app()->getLocale() == 'ar' ? App\Suppliers::findOrFail($v->supplier_id)->name : App\Suppliers::findOrFail($v->supplier_id)->name_en }}</th>
            </tr>

            <tr>
                <th>{{ __('strings.invoice_id') }}</th>
                <th>{{ __('strings.invoice_date') }}</th>
                <th>{{ __('strings.Employee') }}</th>
                <th>{{ __('strings.total_invoice') }}</th>
                <th>{{ __('strings.total_paid') }}</th>
                <th>{{ __('strings.Paid') }}</th>
                <th>{{ __('strings.Refund') }}</th>
                <th>{{ __('strings.Remaining') }}</th>
                <th>{{ __('strings.Status') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach($list->where('supplier_id', $v->supplier_id) as $value)
                @php
                    $total = 0; $paid = 0;
                    foreach (App\Transactions::where(['permission_receiving_id' => $value->id])->get() as $va){
                        $total += $va->price * $va->quantity * $va->req_flag;
                    }
                    $remaining = $total + $value->other_payment - (App\PermissionReceivingPayments::where(['permission_receiving_id' => $value->id, 'pay_flag' => -1])->sum('pay_amount') - App\PermissionReceivingPayments::where(['permission_receiving_id' => $value->id, 'pay_flag' => 1])->sum('pay_amount'));
                @endphp

                <tr>
                    <td>{{ $value->supp_invoice_no }}</td>
                    <td>{{ $value->supp_invoice_dt }}</td>
                    <td>{{ app()->getLocale() == 'ar' ? App\User::findOrFail($value->user_id)->name : App\User::findOrFail($value->user_id)->name_en }}</td>
                    <td>{{ $total }}</td>
                    <td>{{ $total + $value->other_payment }}</td>
                    <td>{{ App\PermissionReceivingPayments::where(['permission_receiving_id' => $value->id, 'pay_flag' => -1])->sum('pay_amount') }} </td>
                    <td>{{ App\PermissionReceivingPayments::where(['permission_receiving_id' => $value->id, 'pay_flag' => 1])->sum('pay_amount') }} </td>
                    <td>{{ $remaining }}</td>
                    <td>@if($remaining == 0) @lang('strings.transactions_status_1')  @elseif($remaining == $total + $value->other_payment) @lang('strings.transactions_status_3') @elseif($remaining < 0) @lang('strings.transactions_status_2') @elseif($remaining > 0) @lang('strings.transactions_status_4') @endif</td>
                </tr>
            @endforeach
        </tbody>

        @endforeach



    @elseif($user == 'employee' && $type == 'total')
        <thead>
            <tr>
                <th>{{ __('strings.Name') }}</th>
                <th>{{ __('strings.Total') }}</th>
                <th>{{ __('strings.Paid') }}</th>
                <th>{{ __('strings.Remaining') }}</th>
            </tr>
        </thead>

        <tbody>
        @foreach($list as $value)

            @php
                $user = App\User::findOrFail($value->user_id);
                $total = 0; $paid = 0;

                if($date_from != null && $date_to == null){
                    foreach (App\PermissionReceiving::where(['user_id' => $value->user_id, 'supp_invoice_dt' => $date_from])->get() as $vv) {
                        foreach (App\Transactions::where(['permission_receiving_id' => $vv->id])->get() as $va) {
                            $total += $va->price * $va->quantity * $va->req_flag;
                        }
                        $paid += App\PermissionReceivingPayments::where(['permission_receiving_id' => $vv->id,'user_id' => $value->user_id, 'pay_flag' => -1])->sum('pay_amount');
                        $total += $vv->other_payment;
                    }
                }elseif($date_to != null && $date_from == null){

                    foreach (App\PermissionReceiving::where(['user_id' => $value->user_id, 'supp_invoice_dt' => $date_to])->get() as $vv) {
                        foreach (App\Transactions::where(['permission_receiving_id' => $vv->id])->get() as $va) {
                            $total += $va->price * $va->quantity * $va->req_flag;
                        }
                        $paid += App\PermissionReceivingPayments::where(['permission_receiving_id' => $vv->id,'user_id' => $value->user_id, 'pay_flag' => -1])->sum('pay_amount');
                        $total += $vv->other_payment;
                    }
                }elseif ($date_from != null && $date_to != null){
                    foreach (App\PermissionReceiving::where(['user_id' => $value->user_id])->whereBetween('supp_invoice_dt', [$date_to, $date_from])->get() as $vv) {
                        foreach (App\Transactions::where(['permission_receiving_id' => $vv->id])->get() as $va) {
                            $total += $va->price * $va->quantity * $va->req_flag;
                        }
                        $paid += App\PermissionReceivingPayments::where(['permission_receiving_id' => $vv->id,'user_id' => $value->user_id, 'pay_flag' => -1])->sum('pay_amount');
                        $total += $vv->other_payment;
                    }
                }elseif ($date_from == null && $date_to == null){
                    foreach (App\PermissionReceiving::where(['user_id' => $value->user_id])->get() as $vv) {
                        foreach (App\Transactions::where(['permission_receiving_id' => $vv->id])->get() as $va) {
                            $total += $va->price * $va->quantity * $va->req_flag;
                        }
                        $paid += App\PermissionReceivingPayments::where(['permission_receiving_id' => $vv->id,'user_id' => $value->user_id, 'pay_flag' => -1])->sum('pay_amount');
                        $total += $vv->other_payment;
                    }
                }else{
                    foreach (App\PermissionReceiving::where(['user_id' => $value->user_id])->get() as $vv) {
                        foreach (App\Transactions::where(['permission_receiving_id' => $vv->id])->get() as $va) {
                            $total += $va->price * $va->quantity * $va->req_flag;
                        }
                        $paid += App\PermissionReceivingPayments::where(['permission_receiving_id' => $vv->id,'user_id' => $value->user_id, 'pay_flag' => -1])->sum('pay_amount');
                        $total += $vv->other_payment;
                    }
                }
            @endphp

            <tr>
                <td>{{ app()->getLocale() == 'ar' ? $user->name : $user->name_en }}</td>
                <td>{{ $total }}</td>
                <td>{{ $paid }}</td>
                <td>{{ $total - $paid }}</td>
            </tr>
        @endforeach
        </tbody>
    @elseif($user == 'employee' && $type == 'detailed')
        @if(!empty($id) && $id != 0)
            @php $suppliers = App\PermissionReceiving::where(['user_id' => $id,'org_id' => Auth::user()->org_id])->groupBy('user_id')->get(); @endphp
        @else
            @php $suppliers = App\PermissionReceiving::where(['org_id' => Auth::user()->org_id])->groupBy('user_id')->get(); @endphp
        @endif
        @foreach($suppliers as $v)
            <thead>
            <tr>
                <th>{{ app()->getLocale() == 'ar' ? App\User::findOrFail($v->user_id)->name : App\User::findOrFail($v->user_id)->name_en }}</th>
            </tr>

            <tr>
                <th>{{ __('strings.invoice_id') }}</th>
                <th>{{ __('strings.invoice_date') }}</th>
                <th>{{ __('strings.Employee') }}</th>
                <th>{{ __('strings.total_invoice') }}</th>
                <th>{{ __('strings.total_paid') }}</th>
                <th>{{ __('strings.Paid') }}</th>
                <th>{{ __('strings.Refund') }}</th>
                <th>{{ __('strings.Remaining') }}</th>
                <th>{{ __('strings.Status') }}</th>
            </tr>
            </thead>

            <tbody>
            @foreach($list->where('user_id', $v->user_id) as $value)
                @php
                    $total = 0; $paid = 0;
                    foreach (App\Transactions::where(['permission_receiving_id' => $value->id])->get() as $va){
                        $total += $va->price * $va->quantity * $va->req_flag;
                    }
                    $remaining = $total + $value->other_payment - (App\PermissionReceivingPayments::where(['permission_receiving_id' => $value->id, 'pay_flag' => -1])->sum('pay_amount') - App\PermissionReceivingPayments::where(['permission_receiving_id' => $value->id, 'pay_flag' => 1])->sum('pay_amount'));
                @endphp

                <tr>
                    <td>{{ $value->supp_invoice_no }}</td>
                    <td>{{ $value->supp_invoice_dt }}</td>
                    <td>{{ app()->getLocale() == 'ar' ? App\User::findOrFail($value->user_id)->name : App\User::findOrFail($value->user_id)->name_en }}</td>
                    <td>{{ $total }}</td>
                    <td>{{ $total + $value->other_payment }}</td>
                    <td>{{ App\PermissionReceivingPayments::where(['permission_receiving_id' => $value->id, 'pay_flag' => -1])->sum('pay_amount') }} </td>
                    <td>{{ App\PermissionReceivingPayments::where(['permission_receiving_id' => $value->id, 'pay_flag' => 1])->sum('pay_amount') }} </td>
                    <td>{{ $remaining }}</td>
                    <td>@if($remaining == 0) @lang('strings.transactions_status_1')  @elseif($remaining == $total + $value->other_payment) @lang('strings.transactions_status_3') @elseif($remaining < 0) @lang('strings.transactions_status_2') @elseif($remaining > 0) @lang('strings.transactions_status_4') @endif</td>
                </tr>
            @endforeach
            </tbody>

        @endforeach

    @endif
</table>
