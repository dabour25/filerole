@php
use Carbon\Carbon;
@endphp
@extends('layouts.admin', ['title' => __('strings.external_req_wait_show')])
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
    margin-right: 10px;
    background: #e20e0e;
  }

  .modal-footer .btn-default:hover {
    background: #e20e0e !important;
  }

  .modal-footer .btn-default i {
    background: #b50c0c;
  }
  .loginRole{
    width: 40%;
    margin:auto;

  }
  .loginRole .login100-form{
    padding : 0;
    padding: 20px;
    margin : 0;
  }
  .loginRole .card{
    height:auto;
  }
  .loginRole .login100-form-title{
    color : #000;
    padding : 0;
    margin : 0;
    font-size: 18px;
    margin-bottom: 10px;
  }
</style>
<script>

function calcTotal(thisBtn) {
  var total = 0,reg_1 = 0,reg = 0;
  var total1 = 0;

    $(".fPrice span").each(function() {
      reg += parseFloat($(this).text()); //return
    });
    $(".fprice_1 span").each(function() {
      reg_1 += parseFloat($(this).text()); //ex
    });
    if (thisBtn.parents('tr').find('.reg_flagg select').val()  == -1) {
      total =  reg_1  - reg ; //ex
    }
    else if (thisBtn.parents('tr').find('.reg_flagg select').val()  == 1) {
      total =   reg_1 -  reg; //Return
    }
    $('.finalTotalPrice').text(total.toFixed(2));

}
</script>
@endsection
@section('content')
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
                              <select class="form-control" name="emp_id" required>
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
                            <input type="hidden" placeholder="01XXXXXXXX" name="req_id" id="" class="form-control req_id_confrim">
                            <input type="hidden" placeholder="01XXXXXXXX" name="payType" id="" class="form-control payType">
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
            <h4 class="panel-title">  {{ __('strings.external_req_search_req') }}   </h4>
            <span id="request_id_span" style="display:none;"><input value="{{ $items->id }}" ></span>
          </div>
            @if (!$role)
            @if ($items->confirm == 'n' || $items->confirm == 'y')
              <div class="col-12 text-center loginRole">
              <p>
                <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                   {{ __('strings.external_req_login') }}
                </a>

              </p>
              <div class="collapse" id="collapseExample">
                <div class="card card-body">
                  <form id="loginFormValidate" class="login100-form validate-form" method="post" action="{{ route('adminConfirm') }}">
      			    @csrf
      				<span class="login100-form-title">
                تسجيل الدخول
              </span>



      				<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
      					<input class="input100" type="text" name="email" id="emailValidate" placeholder="Email" value="{{ old('email') }}">
      					<span class="focus-input100"></span>
      					<span class="symbol-input100">
      						<i class="fa fa-envelope" aria-hidden="true"></i>
      					</span>
      				</div>

      				<div class="wrap-input100 validate-input" data-validate = "Password is required">
      					<input class="input100" type="password" id="passValidate" name="password" placeholder="Password">
      					<span class="focus-input100"></span>
      					<span class="symbol-input100">
      						<i class="fa fa-lock" aria-hidden="true"></i>
      					</span>
      				</div>

      				<div class="container-login100-form-btn">
      					<button class="login100-form-btn">
      						Login
      					</button>
      				</div>
      			</form>
                </div>
              </div>
            </div>
            @endif
            @endif
          <div class="panel-body">
            <form id="newRequests" action="{{ Route('addNewRequests') }}" method="post" enctype="multipart/form-data">
              @csrf
            </form>
            <form action="{{ Route('search_cust_req') }}" id="serachExternalReqForm">
                <div class="col-md-4 col-xs-12 form-group">
                    <label class="control-label"> {{ __('strings.external_req_status') }} </label>

                    <select class="form-control" name="type">
                        <option style="display:none" value="n" {{ $oldData && $oldData['type'] == 'n'? 'selected' :'' }}></option>
                        <option value="0" {{ $oldData && $oldData['type'] == '0'? 'selected' :'' }}>{{ __('strings.external_req_all') }}</option>
                        <option value="n" {{ $oldData && $oldData['type'] == 'n'? 'selected' :''}}> {{ __('strings.external_req_wait') }} </option>
                        <option value="y" {{ $oldData && $oldData['type'] == 'y'? 'selected' :''}}> {{ __('strings.external_req_confirm') }} </option>
                        <option value="c" {{ $oldData && $oldData['type'] == 'c'? 'selected':'' }}> {{ __('strings.external_req_cancel') }} </option>
                        <option value="d" {{ $oldData && $oldData['type'] == 'd'? 'selected':'' }}> {{ __('strings.external_req_done') }} </option>
                        <option value="p" {{ $oldData && $oldData['type'] == 'p'? 'selected':'' }}>{{ __('strings.external_req_basket') }}</option>
                    </select>
                </div>

                <div class="col-md-4 col-xs-12 form-group">
                    <label class="control-label" >  {{ __('strings.external_req_date_form') }} </label>
                    <input type="date" class="form-control" name="date_from" value="{{ $oldData  ? $oldData['date_from'] :'' }}">
                </div>
                <div class="col-md-4 col-xs-12 form-group">
                    <label class="control-label"> {{ __('strings.external_req_date_form') }} </label>
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
                    <label class="control-label">  {{ __('strings.external_req_invoice_code') }} </label>
                    <input type="number" class="form-control" name="invoice_no" value="{{ $oldData  ? $oldData['invoice_no']  :'' }}">
                </div>
                <div class="submitBtnSearch col-md-12 text-left">
                  <button type="submit" class="btn btn-primary"   > {{ __('strings.external_req_search') }} </button>
                </div>
            </form>
          </div>
        </div>
        <div class="panel panel-white">
          <div class="panel-heading clearfix">
            <h4 class="panel-title"> {{ __('strings.external_req_wait_show') }} </h4>
          </div>
          <div class="panel-body">
            <div id="show_reguest">
              <table id="xtreme-table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th> {{ __('strings.external_req_motionType') }} </th>
                    <th>  {{ __('strings.external_req_item') }}  </th>
                    <th>  {{ __('strings.external_req_qny') }}  </th>
                    <th> {{ __('strings.external_req_pricePiece') }} </th>
                    <th> {{ __('strings.external_req_tax') }} </th>
                    <th> {{ __('strings.external_req_total') }} </th>
                    <th>  {{ __('strings.external_req_cancellation') }}  </th>
                  </tr>
                </thead>
                <tbody id="clonetr">
                  @php

                  $req_trans = DB::select('SELECT sum(quantity * reg_flag  * final_price)  AS price  FROM `external_trans` WHERE  org_id = '.Auth::user()->org_id.' AND cust_id = '.$items->cust_id .' AND external_req_id = '.$items->id );
                  $emp_deliv = DB::table('users')->where('org_id',Auth::user()->org_id)->where('id',$items->emp_id)->first();
                  $date_temp = DB::table('settings')->where('org_id',Auth::user()->org_id)->where('key','date')->first();
                  $num_temp = DB::table('settings')->where('org_id',Auth::user()->org_id)->where('key','decimal_place')->first();

                  @endphp
                  @foreach ($items->trans()->with('cat')->get() as $item)
                  <tr id="firsttr">
                    <td class="reg_flagg">
                        <span style="display:none;"> {{ $item->reg_flag }} </span>
                        <select style="display:none;" >
                          <option value="{{ $item->reg_flag }}"></option>
                        </select>
                        {{ $item->reg_flag == -1 ?    __('strings.external_req_ex')    :    __('strings.external_req_ret')   }}
                    </td>
                    <td>{{ $item->cat->name }}</td>
                    <td> <input type="number" class="form-control qnyNum" form="newRequests" name="qny_edit[]" value="{{$item->quantity}}"> </td>
                    <td class="finalPricePerPiece"> <span class="cat_price">{{$item->final_price}}</span>  </td>
                    <td>{{$item->tax_val}}</td>
                    <td  class="{{ $item->reg_flag == -1 ? "fprice_1" : "fPrice" }}"><span class="total"> {{$item->quantity *  $item->final_price}}  </span></td>
                    <td>
                      <button type="button" class="btn btn-defult" id="deltr"  data-toggle="modal" data-id="{{ $item->id }}" data-req="{{ $items->id }}" data-cust="{{ $items->cust_id }}" data-target="#delete_req" >
                        <i class="fas fa-times"></i>
                      </button>
                      <input type="hidden" name="trans_id_edit[]"   value="{{ $item->id }}" form="newRequests">
                      <input type="hidden" name="external_id_edit[]" value="{{ $item->external_req_id }}" form="newRequests">
                      <input type="hidden" name="cust_id_edit[]" value="{{ $items->cust_id }}" form="newRequests">
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="totalPriceDiv text-left">
                {{ app()->getLocale() == 'ar' ? 'السعر الاجمالى' : 'total price'}} :  <span class="finalTotalPrice">{{ abs($req_trans[0]->price) + + abs($req_trans->delivery_fees) }}</span>
              </div>
               @if ($role) 
              @if ($items->confirm == 'n' || $items->confirm == 'y')

                <button type="button" class="btn btn-primary" id="addRow"><i class="fas fa-plus"></i> إضافة بند </button>
               @endif  
              @endif
              <span class="addRowBtn"></span>
              <button type="submit" class="btn btn-primary" id="saveData" form="newRequests"><i class="fas fa-check-circle"></i> حفظ </button>
              @if ($items->confirm == 'n' || $items->confirm == 'x')
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirm_Req"  data-req="{{ $items->id }}" data-cust="{{ $items->cust_id }}" data-type="{{ $items->confirm}}">تأكيد</button>
              @endif
              @if ($items->confirm == 'y' || $items->confirm == 'yx')
                <button type="button" class="btn btn-primary btn-close-regust" data-toggle="modal" data-target="#close_reguest" data-req="{{ $items->id }}" data-cust="{{ $items->cust_id }}" data-emp="{{ $emp_deliv->name }}" data-total="{{ abs($req_trans[0]->price )}}" data-status="{{ $items->confirm }}">
                  {{ __('strings.external_req_responsible') }}

                </button>
              @endif

            </div>
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="delete_req" style="margin-top:200px;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">حذف بند</h4>
              </div>
              <div class="modal-body">
                هل انت متأكد ؟
                <form id="deleteReq" action="{{ Route('deleteTrans') }}" method="post">
                  @csrf
                  <input type="hidden" name="trans_id" id="trans_id" value="">
                  <input type="hidden" name="req_id" id="req_id" value="">
                  <input type="hidden" name="cust_id" id="cust_id" value="">
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
                <button type="submit" form="deleteReq" class="btn btn-primary">حذف</button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#loginFormValidate').submit(function(e){
      e.preventDefault();
      var url = "{{ Route('adminConfirm') }}";
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: url,
        dataType: 'json',
        data: {
          password : $('#passValidate').val() ,
          email : $('#emailValidate').val(),
        },
        type: 'POST',

        beforeSend: function() {

        },
        success: function(msg) {
          if (msg.data == 'haveRole') {
            $('.addRowBtn').append(`
              <button type="button" class="btn btn-primary" id="addRow"><i class="fas fa-plus"></i> إضافة بند </button>`)
              $('#main-wrapper').append(`<div class="alert alert-success valiateFormLoginAlet"  >
                <strong style="font-weight: 400;"> {{ __('strings.external_req_haveRole') }} </strong>
              </div>`);
              function hideAlertLogin(){
                $('.valiateFormLoginAlet').hide();
              }
              $('.loginRole').hide();
              window.setTimeout(hideAlertLogin,3000);

          }else{
              $('#main-wrapper').append(`<div class="alert alert-danger valiateFormLoginAlet"  >
                <strong style="font-weight: 400;"> {{ __('strings.external_req_noRole') }} </strong>
              </div>`);
              function hideAlertLogin(){
                $('.valiateFormLoginAlet').hide();
              }

              window.setTimeout(hideAlertLogin,3000);

          }

          }
        });
    });
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
@php
  $iterable =  DB::table('categories')->where('org_id',Auth::user()->org_id)->get();
