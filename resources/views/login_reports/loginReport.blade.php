@php
use Carbon\Carbon;
@endphp
@extends('layouts.admin', ['title' => __('strings.login_history_title')])
@section('styles')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
  <style media="screen">
    .resultLoginTable{
      margin-top:80px ;
    }
  </style>
@endsection
@section('content')
  @php
    $orgUsers =  App\User::where('org_id' , Auth::user()->org_id)->orderBy('id','desc')->get();
  @endphp
  <div id="main-wrapper" class="main-wrapper-index" style="margin-top:250px;min-height:600px;">
    <form class="" action="{{ Route('loginHistorySearch') }}" method="get">
      <div class="row">
        <div class="col-md-3">
          <label class="form-contorl">{{ __('strings.loginHistory_userName') }}</label>
          <select class="js-example-basic-single js-select-users" name="user_id"  style="width:100%;">
            <option value="">{{ __('strings.login_history_all') }}</option>
            @foreach ($orgUsers as $user)
              <option value="{{$user->id}}"  {{ $oldData && $oldData['user_id'] == $user->id? "selected" : "" }}>{{$user->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-contorl">{{ __('strings.loginHistory_status') }}</label>
          <select class="js-example-basic-single" name="status"  style="width:100%;">
            <option value="">{{ __('strings.login_history_all') }}</option>
            <option value="login" {{ $oldData && $oldData['status'] == 'login'? "selected" : "" }}>{{__('strings.loginHistory_login')}}</option>
            <option value="logout" {{ $oldData && $oldData['status'] == 'logout'? "selected" : "" }}>{{__('strings.loginHistory_logout')}}</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-contorl ">{{ __('strings.loginHistory_dateFrom') }}</label>
          <div class="form-group ">
            <input type="date" class="form-control" value="{{ $oldData ? $oldData['date_from'] : "" }}" name="date_from" id="Date_from_search" onchange="checkDate()">
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-contorl ">{{ __('strings.loginHistory_dateTo') }}</label>
          <div class="form-group ">
            <input type="date" class="form-control" name="date_to" value="{{ $oldData ? $oldData['date_to'] : "" }}" id="Date_to_search" onchange="checkDate()">
            <span style="color:red;" id="validateDateHistory"></span>
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-contorl">{{ __('strings.loginHistory_orderBy') }}</label>
          <select class="js-example-basic-single" name="orderBy"  style="width:100%;">
            <option value="date" {{ $oldData && $oldData['orderBy'] == 'date'? "selected" : "" }}>{{ __('strings.loginHistory_orderdate') }}</option>
            <option value="user" {{ $oldData && $oldData['orderBy'] == 'user'? "selected" : "" }}>{{ __('strings.loginHistory_orderuser') }}</option>
          </select>
        </div>
      </div>
      <div class="formSubmitBtn col-md-12 ">
        <button type="submit" class="btn btn-primary" name="button" id="subMitBtnSearch">{{ __('strings.loginHistory_search') }}</button>
      </div>
    </form>
    <div class="row resultLoginTable">
    </br></br></br></br></br></br>
    <div id="app">
     {!! $chart->container() !!}
    </div>
      @if(count($allHistory)>0)
      <table class="table table-bordered">
        <thead>
          <tr>
            <td>{{ __('strings.loginHistory_name') }}</td>
            <td>{{ __('strings.loginHistory_disDate') }}</td>
            <td>{{ __('strings.loginHistory_time') }}</td>
            <td>{{ __('strings.loginHistory_status') }}</td>
          </tr>
          <tbody>



            @foreach ($allHistory as $res)
              @php
                $resUser = App\User::find($res->user_id);
              @endphp
              <tr>
                <td>{{ app()->getLocale() == 'ar' ? $resUser->name : $resUser->name_en }}</td>
                <td> {{ Carbon::parse($res->created_at)->format('Y-m-d')  }} </td>
                <td> {{ Carbon::parse($res->created_at)->format('H:i:s')  }} </td>
                @if (app()->getlocale() == 'ar')
                  <td>{{ $res->status == 'login'?  "تسجيل دخول" : "تسجيل خروج" }}</td>
                @else
                  <td>{{ $res->status}}</td>

                @endif
              </tr>
            @endforeach


          </tbody>
          <tfoot>
            <tr>
              <td>{{ __('strings.loginHistory_name') }}</td>
              <td>{{ __('strings.loginHistory_disDate') }}</td>
              <td>{{ __('strings.loginHistory_time') }}</td>
              <td>{{ __('strings.loginHistory_status') }}</td>
            </tr>
          </tfoot>
        </thead>
      </table>
    @else
      <div class="text-center">
      {{ __('strings.login_no_result') }}
      </div>
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
</script>


@endsection
@endsection
