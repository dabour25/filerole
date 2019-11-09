@php
use Carbon\Carbon;
@endphp
@extends('layouts.admin', ['title' => __('strings.external_req_wait')])
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
<!-- conform reguest -->
<div id="confirm_Req" class="modal fade newModel" role="dialog">
<div class="modal-dialog">
  <div class="modal-content">
    <form   action="{{ Route('confirm_req') }}" method="post">
    <div class="modal-body">
        @csrf
        <div id="myRadioGroup">
            <div class="input-group">
                <label>التوصيل للمنزل</label>
                <input type="radio" name="delev" checked="checked" value="2" />
                <input type="hidden" name="deliv_type"   value="customer" />

            </div>
            <div class="input-group">
                <label>التوصيل لمقر الشركة</label>
                <input type="radio" name="delev" value="3"  form="cofirmcompanyReq" />
            </div>

            <div id="delev2" class="desc">

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="control-label"> تكلفة التوصيل </label>
                            <input type="text" placeholder="XXX" name="delivery_price" class="form-control" required>
                        </div>

                        <div class="col-xs-6 form-group">
                          <label class="control-label">الموظف المسؤول عن التوصيل </label>
                            <select class="form-control employeeSelect" name="emp_id" required>
                              @foreach ($emp as $key)
                                <option value="{{ $key->id }}">{{ app()->getLocale() =='ar' ? $key->name :  $key->name_en }}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label"> التليفون </label>
                            <input type="tel" placeholder="01XXXXXXXX" name="cust_phone" class="form-control" required>
                            <input type="hidden" placeholder="01XXXXXXXX" name="cust_id" id="" class="form-control confirmCustId">
                            <input type="hidden" placeholder="01XXXXXXXX" name="req_id" id="" class="form-control req_id_confrim">
                            <input type="hidden" placeholder="01XXXXXXXX" name="payType" id="" class="form-control payType">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="control-label"> العنوان </label>
                            <input type="text" placeholder="cairo, egypt" name="cust_address" class="form-control" required>
                        </div>
                    </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> تأكيد</button>
                    <button type="button" class="btn btn-primary btn-default" data-dismiss="modal"><i class="fas fa-times"></i> أغلاق</button>
                  </div>

            </div>



        </div>
      </form>
        <form id="cofirmcompanyReq" action="{{ Route('confirm_req') }}" method="post">
          @csrf
          <div id="delev3" class="desc" style="display: none;">
                  <div class="row">
                      <div class="col-md-6 form-group">
                          <label class="control-label"> التليفون </label>
                          <input type="hidden" name="deliv_type" value="company" />
                          <input type="tel" placeholder="01XXXXXXXX" name="cust_phone" class="form-control" required>
                          <input type="hidden" placeholder="01XXXXXXXX" name="cust_id" id="" class="form-control confirmCustId">
                          <input type="hidden" placeholder="01XXXXXXXX" name="payType" id="" class="form-control payType">
                          <input type="hidden" placeholder="01XXXXXXXX" name="req_id" id="" class="form-control req_id_confrim">
                      </div>
                  </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> تأكيد</button>
                      <button type="button" class="btn btn-primary btn-default" data-dismiss="modal"><i class="fas fa-times"></i> أغلاق</button>
                    </div>
          </div>
        </form>

    </div>
  </div>

</div>
</div>

<!-- close reguest -->
<div id="close_reguest" class="modal fade newModel" role="dialog">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-body">
      <form  action="{{ Route('cancel_req') }}" method="post">
        @csrf
          <div class="row">
              <div class="col-xs-12 form-group">
                  <label class="control-label"> سبب الإلغاء </label>
                  <input type="hidden" name="Req_id" id="request_id"  >
                  <input type="hidden" name="dataUser" id="dataUser"  >
                  <textarea type="text" placeholder="رسالة"  name="cancel_req_re" class="form-control" required></textarea>
              </div>
          </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary"  ><i class="fas fa-check-circle"></i>حفظ</button>
              <button type="button" class="btn btn-primary btn-default"  data-dismiss="modal"><i class="fas fa-times"></i> أغلاق</button>
            </div>
      </form>
    </div>
  </div>

</div>
</div>