@endphp
$(document).ready(function() {
$('#main-wrapper').on('click','#addRow',function(){
       var data = `
   <tr>
   <td class="reg_flagg">
   <span class=" " style="display:none;"></span>
   <select name="reqFlag[]" form="newRequests" class="reg_flag_select form-control">
   <option value="-1">{{  __('strings.external_req_ex') }}</option>
   <option value="1">{{ __('strings.external_req_ret')}}</option>
   </select>
   </td>
  <td>
    <select name="cat_id[]" form="newRequests" class="cat_id_select form-control" required>
    <option class="btnTest" style="display:none"></option>
    @foreach ($iterable as  $value)
    <option class="btnTest" value="{{ $value->id }}"  >  {{ $value->name }} </option>
    @endforeach
    </select>
  </td>
  <td>
    <input class="form-control qnyNum" name="qny[]" form="newRequests" type="number" disabled required>
  </td>
  <td>
    <span class="cat_price"></span>
    <input class="cat_price_input"  form="newRequests" type="hidden" name="cat_price[]">
    <input class="tax_val" type="hidden"  form="newRequests" name="tax_val[]" required>
     <input class="taxId" name="taxId[]" type="hidden"   form="newRequests" required>
     <input class="" name="cust_id[]" type="hidden" value="{{ $items->cust_id }}"   form="newRequests" required>
     <input class="" name="req_id[]" type="hidden" value="{{ $items->id }}"   form="newRequests" required>
  </td>
  <td>
    <span class="tax"></span>
  </td>
  <td class="fprice_1">
    <span class="total"></span>
  </td>
  <td>
    <button type="button" id="deltr" style="color: red;"   class="btn btn-defult btn-close-regust2"><i class="fas fa-times"></i></button>
  </td>
   </tr>

`;
    $('#xtreme-table tbody').append(data);
   });

    $('#delete_req').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var id = button.data('id') // Extract info from data-* attributes
      var cust = button.data('cust') // Extract info from data-* attributes
      var req = button.data('req') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('.modal-body #trans_id').val(id)
      modal.find('.modal-body #cust_id').val(cust)
      modal.find('.modal-body #req_id').val(req)

    })
    $("#xtreme-table").on('click', '.btn-close-regust2', function () {
      var minus = 0,plus = 0;
      if ($(this).parents('tr').find('.reg_flagg select').val()  == -1) {
        minus = $('.finalTotalPrice').text()  -  $(this).parents('tr').find('.fPrice').text()  ;
        $('.finalTotalPrice').text(minus);
      }
      else if ($(this).parents('tr').find('.reg_flagg select').val()  == 1) {
        plus = $('.finalTotalPrice').text()  +  $(this).parents('tr').find('.fprice_1').text()  ;
        $('.finalTotalPrice').text(plus);
      }
      $(this).parents('tr').remove();
    });
});

