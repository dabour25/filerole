@php
use Carbon\Carbon;
@endphp
@extends('layouts.admin', ['title' => __('strings.trans_limit_title')])
@section('styles')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
 
@endsection
@section('content')

  <div id="main-wrapper" class="main-wrapper-index">
    <form class="" action="{{ Route('trans_limit_search') }}" method="get">
      <div class="row">
        <div class="col-md-5">
          <label class="form-contorl">{{ __('strings.transSearch_cat_select') }}</label>
          <select class="js-example-basic-single js-select-users" name="catType_id"  style="width:100%;">
            <option value="">{{ __('strings.login_history_all') }}</option>
              @foreach ($cat_type as $cat_type)
                <option value="{{ $cat_type->id }}">{{ app()->getLocale() == 'ar'? $cat_type->name : $cat_type->name_en }}</option>
              @endforeach

          </select>
        </div>
        <!--<div class="col-md-5">-->
        <!--  <label class="form-contorl">{{ __('strings.loginHistory_orderBy') }}</label>-->
        <!--  <select class="js-example-basic-single" name="orderBy"  style="width:100%;">-->
        <!--    <option value="catType">{{ __('strings.transSearch_cat') }}</option>-->
        <!--    <option value="qny">{{ __('strings.transSearch_qny') }}</option>-->
        <!--  </select>-->
        <!--</div>-->
        <div class="formSubmitBtn col-md-2 ">
          <button type="submit" class="btn btn-primary" name="button" id="subMitBtnSearch">  <i class="fas fa-save"></i> {{ __('strings.loginHistory_search') }}</button>
        </div>
      </div>

    </form>
    <div class="row resultLoginTable">
    </br></br></br></br></br></br>
    <div id="app">
     {!! $chart->container() !!}
    </div>
    <div class="testsss">

    </div>
      @if(count($trans)>0)
        <table id="dLimit_trans" class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <td>{{ __('strings.loginHistory_name') }}</td>
            <td>{{ __('strings.transSearch_cat') }}</td>
            <td>{{ __('strings.transSearch_limit') }}</td>
            <td>{{ __('strings.transSearch_qny') }}</td>
          </tr>
        </thead>
          <tbody>
            @foreach ($trans as $res)
              @php
                $cat = DB::table('categories')->find($res->cat_id);
                
                
                $transsss = DB::select('SELECT sum(quantity * req_flag)    AS qnt  FROM `transactions` WHERE  org_id = '.Auth::user()->org_id.' AND cat_id = '.$cat->id );
 
                $catType =  DB::table('categories_type')->where('org_id',$cat->org_id)->where('id',$cat->category_type_id)->first() ;
              @endphp
                @if($transsss[0]->qnt !== null)
                @if ($cat->d_limit === null)

                  <tr>
                    <td>{{ app()->getLocale() == 'ar' ? $cat->name : $cat->name_en }}</td>
                    <td> {{ app()->getLocale() == 'ar' ? $catType->name : $catType->name_en }} </td>
                    @if ($cat->d_limit  === null)
                      <td>{{ app()->getLocale() == 'ar' ?  0 : 0 }}</td>
                    @else
                      <td>{{ app()->getLocale() == 'ar' ? $cat->d_limit : $cat->d_limit }}</td>
                    @endif
                    <td>{{ $transsss[0]->qnt}}</td>
                  </tr>
              @elseif ($transsss[0]->qnt <= $cat->d_limit)

                <tr>
                  <td>{{ app()->getLocale() == 'ar' ? $cat->name : $cat->name_en }}</td>
                  <td> {{ app()->getLocale() == 'ar' ? $catType->name : $catType->name_en }} </td>
                  <td> {{ $cat->d_limit }}</td>
                  <td>{{ $transsss[0]->qnt}}</td>
                </tr>
              @endif
              @endif
            @endforeach


          </tbody>
          <tfoot>
            <tr>
              <td>{{ __('strings.loginHistory_name') }}</td>
              <td>{{ __('strings.transSearch_cat') }}</td>
              <td>{{ __('strings.transSearch_limit') }}</td>
              <td>{{ __('strings.transSearch_qny') }}</td>
            </tr>
          </tfoot>
      </table>
    @else
      <div class="text-center">
      {{ __('strings.login_no_result') }}
      </div>
    @endif
    @if (count($resultCatType) > 0)
      <table id="dLimit_trans" class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <td>{{ __('strings.loginHistory_name') }}</td>
            <td>{{ __('strings.transSearch_cat') }}</td>
            <td>{{ __('strings.transSearch_limit') }}</td>
            <td>{{ __('strings.transSearch_qny') }}</td>
          </tr>
        </thead>
          <tbody>
            @foreach ($resultCatType as $res)
              @foreach ($res->categories()->get(['id','name','name_en','d_limit']) as $vat)
                @php
                $transsss =  DB::table('transactions')->where('org_id',$res->org_id)->where('cat_id' ,$vat->id)->where('trans_type',1)->sum('quantity') - DB::table('transactions')->where('org_id',$res->org_id)->where('cat_id' ,$vat->id)->where('trans_type',2)->sum('quantity');
                @endphp
                <tr>
                  <td>{{ app()->getLocale() == 'ar' ? $vat->name : $vat->name_en }}</td>
                  <td>{{ app()->getLocale() == 'ar' ? $res->name : $res->name_en }}</td>
                  @if ($vat->d_limit)
                    <td>{{ app()->getLocale() == 'ar' ? $vat->d_limit : $vat->d_limit }}</td>
                  @else
                    <td>{{ app()->getLocale() == 'ar' ? 'غير محدد' : Null }}</td>
                  @endif
                  <td>{{ $transsss }}</td>
                </tr>
              @endforeach


            @endforeach


          </tbody>
      </table>
    @endif
    </div>
  </div>





@section('scripts')
  <script src="https://unpkg.com/vue"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script>
 {!! $chart->script() !!}
<script>
  var app = new Vue({
         el: '#app',
     });

  // In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
  $('#dLimit_trans').DataTable();
  $('.js-example-basic-single').select2();
});
$('.js-select-users').select2({
   minimumInputLength: 2,
});


function checkDate() {
  var dateFrom = Date_from_search;
  var dateTo = Date_to_search;
  var startDate = new Date(document.getElementById('Date_from_search').value);
  var EndDate = new Date(document.getElementById('Date_to_search').value);
  if (startDate.getTime() > EndDate.getTime()) {
    $('#validateDateHistory').text("يجب ادخال قيمة تاريخ صحيحة");
    $("#subMitBtnSearch").attr("disabled", true);
  }
  else{
    $('#validateDateHistory').text("");

    $("#subMitBtnSearch").attr("disabled", false);
  }
}
// window.onbeforeunload = function() {
//     return "Bye now!";
// };
</script>


@endsection
@endsection