<!-- show reguest -->
<div id="show_reguest" class="modal fade newModel" role="dialog">
<div class="modal-dialog" style="width:70%">
  <div class="modal-content">
    <div class="modal-body">
        <form>
      <table id="xtreme-table" class="table table-striped table-bordered" style="width:100%">
              <thead>
                  <tr>
                       <th> البند </th>
                       <th> الكمية </th>
                       <th> سعر الوحدة </th>
                       <th> الضريبة </th>
                       <th> الإجمالي </th>
                       <th> إلغاء </th>

                  </tr>
              </thead>
              <tbody id="clonetr">

              </tbody>
          </table>
          <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="addRow"><i class="fas fa-plus"></i> إضافة بند </button>
              <button type="button" class="btn btn-primary"><i class="fas fa-check-circle"></i> حفظ </button>
              <button type="button" class="btn btn-primary btn-default" data-dismiss="modal"><i class="fas fa-times"></i> أغلاق</button>
          </div>
        </form>
    </div>
  </div>

</div>
</div>

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
                 نا يمكنك   استعراض الطلبات الخارجية التى طلبها العميل عن طلريق واجهة التطبيق. ومتابعةتها فى كل المراحل منذ الاضافة بالسلة حتى التنفيذ والتسليم النهائ
                 
              </p>
              <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i> </a>
            </div>
              <div class="panel panel-white">
                  <div class="panel-heading clearfix">
                      <h4 class="panel-title"> {{ __('strings.external_req_search_req') }} </h4>
                  </div>
                  <div class="panel-body">
                      <form action="{{ Route('search_cust_req') }}" id="serachExternalReqForm">
                          <div class="col-md-4 col-xs-12 form-group">
                              <label class="control-label"> {{ __('strings.external_req_status') }} </label>

                              <select class="form-control" name="type">
                                  <option style="display:none" value="n" {{ $oldData && $oldData['type'] == 'n'? 'selected' :'' }}></option>
                                  <option value="0" {{ $oldData && $oldData['type'] == '0'? 'selected' :'' }}>{{ __('strings.select_all') }}</option>
                                  <option value="p" {{ $oldData && $oldData['type'] == 'p'? 'selected':'' }}>{{ __('strings.external_req_basket') }}</option>
                                  <option value="n" {{ $oldData && $oldData['type'] == 'n'? 'selected' :''}}> {{ __('strings.external_req_wait') }} </option>
                                  <option value="y" {{ $oldData && $oldData['type'] == 'y'? 'selected' :''}}> {{ __('strings.external_req_confirm') }} </option>
                                  <option value="c" {{ $oldData && $oldData['type'] == 'c'? 'selected':'' }}> {{ __('strings.external_req_cancel') }} </option>
                                  <option value="d" {{ $oldData && $oldData['type'] == 'd'? 'selected':'' }}> {{ __('strings.external_req_done') }} </option>
                              </select>
                          </div>

                          <div class="col-md-4 col-xs-12 form-group">
                              <label class="control-label" > {{ __('strings.external_req_date_form') }} </label>
                              <input type="date" class="form-control" name="date_from" value="{{ $oldData  ? $oldData['date_from'] :'' }}">
                          </div>
                          <div class="col-md-4 col-xs-12 form-group">
                              <label class="control-label"> {{ __('strings.external_req_date_to') }} </label>
                              <input type="date" class="form-control" name="date_to" value="{{ $oldData  ?  $oldData['date_to']  :'' }}">
                          </div>
                          <div class="col-md-4 col-xs-12 form-group">
                              <label class="control-label"> {{ __('strings.external_req_cust_name') }} </label>

                              <select class="form-control" name="cust_id">
                                <option value="" selected> {{ __('strings.external_req_all') }} </option>
                                  @foreach ($customersSelect as $cust)

                                    <option value="{{ $cust->id }}" {{ $oldData && $oldData['cust_id'] ==  $cust->id ? 'selected' :''}}>{{ app()->getLocale() == 'ar' ? $cust->name : $cust->name_en }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-md-4 col-xs-12 form-group">
                              <label class="control-label"> {{ __('strings.external_req_invoice_code') }} </label>
                              <input type="number" class="form-control" name="invoice_no" value="{{ $oldData  ? $oldData['invoice_no']  :'' }}">
                          </div>
                          <div class="submitBtnSearch col-md-12 text-left">
                            <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> {{ __('strings.external_req_search') }} </button>
                          </div>
                      </form>
                  </div>
              </div>
              <div class="panel panel-white">
                  <div class="panel-heading clearfix">
                      <h4 class="panel-title">الطلبات قيد الإنتظار</h4>
                  </div>
                  <div class="panel-body">
                      <table id="xtreme-table" class="table table-striped table-bordered" style="width:100%">
                              <thead>
                                  <tr>
                                      <th> {{ __('strings.external_req_reqNum') }} </th>
                                      <th> {{ __('strings.external_req_invoice_code') }} </th>
                                      <th> {{ __('strings.external_req_cust_name') }} </th>
                                      <th> {{ __('strings.external_req_tel') }} </th>
                                      <th> {{ __('strings.external_req_dateReq') }} </th>
                                      <th> {{ __('strings.external_req_total') }} </th>
                                      <th> {{ __('strings.external_req_setting') }} </th>
                                  </tr>
                              </thead>
                              <tbody>

                                @foreach ($items as $cust_req)
                                  @php
                                  $req_trans = DB::select('SELECT sum(quantity * reg_flag * final_price)    AS price  FROM `external_trans` WHERE  org_id = '.Auth::user()->org_id.' AND cust_id = '.$cust_req->Customer->id .' AND external_req_id = '.$cust_req->id) ;
                                  $date_temp = DB::table('settings')->where('org_id',Auth::user()->org_id)->where('key','date')->first();
                                  $num_temp = DB::table('settings')->where('org_id',Auth::user()->org_id)->where('key','decimal_place')->first();
                                @endphp
                                  <tr>
                                      <td>{{$cust_req->id}}</td>
                                      <td>{{$cust_req->invoice_code}}</td>
                                      <td>{{ app()->getLocale() == 'ar' ?  $cust_req->Customer->name : $cust_req->Customer->name_en }}</td>
                                      <td>{{$cust_req->telephone}}</td>
                                      <td>{{ date("$date_temp->value",strtotime($cust_req->request_dt) )}}</td>
                                      <td>{{ Decimalplace(abs($req_trans[0]->price) + abs($cust_req->delivery_fees))}}</td>
                                      <td>{{ $cust_req->confirm == 'n' ? __('strings.external_req_delivTypeN')  : __('strings.external_req_delivTypeX')}}</td>
                                      <td>
                                          <div class="buttons_tabel">
                                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirm_Req"  data-req="{{ $cust_req->id }}" data-cust="{{ $cust_req->cust_id }}" data-type="{{ $cust_req->confirm}}"> {{ __('strings.external_req_confirmation') }} </button>
                                              @if ($cust_req->confirm == 'n')
                                                <a href="{{ Route('showReq',$cust_req->id) }}"><button type="button" class="btn btn-primary btn-Show-regust" >عرض</button></a>
                                                <button type="button" class="btn btn-primary btn-close-regust" data-toggle="modal" data-target="#close_reguest" data-req="{{ $cust_req->id }}" data-user="{{ $cust_req->cust_id }}" >
                                                     {{ __('strings.external_req_cancellation') }}
                                                </button>
                                              @endif
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

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('#close_reguest').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('req') // Extract info from data-* attributes
    var dataUser = button.data('user') // Extract info from data-* attributes
    // console.log()

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-title').text('New message to ' + recipient)
    modal.find('.modal-body #request_id').val(recipient)
    modal.find('.modal-body #dataUser').val(dataUser)
});
    $('#confirm_Req').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('cust') // Extract info from data-* attributes
    var req = button.data('req') // Extract info from data-* attributes
    var payType = button.data('type') // Extract info from data-* attributes
    // console.log()

    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.modal-body .confirmCustId').val(recipient)
    modal.find('.modal-body .req_id_confrim').val(req)
    modal.find('.modal-body .payType').val(payType)
});
//     $('#show_reguest').on('show.bs.modal', function (event) {
//     var button = $(event.relatedTarget) // Button that triggered the modal
//     var recipient = button.data('requests') // Extract info from data-* attributes
//     var data =[];
//     for (var i = 0; i < recipient.length; i++) {
//       console.log(recipient[i]['catName']);
//
//        data += `
//       <tr id="firsttr">
//           <td>`+recipient[i]['catName']+`</td>
//           <td>14</td>
//           <td>ِ155 S.R</td>
//           <td>+55 S.R</td>
//           <td>210 S.R</td>
//           <td>
//               <div class="buttons_tabel">
//                   <button type="button" class="btn btn-defult btn-close-regust2" id="deltr">
//                       <i class="fas fa-times"></i>
//                   </button>
//               </div>
//           </td>
//       </tr>
//
//
//       `
//     }
//     $('#clonetr').html(data)
//
//
//     // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
//     // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
//     var modal = $(this)
//
// });

  });

</script>


<script>
$(document).ready(function() {
    $("input[name$='delev']").click(function() {
        var test = $(this).val();
        $("div.desc").hide();
        $("#delev" + test).show();
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