</script>
<script >
  $(document).ready(function() {

    $('#xtreme-table').on('change', '.cat_id_select' , function () {
      var url = "{{ Route('getCatDetails') }}";

      var selected = $(this);
      // alert($('#menu_id').val());
      // Start Ajax
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url: url,
        dataType: 'json',
        data: {
          cat_id: $(this).find('option:selected').val(),
          flag_req: $(this).parents('tr').find('.reg_flagg option:selected').val(),
          req_id: {{ $items->id }},

        },
        type: 'POST',

        beforeSend: function() {


          selected.parents('tr').find('.qnyNum').attr('disabled',true);
          selected.parents('tr').find('.tax').empty();
          selected.parents('tr').find('.cat_price').empty();
          selected.parents('tr').find('.qnyNum').empty();
          // selected.parents('tr').find('.id_hidden').empty();
          selected.parents('tr').find('.total').empty();
          selected.parents('tr').find('.taxId').empty();
          selected.parents('tr').find('.tax_val').empty();
          // selected.parents('tr').find('.invoice_no').empty();
          // selected.parents('tr').find('.invoice_date').empty();

        },
        success: function(msg) {
          if (msg.data == 'successGetPice') {
            // selected.find('option').val(msg.catId).attr('selected',true);
            selected.parents('tr').find('.tax_val').val(msg.catTax);
            selected.parents('tr').find('.tax').text(msg.catTax);
            selected.parents('tr').find('.cat_price_input').val(msg.catPrice);
            selected.parents('tr').find('.cat_price').text(msg.catPrice);
            selected.parents('tr').find('.qnyNum').attr('disabled',false);
            // selected.parents('tr').find('.id_hidden').val(msg.catId);
            selected.parents('tr').find('.qnyNum').val(1);
            selected.parents('tr').find('.total').text(msg.catPrice * selected.parents('tr').find('.qnyNum').val());
            selected.parents('tr').find('.taxId').val(msg.taxId);
            calcTotal(selected);
            var flag_req = 0

            if (selected.parents('tr').find('.reg_flag_select option:selected').val() == 1) {
                selected.parents('tr').find('.qnyNum').attr('min',0);
                selected.parents('tr').find('.qnyNum').val(1);

                selected.parents('tr').find('.qnyNum').attr('max',msg.flag);
            }
            // flag
          ;
            // selected.parents('tr').find('.invoice_no').val(msg.invoice_date);
            // selected.parents('tr').find('.invoice_date').val(msg.invoice_date);

          }else{
            selected.parents('tr').find('.qnyNum').empty();
            selected.parents('tr').find('.reg_flag_select').html(
              ` <option value="-1">{{  __('strings.external_req_ex') }}</option>
               <option value="1">{{ __('strings.external_req_ret')}}</option>`
            );

              selected.parents('td').html(
                `
                <select name="cat_id[]" form="newRequests" class="cat_id_select form-control" required>
                <option class="btnTest" style="display:none"></option>
                @foreach ($iterable as  $value)
                <option class="btnTest" value="{{ $value->id }}"  >  {{ $value->name }} </option>
                @endforeach
                </select>
                `);
              alert('هذا المنتج ليس له سعر');
          }

          }
        });
      return false;

    });

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

var allPrice  = 0;
var allPrice2  = 0;
// $(".fPrice span").each(function() {
//   if ($(this).parents('tr').find('.reg_flagg span').text() == -1) {
//     pri = parseFloat($(this).text())
//     allPrice -= pri;
//   }
// });
// $(".fprice_1 span").each(function() {
//   var minus = parseFloat($(this).text());
//   allPrice2 += minus;
// });
  // var dd = allPrice - allPrice2;
  // $('.finalTotalPrice').text(dd.toFixed(2));

    $('#xtreme-table').on('change', '.reg_flagg select' , function () {
      if ($(this).parents('tr').find('.reg_flagg select').val() == -1) {
        var total = $(this).parents('tr').find('.fPrice').addClass('fprice_1') ;
        var total = $(this).parents('tr').find('.fPrice').removeClass('fPrice') ;
          $(this).parents('tr').find('.qnyNum').val(null);
          $(this).parents('tr').find('.cat_id_select').html(
            `
            <option class="btnTest" style="display:none"></option>
            @foreach ($iterable as  $value)
            <option class="btnTest" value="{{ $value->id }}"  >  {{ $value->name }} </option>
            @endforeach
            `);
      }else{
        var total = $(this).parents('tr').find('.fprice_1').addClass('fPrice') ;
        var total = $(this).parents('tr').find('.fprice_1').removeClass('fprice_1') ;
        var url = "{{ Route('getProductReturn') }}";
        var selected = $(this);
        // alert($('#menu_id').val());
        // Start Ajax
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url:  url,
          dataType: 'json',
          data: {
            reg_flag: selected.find('option:selected').val(),
            req_id: $('#request_id_span input').val(),
          },
          type: 'POST',

          beforeSend: function() {
            selected.parents('tr').find('.qnyNum').val(null);
            selected.parents('tr').find('.tax').empty();
            selected.parents('tr').find('.cat_price').empty();
            selected.parents('tr').find('.qnyNum').empty();
            selected.parents('tr').find('.total').empty();
            selected.parents('tr').find('.taxId').empty();
            selected.parents('tr').find('.tax_val').empty();

          },
          success: function(msg) {

            if (msg.returnMsg == 'successGitCats') {
              // console.log(msg.data);
              var data2 = `<option class="btnTest" style="display:none"></option>`;

              for(p in msg.data) {
                 data2 += `
                  <option value="`+ msg.data[p][0].id +`" >`+ msg.data[p][0].name +`</option>
                  `;
                selected.parents('tr').find('.cat_id_select').html(data2);
              }
            }

            }
          });
        return false;
      }

      calcTotal($(this));
    });
    $('#xtreme-table').on('change', '.qnyNum' , function () {
      var total = $(this).val() * $(this).parents('tr').find('.cat_price').text() ;
      $(this).parents('tr').find('.total').text(total.toFixed(2));
      calcTotal($(this));
    });

    document.getElementById('serachExternalReqForm').addEventListener('keypress', function(event) {
        if (event.keyCode == 13) {
            $("#serachExternalReqForm").submit()
        }



    });

</script>
<script type="text/javascript">
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

</script>





@endsection

@endsection
