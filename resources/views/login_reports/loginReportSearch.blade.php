@extends('layouts.admin', ['title' => __('strings.report_title_user')])
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
    <form class="" action="{{ Route('loginHistorySearch') }}" method="post">
      @csrf
      <div class="row">
        <div class="col-md-3">
          <label class="form-contorl">اسم المستخدم</label>
          <select class="js-example-basic-single js-select-users" name="user_id"  style="width:100%;">
            <option value="">الكل</option>
            @foreach ($orgUsers as $user)
              <option value="{{$user->id}}">{{$user->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-contorl">الحالة</label>
          <select class="js-example-basic-single" name="status"  style="width:100%;">
            <option value="">الكل</option>
            <option value="login"> loginHistory_login {{__('strings.loginHistory_login')}}</option>
            <option value="logout">{{__('strings.loginHistory_logout')}}</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-contorl ">تاريخ التسجيل من</label>
          <div class="form-group ">
            <input type="date" class="form-control" name="date_from" >
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-contorl ">تاريخ التسجيل الي</label>
          <div class="form-group ">
            <input type="date" class="form-control" name="date_to" >
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-contorl">ترتيب</label>
          <select class="js-example-basic-single" name="orderBy"  style="width:100%;">
            <option value="date">بالتاريخ</option>
            <option value="user">بالمستخدم</option>
          </select>
        </div>
      </div>
      <div class="formSubmitBtn col-md-12 ">
        <button type="submit" class="btn btn-primary" name="button">بحث</button>
      </div>
    </form>

    <div class="row resultLoginTable">
      <table class="table table-bordered">
        <thead>
          <tr>
            <td>الاسم</td>
            <td>التاريخ</td>
            <td>الوقت</td>
            <td>الحالة</td>
          </tr>
          <tbody>
            @foreach ($result as $res)
              @php
                $resUser = App\User::find($res->user_id);
              @endphp
              <tr>
                <td>{{ $resUser->name }}</td>
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
              <td>الاسم</td>
              <td>التاريخ</td>
              <td>الوقت</td>
              <td>الحالة</td>
            </tr>
          </tfoot>
        </thead>
      </table>
    </div>
  </div>





@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script> --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script> --}}
<script>

  // In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
$('.js-select-users').select2({
   minimumInputLength: 2,
});
</script>


@endsection
@endsection
