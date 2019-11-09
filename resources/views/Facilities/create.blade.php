@extends('layouts.admin', ['title' => __('strings.add_allows')])

@section('content')


    <!--<div class="page-title">-->
    <!--    <h3@lang('strings.add_allows')</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>-->
    <!--            <li><a href="../pay_types">@lang('strings.allow_dedcted')</a></li>-->
    <!--            <li class="active">@lang('strings.add_allows')</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">

            <div class="col-md-8">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">@lang('strings.add_allows')</h4>
                    </div>
                    <div class="panel-body">

                        <form method="post" action="savepay_type" enctype="multipart/form-data">

                            {{csrf_field()}}

							 	<div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="name">@lang('strings.Arabic_name')</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('type') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="type">@lang('strings.allow_dedcted')</label>
                                   <select class="form-control" name="type" id="type" onchange="change_type()">
                                    <option  value="1">@lang('strings.dedcted')</option>
                                    <option value="0">@lang('strings.allow')</option>
                                </select>


                                @if ($errors->has('type'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('type') }}</strong>
                                    </span>
                                @endif
                            </div>



<div class="col-md-6 form-group{{$errors->has('code') ? ' has-error' : ''}}" id="code">
                                <label class="control-label" for="code">@lang('strings.deduction_code')</label>
                                <input type="text" class="form-control" name="code" value="{{old('code') }}">
                                @if ($errors->has('code'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>



<div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="name_en">@lang('strings.English_name')</label>
                                <input type="text" class="form-control" name="name_en" value="{{old('name_en') }}">
                                @if ($errors->has('name_en'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                    </span>
                                @endif
                            </div>
<div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="active">@lang('strings.Status')</label>
                                <select class="form-control" name="active">
                                    <option  value="1">@lang('strings.Active')</option>
                                    <option value="0">@lang('strings.Deactivate')</option>
                                </select>
                                @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('active') }}</strong>
                                    </span>
                                @endif
                            </div>



                 <div class="col-md-6 form-group{{$errors->has('Benefits') ? ' has-error' : ''}}"style="display: none;" id="Benefits-select"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="Benefits">@lang('strings.allows_type')</label>
                                <select class="form-control" name="Benefits">
                                    <option  value="1">@lang('strings.basic')</option>
                                    <option  value="0">@lang('strings.other')</option>
                                </select>
                                @if ($errors->has('Benefits'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('Benefits') }}</strong>
                                    </span>
                                @endif
                            </div>
 <div class="col-md-6 form-group{{$errors->has('Deduction') ? ' has-error' : ''}}"style="display: none;" id="Deduction-select"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="Deduction">@lang('strings.deduction_type')</label>
                                <select class="form-control" name="Deduction">
                                    <option  value="1">@lang('strings.loan')</option>
                                    <option  value="0">@lang('strings.other')</option>
                                </select>
                                @if ($errors->has('Deduction'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('Deduction') }}</strong>
                                    </span>
                                @endif
                            </div>









                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">@lang('strings.Save')</button>
                                </div>
                            </div>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
  <script>


 // var type_code=document.getElementById('type').value;
 //
	// if(type_code==0){
 //
	// document.getElementById('Deduction-select').style.display = "none";
	//  document.getElementById('Benefits-select').style.display = "block";
	// }else{
 //
	// document.getElementById('Deduction-select').style.display = "block";
	// document.getElementById('Benefits-select').style.display = "none";
	// }
  </script>
@endsection
