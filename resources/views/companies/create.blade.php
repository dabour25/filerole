@extends('layouts.admin', ['title' =>  __('strings.companies_add') ])

@section('content')
    <style>
        #tab_logic .form-control[readonly], #tab_logic_total .form-control[readonly] {
            border: 0;
            background: transparent;
            box-shadow: none;
            padding: 0 10px;
            font-size: 15px;
        }
    </style>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">@lang('strings.companies_add')</h4>
                        </div>
                    </div>
                    <div class="panel-body">

                        <form method="post" action="{{route('companies.store')}}" enctype="multipart/form-data" role="form" id="add-role">
                            {{csrf_field()}}

                            <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="name">@lang('strings.Arabic_name')</label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                                <label class="control-label" for="name_en">@lang('strings.English_name')</label>
                                <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}">
                                @if ($errors->has('name_en'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('address') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="address">@lang('strings.address')</label>
                                <input type="text" class="form-control" name="address" value="{{old('address')}}">
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('phone') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="phone">@lang('strings.phone')</label>
                                <input type="text" class="form-control" name="phone" value="{{old('phone')}}">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('email') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="phone">@lang('strings.Email')</label>
                                <input type="email" class="form-control" name="email" value="{{old('email')}}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="active">@lang('strings.Status')</label>
                                <select class="form-control" name="active">
                                    <option value="1">@lang('strings.Active')</option>
                                    <option value="0">@lang('strings.Deactivate')</option>
                                </select>
                                @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('active') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">@lang('strings.Save')</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection