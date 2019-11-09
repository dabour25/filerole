@php
use Carbon\Carbon;
@endphp
@extends('layouts.admin', ['title' => __('strings.external_req_confirm')])
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
  <!-- close reguest -->
  <div id="close_reguest" class="modal fade newModel" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
          <form action="{{ Route('doneReq') }}" method="POST">
            @csrf
              <div class="modal-body">
                  <div class="row">
                      <div class="col-xs-12 form-group">
                          <label class="control-label">{{ __('strings.external_req_res_user') }} </label>
                          <input type="text" placeholder="اسم" name="resopnsible" class="form-control">
                          <input type="hidden"  class="form-control" name="req_id" id="req_id_Confirm">
                          <input type="hidden"  class="form-control" name="cust_id" id="cust_id">
                      </div>
                      <div class="col-xs-12 form-group">
                          <label class="control-label"> {{ __('strings.external_req_delivRes') }}  </label>
                          <input type="text" placeholder="" id="emp" class="form-control" disabled>
                      </div>

                      <div class="col-xs-12 form-group">
                          <label class="control-label"> {{ __('strings.external_req_collectAmount') }}  </label>
                          <input type="text" id="total" class="form-control" disabled>
                      </div>
                      <div class="col-xs-12 form-group " id="bankSelect">
                        <label class="control-label"> {{ __('strings.external_req_payment') }}  </label>
                        <select class="form-control" name="bank_id" id="selectId">
                          @foreach ($bank as $key)
                            <option value="{{ $key->id }}" {{ $key->default == 1 ? 'selected' : '' }}>{{ app()->getLocale() == 'ar' ? $key->name : $key->name_en }}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>
            </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> {{ __('strings.external_req_save') }} </button>
              <button type="button" class="btn btn-primary btn-default" data-dismiss="modal"><i class="fas fa-times"></i> {{ __('strings.external_req_close') }} </button>
            </div>
          </form>
      </div>

    </div>
  </div>


      <div >

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
                          <h4 class="panel-title"> {{ __('strings.external_req_search_req') }}   </h4>
                      </div>
                      <div class="panel-body">
                        <form action="{{ Route('search_cust_req') }}" id="serachExternalReqForm">
                            <div class="col-md-4 col-xs-12 form-group">
                                <label class="control-label">{{ __('strings.external_req_status') }} </label>
                                <select class="form-control" name="type">
                                    <option style="display:none" value="y" {{ $oldData && $oldData['type'] == 'y'? 'selected' :''}}></option>
                                    <option value="0" {{ $oldData && $oldData['type'] == '0'? 'selected' :'' }}>{{ __('strings.All') }}</option>
                                    <option value="p" {{ $oldData && $oldData['type'] == 'p'? 'selected':'' }}>{{ __('strings.external_req_basket') }}</option>
                                    <option value="n" {{ $oldData && $oldData['type'] == 'n'? 'selected' :''}}>{{ __('strings.external_req_wait') }} </option>
                                    <option value="y" {{ $oldData && $oldData['type'] == 'y'? 'selected':'' }}>{{ __('strings.external_req_confirm') }} </option>
                                    <option value="c" {{ $oldData && $oldData['type'] == 'c'? 'selected' :''}}>{{ __('strings.external_req_cancel') }} </option>
                                    <option value="d" {{ $oldData && $oldData['type'] == 'd'? 'selected' :''}}> {{ __('strings.external_req_done') }} </option>
                                </select>
                            </div>

                            <div class="col-md-4 col-xs-12 form-group">
                                <label class="control-label" >{{ __('strings.external_req_date_form') }} </label>
                                <input type="date" class="form-control" name="date_from" value="{{ $oldData     ? $oldData['date_from']  :'' }}">
                            </div>
                            <div class="col-md-4 col-xs-12 form-group">
                                <label class="control-label">{{ __('strings.external_req_date_to') }} </label>
                                <input type="date" class="form-control" name="date_to" value="{{ $oldData ? $oldData['date_to']  :'' }}">
                            </div>
                            <div class="col-md-4 col-xs-12 form-group">
                                <label class="control-label">{{ __('strings.external_req_cust_name') }} </label>

                                <select class="form-control" name="cust_id">
                                  <option value="" selected>{{ __('strings.external_req_all') }} </option>
                                    @foreach ($customersSelect as $cust)
                                      <option value="{{ $cust->id }}" {{ $oldData && $oldData['cust_id'] ==  $cust->id ? 'selected' :''}}>{{ app()->getLocale() == 'ar' ? $cust->name : $cust->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-xs-12 form-group">
                                <label class="control-label">{{ __('strings.external_req_invoice_code') }} </label>
                                <input type="number" class="form-control" name="invoice_no" value="{{ $oldData  ? $oldData['invoice_no']  :'' }}">
                            </div>

                            <div class="submitBtnSearch col-md-12  text-left">
                              <button type="submit" class="btn btn-primary"   >{{ __('strings.external_req_search') }} </button>
                            </div>
                        </form>
                      </div>
                  </div>

                  <div class="panel panel-white">
                      <div class="panel-heading clearfix">
                          <h4 class="panel-title">{{ __('strings.external_req_confirm') }} </h4>
                      </div>
                      <div class="panel-body">
                          <table id="xtreme-table" class="table table-striped table-bordered" style="width:100%">
                                  <thead>
                                      <tr>
                                          <th>{{ __('strings.external_req_reqNum') }} </th>
                                          <th>{{ __('strings.external_req_invoice_code') }} </th>
                                          <th>{{ __('strings.external_req_cust_name') }} </th>
                                          <th>{{ __('strings.external_req_tel') }} </th>
                                          <th>{{ __('strings.external_req_dateReq') }} </th>
                                          <th>{{ __('strings.external_req_total') }} </th>
                                          <th>{{ __('strings.delivery_fees') }}   </th>
                                          <th>{{ __('strings.external_req_delivRes') }} </th>
                                          <th>{{ __('strings.external_req_status') }} </th>
                                          <th>{{ __('strings.external_req_setting') }} </th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($items as $confirmReq)
                                      @php
                                          //$req_trans = DB::select('SELECT  * sum(quantity * reg_flag * final_price) AS price  FROM `external_trans` WHERE  org_id = '.Auth::user()->org_id.' AND cust_id = '.$confirmReq->Customer->id .' AND external_req_id = '.$confirmReq->id) ;
                                          $req_trans = App\externalTrans::where(['org_id' => Auth::user()->org_id, 'cust_id' => $confirmReq->Customer->id, 'external_req_id' => $confirmReq->id])->sum(\DB::raw('quantity * reg_flag * final_price'));
                                          $date_temp = DB::table('settings')->where('org_id',Auth::user()->org_id)->where('key','date')->first();
                                          $num_temp  = DB::table('settings')->where('org_id',Auth::user()->org_id)->where('key','decimal_place')->first();
                                          $emp_deliv = DB::table('users')->where('org_id',Auth::user()->org_id)->where('id',$confirmReq->emp_id)->first();
                                      @endphp
                                    <tr>
                                      <td>{{ $confirmReq->id }}</td>
                                      <td>{{ $confirmReq->invoice_code }}</td>
                                      <td>{{ app()->getLocale() == 'ar' ?  $confirmReq->Customer->name : $confirmReq->Customer->name_en }}</td>
                                      <td>{{$confirmReq->telephone}}</td>
                                      <td>{{ date("$date_temp->value",strtotime($confirmReq->request_dt) )  }}</td>
                                      <td>{{ Decimalplace(abs($req_trans[0]->price) + abs($confirmReq->delivery_fees)) }}</td>
                                      <td>{{ $confirmReq->delivery_fees }}</td>
                                      <td>{{ app()->getLocale() == 'ar' ? $emp_deliv->name : $emp_deliv->name_en }}</td>
                                      <td>
                                        @if ($confirmReq->confirm == 'y' || $confirmReq->confirm == 'yx')
                                           {{ __('strings.external_req_done_req') }}
                                        @endif
                                      </td>
                                      <td>
                                          <div class="buttons_tabel">
                                              <button type="button" class="btn btn-primary btn-close-regust" data-toggle="modal" data-target="#close_reguest" data-req="{{ $confirmReq->id }}" data-cust="{{ $confirmReq->cust_id }}" data-emp="{{ $emp_deliv->name }}" data-total="{{ abs($req_trans[0]->price ) + abs($confirmReq->delivery_fees) }}" data-status="{{ $confirmReq->confirm }}">
                                                {{ __('strings.external_req_responsible') }}

                                              </button>
                                            @if ($confirmReq->confirm == 'y')
                                                <a href="{{ Route('showReq',$confirmReq->id) }}"><button type="button" class="btn btn-primary btn-Show-regust" >عرض</button></a>
                                            @endif
                                            <a href="{{ Route('externalTransPrint',$confirmReq->id) }}"><button type="button" class="btn btn-primary btn-Show-regust" >طباعة</button></a>

                                          </div>
                                      </td>
                                    </tr>
                                  @endforeach

                                  </tbody>
                              </table>
                      </div>
                  </div>

              </div>
          </div>
      </div>

      <!-- Main Wrapper -->

      </div>






@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>


<script>
  $(document).ready(function() {
    $('#close_reguest').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var req = button.data('req') // Extract info from data-* attributes
    var cust_id = button.data('cust') // Extract info from data-* attributes
    var total = button.data('total') // Extract info from data-* attributes
    var emp = button.data('emp') // Extract info from data-* attributes
    var status = button.data('status') // Extract info from data-* attributes
    // console.log()
    if (status == 'yx') {
      $('#bankSelect').hide();
      $('#selectId').attr('disabled',true);
      $('#selectId').attr('name','online_bank');
    }else{
      $('#bankSelect').show();
      $('#selectId').attr('disabled',false);
      $('#selectId').attr('name','bank_id');

    }
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-body #req_id_Confirm').val(req)
    modal.find('.modal-body #cust_id').val(cust_id)
    modal.find('.modal-body #total').val(total)
    modal.find('.modal-body #emp').val(emp)
});
  });
  document.getElementById('serachExternalReqForm').addEventListener('keypress', function(event) {
      if (event.keyCode == 13) {
          $("#serachExternalReqForm").submit()
      }
  });
</script>


@endsection
@endsection
