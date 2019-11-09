@php
use Carbon\Carbon;
@endphp
@extends('layouts.admin', ['title' => __('strings.external_report_title')])
@section('styles')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
  <style media="screen">
    .resultLoginTable{
      margin-top:80px ;
    }
  </style>
@endsection
@section('content')
  <div id="main-wrapper" class="main-wrapper-index"  >
     <form class="row" action="{{ Route('external_reports_search') }}" method="GET">

       <div class="col-md-4 col-xs-12 form-group">
           <label class="control-label" >{{ __('strings.external_req_date_form_inv') }}</label>
           <input type="date" class="form-control" name="date_from" value="{{ $oldData  ? $oldData['date_from']   :'' }}">
       </div>
       <div class="col-md-4 col-xs-12 form-group">
           <label class="control-label">{{ __('strings.external_req_date_to_inv') }}</label>
           <input type="date" class="form-control" name="date_to" value="{{ $oldData  ? $oldData['date_to']  :'' }}">
       </div>
       <div class="col-md-4 form-group">
         <label class="label-control">
            الحالة
         </label>
         <select class="form-control" name="type">
           <option style="display:none" value="" selected></option>
           <option value="0" {{ $oldData && $oldData['type'] == '0'? 'selected' :'' }}>{{ __('strings.All') }}</option>
           <option value="p" {{ $oldData && $oldData['type'] == 'p'? 'selected':'' }}>{{ __('strings.external_req_basket') }}</option>
           <option value="n" {{ $oldData && $oldData['type'] == 'n'? 'selected' :''}}>{{ __('strings.external_req_wait') }}</option>
           <option value="y" {{ $oldData && $oldData['type'] == 'y'? 'selected' :''}}>{{ __('strings.external_req_confirm') }}</option>
           <option value="c" {{ $oldData && $oldData['type'] == 'c'? 'selected':'' }}>{{ __('strings.external_req_cancel') }}</option>
           <option value="d" {{ $oldData && $oldData['type'] == 'd'? 'selected' :''}}>{{ __('strings.external_req_done') }}</option>
         </select>
       </div>
       <div class="col-12">
        <button type="submit" class="btn btn-primary" name="button">{{ __('strings.external_req_search') }}</button>
       </div>
     </form>
    <div class="mainTable">
      <table id="xtreme-table" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>اسم المنتج</th>
                <th>الكمية</th>
                <th>الاجمالى</th>
            </tr>
        </thead>
        <tbody>
          @foreach ($items as $value)
            @php
              $req_trans = DB::select('SELECT sum(quantity * reg_flag)   AS quantity  FROM `external_trans` WHERE  org_id = '.Auth::user()->org_id.' AND cust_id = '.$value->cust_id .' AND cat_id = '.$value->cat_id .' AND external_req_id = '.$value->external_req_id);
            @endphp
            <tr>
              <td>{{ $value->product->name }}</td>
              <td>{{ $req_trans[0]->quantity }}</td>
              <td>{{ Decimalplace(floatval($value->trans + $value->delivery_fees)) }}</td>
            </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
          <div class="row resultLoginTable">
      </br></br></br></br></br></br>
      <div id="app">
       {!! $chart->container() !!}
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
document.getElementById('serachExternalReqForm').addEventListener('keypress', function(event) {
    if (event.keyCode == 13) {
        $("#serachExternalReqForm").submit()
    }
});
</script>


@endsection
@endsection
