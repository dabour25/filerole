@php
use Carbon\Carbon;
@endphp
@extends('layouts.admin', ['title' => __('strings.external_req_cancel')])
@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<style>
    .buttons_tabel button {
        display: inline-block;
        width: auto;
        margin: 0 0 0 5px;
        padding: 5px 15px;
        border-radius: 3px;
    }
    .buttons_tabel .btn-close-regust {
        background: #e20e0e;
    }
    .buttons_tabel .btn-close-regust2 {
        color: #e20e0e;
    }
    #myRadioGroup .input-group {
        display: inline-block;
        width: auto;
        overflow: hidden;
        margin: 0 0 10px 50px;
    }
    #myRadioGroup .input-group label {
        display: inline-block;
        width: auto;
        margin: 0 0 15px 0;
    }
    #myRadioGroup .input-group input {
        float: right;
        margin: 4px 0 0 10px;
    }
    form label {
    font-size: 13px;
    font-weight: 400;
    }
    textarea {
        padding: 15px !important;
    }
    .btn-Show-regust {
        background: #007bff;
    }
    .modal-footer .btn-default {
        padding: 8px 55px 8px 40px;
        margin-right:10px;
        background: #e20e0e;
    }
    .modal-footer .btn-default:hover {
        background: #e20e0e !important;
    }
    .modal-footer .btn-default i {
        background: #b50c0c;
    }
</style>
@endsection
@section('content')



<div>

  <div id="main-wrapper">
    @if (session()->has('successMsg'))
      <div class="alert alert-success">
        {{ session()->get('successMsg') }}
      </div>
    @endif
    <div class="row">
      <div class="col-md-12">
        <div class="alert_new">
          <span class="alertIcon">
            <i class="fas fa-exclamation-circle"></i>
          </span>
          <p>
            هنا يمكنك تسجيل بيانات المنتجات / الخدمات التى تتعامل فيها منشاتك
          </p>
          <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i> </a>
        </div>

        <div class="panel panel-white">
          <div class="panel-heading clearfix">
            <h4 class="panel-title">{{ __('strings.external_req_search_req') }}</h4>
          </div>
          <div class="panel-body">
            <form action="{{ Route('search_cust_req') }}" id="serachExternalReqForm">
                <div class="col-md-4 col-xs-12 form-group">
                    <label class="control-label">{{ __('strings.external_req_status') }}</label>
                    <select class="form-control" name="type">
                        <option style="display:none" value="c" {{ $oldData && $oldData['type'] == 'c'? 'selected' :'' }}></option>
                        <option value="0" {{ $oldData && $oldData['type'] == '0'? 'selected' :'' }}>{{ __('strings.All') }}</option>
                        <option value="p" {{ $oldData && $oldData['type'] == 'p'? 'selected':'' }}>{{ __('strings.external_req_basket') }}</option>
                        <option value="n" {{ $oldData && $oldData['type'] == 'n'? 'selected' :''}}> {{ __('strings.external_req_wait') }}</option>
                        <option value="y" {{ $oldData && $oldData['type'] == 'y'? 'selected':'' }}>{{ __('strings.external_req_confirm') }}</option>
                        <option value="c" {{ $oldData && $oldData['type'] == 'c'? 'selected' :''}}>{{ __('strings.external_req_cancel') }}</option>
                        <option value="d" {{ $oldData && $oldData['type'] == 'd'? 'selected':'' }}>{{ __('strings.external_req_done') }}</option>
                    </select>
                </div>

                <div class="col-md-4 col-xs-12 form-group">
                    <label class="control-label" > {{ __('strings.external_req_date_form') }}</label>
                    <input type="date" class="form-control" name="date_from" value="{{ $oldData   ? $oldData['date_from'] :'' }}">
                </div>
                <div class="col-md-4 col-xs-12 form-group">
                    <label class="control-label"> {{ __('strings.external_req_date_to') }}</label>
                    <input type="date" class="form-control" name="date_to" value="{{ $oldData  ? $oldData['date_to']  :'' }}">
                </div>
                <div class="col-md-4 col-xs-12 form-group">
                    <label class="control-label"> {{ __('strings.external_req_cust_name') }}</label>

                    <select class="form-control" name="cust_id">
                      <option value="" selected> {{ __('strings.external_req_all') }}</option>
                        @foreach ($customersSelect as $cust)

                          <option value="{{ $cust->id }}" {{ $oldData && $oldData['cust_id'] ==  $cust->id ? 'selected' :''}}>{{ app()->getLocale() == 'ar' ? $cust->name : $cust->name_en }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 col-xs-12 form-group">
                    <label class="control-label"> {{ __('strings.external_req_invoice_code') }}</label>
                    <input type="number" class="form-control" name="invoice_no" value="{{ $oldData  ? $oldData['invoice_no']  :'' }}">
                </div>

                <div class="submitBtnSearch col-md-12 text-left">
                  <button type="submit" class="btn btn-primary"   > {{ __('strings.external_req_search') }}</button>
                </div>
            </form>
          </div>
        </div>
        <div class="panel panel-white">
          <div class="panel-heading clearfix">
            <h4 class="panel-title"> {{ __('strings.external_req_cancel') }}</h4>
          </div>
          <div class="panel-body">
            <table id="xtreme-table" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>{{ __('strings.external_req_reqNum') }}</th>
                  <th>{{ __('strings.external_req_invoice_code') }}</th>
                  <th>{{ __('strings.external_req_cust_name') }}</th>
                  <th>{{ __('strings.external_req_tel') }}</th>
                  <th>{{ __('strings.external_req_dateReq') }}</th>
                  <th>{{ __('strings.external_req_total') }}</th>
                  <th>{{ __('strings.external_req_reason') }}</th>
                  <th>{{ __('strings.external_req_cancellation') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $cancelReq)
                  @php
                  $req_trans = DB::select('SELECT sum(quantity * reg_flag * final_price)   AS price  FROM `external_trans` WHERE  org_id = '.Auth::user()->org_id.' AND cust_id = '.$cancelReq->Customer->id .' AND external_req_id = '.$cancelReq->id  );
                  $date_temp = DB::table('settings')->where('org_id',Auth::user()->org_id)->where('key','date')->first();
                  $num_temp = DB::table('settings')->where('org_id',Auth::user()->org_id)->where('key','decimal_place')->first();

                  @endphp
                <tr>
                  <td>{{ $cancelReq->id }}</td>
                  <td>{{ $cancelReq->invoice_code }}</td>
                  <td>{{ app()->getLocale() == 'ar' ?  $cancelReq->Customer->name : $cancelReq->Customer->name_en }}</td>
                  <td>{{$cancelReq->telephone}}</td>
                  <td>{{ date("$date_temp->value",strtotime($cancelReq->request_dt) ) }}</td>
                  <td>{{ abs($req_trans[0]->price)  }}</td>
                  <td>{{ $cancelReq->comment }}</td>
                  <td>{{  $cancelReq->updated_at  }}</td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>






@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<script>
document.getElementById('serachExternalReqForm').addEventListener('keypress', function(event) {
    if (event.keyCode == 13) {
        $("#serachExternalReqForm").submit()
    }
});
</script>



@endsection
@endsection
