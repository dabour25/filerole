@extends('layouts.admin', ['title' => __('strings.Categories_type') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.10/css/bootstrap-select.min.css" rel="stylesheet">
@endsection
@section('content')
    <style>
        td.details-control {
            background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
        }

        td.suggestion-details-control {
            background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.suggestion-details-control {
            background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
        }



        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons that are used to open the tab content */
        .tab button {
            background-color: inherit;
            float: right;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current tablink class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }
    </style>

    <div class="modal fade newModel" id="addcat_type" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="overflow: hidden">
                    <form method="post" action="#" enctype="multipart/form-data" id ="add_cat_type_store">

                        {{csrf_field()}}
                        <input name="type" type="hidden" value="{{ $type }}">
                        <input name="active" type="hidden" value="1">

                        <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                            <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                            <input type="text" class="form-control" name="name" value="{{old('name')}}" required>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                            <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                            <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}" required>
                            @if ($errors->has('name_en'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                </span>
                            @endif
                        </div>


                        <div class="col-md-6 desk_New form-group{{$errors->has('description') ? ' has-error' : ''}}">
                            <label class="control-label" for="description">@lang('strings.description_ar')</label>
                            <textarea type="text" class="textall" name="description">{{old('description')}}</textarea>
                            @if ($errors->has('description'))
                                <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                            @endif
                        </div>

                        <div class="col-md-6 desk_New form-group{{$errors->has('description_en') ? ' has-error' : ''}}">
                            <label class="control-label" for="description">@lang('strings.description_en')</label>
                            <textarea type="text" class="textall" name="description_en">{{old('description_en')}}</textarea>
                            @if ($errors->has('description_en'))
                                <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description_en') }}</strong>
                                    </span>
                            @endif
                        </div>
                    <!--div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="active">{{ __('strings.Status') }}</label>
                                <select class="form-control" name="active" required>
                                    <option selected value="1">{{ __('strings.Active') }}</option>
                                    <option value="0">{{ __('strings.Deactivate') }}</option>

                                </select>
                                @if ($errors->has('active'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('active') }}</strong>
                                    </span>
                                @endif
                            </div-->

                        <div class="col-md-12 form-group text-right">
                            <button type="submit" id="add_cat_type_submit" class="btn btn-primary btn-lg"> {{ __('strings.Save') }} </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade newModel" id="update_cat_type" role="dialog">
           <div class="modal-dialog">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Modal content-->
               <div class="modal-content">
                   <div class="modal-body" style="overflow: hidden">
                        <form method="post" action="{{url('admin/categories_type/update')}}" enctype="multipart/form-data"
                  id="edit-role">
                {{csrf_field()}}
                {{ method_field('PATCH') }}
                <input name="active" type="hidden" value="1">
                <input name="id" type="hidden" value="">
                <input name="type" type="hidden" value="{{ $type }}">
                <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                    <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                    <input type="text" class="form-control" name="name" value="">
                    @if ($errors->has('name'))
                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                    <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                    <input type="text" class="form-control" name="name_en" value="">
                    @if ($errors->has('name_en'))
                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                    </span>
                    @endif
                </div>


                <div class="col-md-6 desk_New form-group{{$errors->has('description') ? ' has-error' : ''}}">
                    <label class="control-label" for="description">@lang('strings.description_ar')</label>
                    <input type="text" class="textall" name="description"/> 
                    @if ($errors->has('description'))
                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="col-md-6 desk_New form-group{{$errors->has('description_en') ? ' has-error' : ''}}">
                    <label class="control-label" for="description">@lang('strings.description_en')</label>
                    <input type="text" class="textall" name="description_en"/>
                    @if ($errors->has('description_en'))
                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description_en') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="col-md-12 form-group text-right">
                    <button type="submit" class="btn btn-primary btn-lg"> {{ __('strings.Save') }} </button>
                </div>

            </form>
                   </div>
               </div>
           </div>
       </div>
    
    
    <div class="modal fade newModel" id="open-modal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="overflow: hidden">
                </div>
            </div>

        </div>
    </div>

    <div id="main-wrapper">

        <div class="row">
            <div class="col-md-12">
                @include('alerts.index')
                <style>
                    .btn-primary:hover {
                        background: #2c9d6f !important;
                    }
                </style>
                <div class="alert_new">
                    <span class="alertIcon">
                        <i class="fas fa-exclamation-circle"></i>
                    </span>
                    <p>
                        @if (app()->getLocale() == 'ar')
                            {{ DB::table('function_new')->where('id',25)->value('description') }}
                        @else
                            {{ DB::table('function_new')->where('id',25)->value('description_en') }}
                        @endif
                    </p>
                    <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i> </a>
                </div>

                <br>
                <!-- Tab links -->
                <div class="tab">
                    <button class="tablinks {{ Request::is('admin/categories_type') ? 'active' : '' }}" onclick="location.href = '{{ url('admin/categories_type') }}'">@lang('strings.services')</button>
                    <button class="tablinks {{ Request::is('admin/categories_type/offers') ? 'active' : '' }}" onclick="location.href = '{{ url('admin/offers/service') }}'">@lang('strings.services_offers')</button>
                    <button class="tablinks {{ Request::is('admin/categories_type/items') ? 'active' : '' }}" onclick="location.href = '{{ url('admin/categories_type/items') }}'">@lang('strings.categories')</button>
                    <button class="tablinks {{ Request::is('admin/categories_type/items/offers') ? 'active' : '' }}" onclick="location.href = '{{ url('admin/categories_type/items/offers') }}'">@lang('strings.categories_offers')</button>
                    <button class="tablinks {{ Request::is('admin/categories_type/suggestion') || Request::is('admin/categories_type/suggest_product') || Request::is('admin/categories_type/suggest_product/*/edit') ? 'active' : '' }}" onclick="location.href = '{{ url('admin/categories_type/suggestion') }}'">@lang('strings.product_suggestion')</button>
                </div>

                @if(Request::is('admin/categories_type/items/offers') || Request::is('admin/categories_type/offers'))
                    @if(Request::is('admin/categories_type/items/offers'))
                        <div class="btn-group m-l-xs">
                            <a class="btn btn-primary btn-lg btn-add" href="{{ url('admin/offers/1/create') }}"> <i class="fa fa-plus"></i>@lang('strings.Show')</a>
                        </div>
                    @else
                        <div class="btn-group m-l-xs">
                            <a class="btn btn-primary btn-lg btn-add" href="{{ url('admin/offers/2/create') }}"> <i class="fa fa-plus"></i> @lang('strings.Show')</a>
                        </div>
                    @endif
                @else
                    @if(permissions('categories_type_add') == 1 && !Request::is('admin/categories_type/suggestion') && !Request::is('admin/categories_type/suggest_product') && !Request::is('admin/categories_type/suggest_product/*/edit'))
                        @if($type == null)
                            <div class="btn-group m-l-xs">
                                @if(Request::is('admin/categories_type/items'))
                                    <div class="btn-group m-l-xs col-md-2">
                                    <!--<a class="btn btn-primary btn-lg btn-add" href="{{ url('admin/categories_type/1/create') }}"> <i class="fa fa-plus"></i> {{ app()->getLocale() == 'ar' ? ActivityLabel('items')->value : ActivityLabel('items')->value_en }} </a>-->
                                        <button type="button" class="btn btn-primary btn-lg btn-add" data-toggle="modal" id="modal_button" data-target="#addcat_type" data-type="1"><i class="fas fa-plus"></i>@lang('strings.categories_types')</button>

                                    </div>
                                @endif
                                @if(Request::is('admin/categories_type'))
                                    <div class="btn-group m-l-xs col-md-2">
                                    <!--<a class="btn btn-primary btn-lg btn-add" href="{{ url('admin/categories_type/2/create') }}"> <i class="fa fa-plus"></i> {{ app()->getLocale() == 'ar' ? ActivityLabel('services')->value : ActivityLabel('services')->value_en }} </a>-->
                                        <button type="button" class="btn btn-primary btn-lg btn-add" data-toggle="modal" id="modal_button" data-target="#addcat_type" data-type="2"><i class="fas fa-plus"></i>{{ app()->getLocale() == 'ar' ? ActivityLabel('services')->value : ActivityLabel('services')->value_en }}</button>
                                    </div>
                                @endif
                            </div>
                            <div class="btn-group m-l-xs">
                                @if(Request::is('admin/categories_type/items'))
                                    <div class="btn-group m-l-xs">
                                        <a class="btn btn-primary btn-lg btn-add open-modal" href="#"> <i class="fa fa-plus"></i> @lang('strings.Categories_add')</a>
                                    </div>
                                @endif
                                @if(Request::is('admin/categories_type'))
                                    <div class="btn-group m-l-xs">
                                        <a class="btn btn-primary btn-lg btn-add open-modal-2" href="#"> <i class="fa fa-plus"></i> @lang('strings.Categories_add_service')</a>
                                    </div>
                                @endif
                            </div>
                        @else
                            <a class="btn btn-primary btn-lg btn-add" href="{{ $type == 1 ? url('admin/categories_type/'. $type . '/create') : url('admin/categories_type/'. $type . '/create') }}">
                                <i class="fa fa-plus"></i>&nbsp;&nbsp;{{ $type == 1 ? __('strings.categories_type_add') : __('strings.categories_type_service_add') }}
                            </a>
                        @endif
                    @endif
                @endif

                @if(Request::is('admin/categories_type/suggestion'))
                    <div class="btn-group m-l-xs">
                        <a class="btn btn-primary btn-lg btn-add" href="{{ url('admin/categories_type/suggest_product') }}"> <i class="fa fa-plus"></i> @lang('strings.add_suggestion_product')</a>
                    </div>
                @endif

                @if(Request::is('admin/categories_type/suggest_product'))
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">

                                </div>
                                <div class="panel-body">
                                    <form method="post" action="{{ url('admin/categories_type/add_suggest_product') }}" enctype="multipart/form-data">
                                        {{csrf_field()}}

                                        <input name="type" type="hidden" value="{{ $type }}">
                                        <input name="active" type="hidden" value="1">

                                        <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                            <label class="control-label" for="name">{{ __('strings.suggest_product_arabic_name') }}</label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                            <label class="control-label" for="name_en">{{ __('strings.suggest_product_english_name') }}</label>
                                            <input type="text" class="form-control" name="name_en" value="{{ old('name_en') }}" required>
                                            @if ($errors->has('name_en'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-md-4 form-group{{$errors->has('classification') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                            <label class="control-label" for="classification">{{ __('strings.classification') }}</label>
                                            <select class="form-control js-select" name="classification" required id="classification">
                                                <option value="0">@lang('strings.select')</option>
                                                @foreach(App\CategoriesType::where(['type' => 2, 'org_id' => Auth::user()->org_id])->get() as $v)
                                                    <option {{ old('classification') == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{   app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('classification'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('classification') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-md-4 form-group{{$errors->has('categories') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                            <label class="control-label" for="categories">@lang('strings.catory')</label>
                                            <select class="form-control js-select" name="categories" id="services" required>
                                            </select>
                                            @if ($errors->has('categories'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('categories') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                        <div class="col-md-4 form-group{{$errors->has('suggest_product') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                            <label class="control-label" for="suggest_product">{{ __('strings.suggest_product') }}</label>
                                            <select class="form-control selectpicker" name="suggest_product[]" required title="@lang('strings.suggest_product')" data-live-search="true" data-actions-box="true">
                                                @foreach($list as $v)
                                                    <option {{ old('suggest_product') == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{   app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('suggest_product'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('suggest_product') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                    <!--<div class="col-md-4 form-group{{$errors->has('barcode') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>-->
                                    <!--    <label class="control-label" for="barcode">{{ __('strings.Barcode') }}</label>-->
                                    <!--    <input type="text" class="form-control" name="barcode" value="{{ old('barcode') }}" required>-->
                                    <!--    @if ($errors->has('barcode'))-->
                                        <!--        <span class="help-block">-->
                                    <!--            <strong class="text-danger">{{ $errors->first('barcode') }}</strong>-->
                                        <!--        </span>-->
                                        <!--    @endif-->
                                        <!--</div>-->

                                        <div class="col-md-12 form-group text-right">
                                            <button type="submit" class="btn btn-primary btn-lg" id="submit"> @lang('strings.Save') </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif(Request::is('admin/categories_type/suggest_product/*/edit'))
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">

                                </div>
                                <div class="panel-body">
                                    <form method="post" action="{{ url('admin/categories_type/edit_suggest_product', $data->id) }}" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        <input name="active" type="hidden" value="1">

                                        <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                            <label class="control-label" for="name">{{ __('strings.suggest_product_arabic_name') }}</label>
                                            <input type="text" class="form-control" name="name" value="{{ $data->name }}" required>
                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                            <label class="control-label" for="name_en">{{ __('strings.suggest_product_english_name') }}</label>
                                            <input type="text" class="form-control" name="name_en" value="{{ $data->name_en }}" required>
                                            @if ($errors->has('name_en'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-md-4 form-group{{$errors->has('classification') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                            <label class="control-label" for="classification">{{ __('strings.classification') }}</label>
                                            <select class="form-control js-select" name="classification" required id="classification">
                                                <option value="0">@lang('strings.select')</option>
                                                @foreach(App\CategoriesType::where(['type' => 2, 'org_id' => Auth::user()->org_id])->get() as $v)
                                                    <option {{ $data->category_type_id == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{   app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('classification'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('classification') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-md-4 form-group{{$errors->has('categories') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                            <label class="control-label" for="categories">@lang('strings.all_services')</label>
                                            <select class="form-control js-select" name="categories" id="services" required>
                                                @foreach(App\Category::where(['category_type_id' => $data->category_type_id])->get() as $v)
                                                    <option {{ App\CategoryDetails::where(['cat_id' =>  $data->id, 'catsub_id' => $v->id])->exists() ? 'selected' : '' }} value="{{ $v->id }}">{{   app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('categories'))
                                                <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('categories') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                        <div class="col-md-4 form-group{{$errors->has('suggest_product') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                            <label class="control-label" for="suggest_product">{{ __('strings.suggest_product') }}</label>
                                            <select class="form-control selectpicker" name="suggest_product[]" required title="@lang('strings.suggest_product')" data-live-search="true" data-actions-box="true">
                                                @foreach($list as $v)
                                                    <option {{ App\CategoryDetails::where(['cat_id' =>  $data->id, 'catsub_id' => $v->id])->exists() ? 'selected' : '' }} value="{{ $v->id }}">{{   app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('suggest_product'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('suggest_product') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                    <!--<div class="col-md-4 form-group{{$errors->has('barcode') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                            <label class="control-label" for="barcode">{{ __('strings.Barcode') }}</label>
                                            <input type="text" class="form-control" name="barcode" value="{{ $data->barcode }}" required>
                                            @if ($errors->has('barcode'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('barcode') }}</strong>
                                                </span>
                                            @endif
                                            </div>-->

                                        <div class="col-md-12 form-group text-right">
                                            <button type="submit" class="btn btn-primary btn-lg" id="submit"> @lang('strings.Save') </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(count($types) == 0)
                    @if(Request::is('admin/categories_type/suggestion'))
                        <center> <h4 class="panel-title">@lang('strings.suggestion_empty')</h4> </center>
                    @endif
                @else
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">@if($type == null) @lang('strings.categories_and_services') @else {{ $type == 1 ? __('strings.categories') : __('strings.services') }} @endif</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">

                                @if(Request::is('admin/categories_type/items/offers') || Request::is('admin/categories_type/offers'))
                                    <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@lang('strings.Item_name')</th>
                                            <th>@lang('strings.Offer_price')</th>
                                            <th>@lang('strings.Date_fromm')</th>
                                            <th>@lang('strings.Date_too')</th>
                                            <th>@lang('strings.Status')</th>
                                            @if(permissions('offers_edit') == 1)
                                                <th>@lang('strings.Settings')</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($types as $value)
                                            @php
                                                $category = App\Category::where('id', $value->cat_id)->first();
                                                $CategoriesType = App\CategoriesType::where('id', $category->category_type_id)->value('type');
                                            @endphp

                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ app()->getLocale() == 'ar' ? $category->name : $category->name_en }}</td>
                                                <td>{{ Decimalplace($value->offer_price) }}</td>
                                                <td>{{ Dateformat($value->date_from) }}</td>
                                                <td>{{ Dateformat($value->date_to) }}</td>
                                                <td>
                                                    @if($value->active)
                                                        <span class="label label-success"
                                                              style="font-size:12px;">{{ __('strings.Active') }}</span>
                                                    @else
                                                        <span class="label label-danger"
                                                              style="font-size:12px;">{{ __('strings.Deactivate') }}</span>
                                                    @endif
                                                </td>
                                                @if(permissions('offers_edit') == 1)
                                                    <td>
                                                        @if($type == null)
                                                            <a href="{{ url('admin/offers/'. $CategoriesType .'/'.$value->id.'/edit') }}"
                                                               class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                               data-placement="bottom" title="" data-original-title="تعديل"><i
                                                                        class="fa fa-pencil"></i></a>
                                                        @else
                                                            <a href="{{ url('admin/offers/'. $type .'/'.$value->id.'/edit') }}"
                                                               class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                               data-placement="bottom" title="" data-original-title="تعديل"><i
                                                                        class="fa fa-pencil"></i></a>
                                                    @endif


                                                    {{--<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $value->id }}"><i class="fa fa-trash-o"></i></a>--}}
                                                    <!-- Category Delete Modal -->
                                                        <div id="{{ $value->id }}" class="modal fade" role="dialog"
                                                             data-keyboard="false" data-backdrop="static">
                                                            <div class="modal-dialog modal-md">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal">
                                                                            &times;
                                                                        </button>
                                                                        <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>{{ __('backend.delete_category_message') }}</p>
                                                                    </div>
                                                                    <form method="post" action="{{ route('offers.destroy', $value->id) }}">
                                                                        <div class="modal-footer">
                                                                            {{csrf_field()}}
                                                                            {{ method_field('DELETE') }}
                                                                            <button type="submit" class="btn btn-primary">{{ __('backend.delete_btn') }}</button>
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('backend.no') }}</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @elseif(Request::is('admin/categories_type/suggestion'))
                                    <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                        <tr>
                                            <!--<th></th>
                                            <th>#</th>-->
                                            <th>@lang('strings.edit')</th>
                                            <th>{{ __('strings.service') }}</th>
                                            <th>{{ __('strings.suggest_product') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($types as $value)
                                            @php
                                                $category_type = App\CategoriesType::where('id', $value->category_type_id)->first();
                                                $details = App\CategoryDetails::where('cat_id', $value->id)->get();
                                            @endphp
                                            <tr>
                                            <!--<td class="suggestion-details-control"></td>
                                                <td>{{ $value->id }}</td>-->
                                                <td>
                                                    <a href="{{ url('admin/categories_type/suggest_product/'.$value->id.'/edit') }}" target="_blank" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="تعديل">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    @foreach($details as $va)
                                                        @if(App\Category::where('id', $va->catsub_id)->first()->type->type == 2)
                                                            {{ app()->getLocale() == 'ar' ? App\Category::where('id', $va->catsub_id)->value('name') : App\Category::where('id', $va->catsub_id)->value('name_en') }}
                                                        @endif
                                                    @endforeach
                                                </td>

                                                <td>
                                                    @foreach($details as $va)
                                                        @if(App\Category::where('id', $va->catsub_id)->first()->type->type == 1)
                                                            {{ app()->getLocale() == 'ar' ? App\Category::where('id', $va->catsub_id)->value('name') : App\Category::where('id', $va->catsub_id)->value('name_en') }}
                                                        @endif
                                                    @endforeach
                                                </td>


                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th style="color:white; width:0px; display:none "></th>
                                            <th>{{ __('strings.Arabic_name') }}</th>
                                            <th>{{ __('strings.English_name') }}</th>
                                            <th>{{ __('strings.Status') }}</th>
                                            @if(permissions('categories_type_edit') == 1)
                                                <th>{{ __('strings.Settings') }}</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($types as $value)
                                      
                                            <tr>
                                                <td class="details-control"></td>
                                                <td style="color:white; width:0px; display:none ">{{ $value->id }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->name_en }}</td>
                                                <td>
                                                    @if($value->active)
                                                        <span class="label label-success"
                                                              style="font-size:12px;">{{ __('strings.Active') }}</span>
                                                    @else
                                                        <span class="label label-danger"
                                                              style="font-size:12px;">{{ __('strings.Deactivate') }}</span>
                                                    @endif
                                                </td>
                                                @if(permissions('categories_type_edit') == 1)

                                                    <td>
                                                        @if($type == null)
                                                            <!--<a href="{{ url('admin/categories_type/'. $value->type .'/'.$value->id.'/edit') }}" target="_blank"-->
                                                            <!--   class="btn btn-primary btn-xs" data-toggle="tooltip"-->
                                                            <!--   data-placement="bottom" title="" data-original-title="تعديل">-->
                                                            <!--    <i class="fa fa-pencil"></i></a>-->
                                                            <button  class="btn btn-primary btn-xs" id="update_button{{$value->id}}" onclick="modal_show({{$value->id}})" data-name="{{$value->name}}"  data-name_en="{{$value->name_en}}" data-description="{{$value->description}}"   data-id="{{$value->id}}"  data-description_en="{{$value->description_en}}"  data-toggle="modal" data-target="#update_cat_type" ><i  class="fa fa-pencil"></i></button>
                                                        @else
                                                            <a href="{{ url('admin/categories_type/'. $type .'/'.$value->id.'/edit') }}" target="_blank"
                                                               class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                               data-placement="bottom" title="" data-original-title="تعديل">
                                                                <i class="fa fa-pencil"></i></a>
                                                        @endif
                                                        <a class="btn btn-danger btn-xs" data-toggle="modal"
                                                           data-target="#{{ $value->id }}"><i class="fa fa-trash-o"></i></a>

                                                        <!-- Delete Modal -->
                                                        <div id="{{ $value->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                            <div class="modal-dialog modal-md">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal"> &times;
                                                                        </button>
                                                                        <h4 class="modal-title">{{ __('strings.confirm') }}</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>{{ __('strings.delete_modal_message') }}</p>
                                                                    </div>
                                                                    <form method="post" action="{{ route('categories_type.destroy', $value->id) }}">
                                                                        <div class="modal-footer" style="text-align:center">
                                                                            {{csrf_field()}}
                                                                            {{ method_field('DELETE') }}
                                                                            <button type="submit" class="btn btn-default btn-lg" style="background-color: #e01616; color: #fcf8e3;">{{ __('strings.delete_btn') }}</button>
                                                                            <button type="button" class="btn btn-default" style="background-color: #479a1d; color: #fcf8e3;" data-dismiss="modal">{{ __('strings.no') }}</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                {{ $types->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.10/js/bootstrap-select.min.js"></script>

    <script>
        function format(d) {
            var table1;
            var programs = '';
            if (d != []) {
                $.each(d, function (key, item) {
                    if(item.grouped != 2){
                        programs += '<tr>';
                        programs += '<td>' + item.name + '</td>';
                        programs += '<td>' + item.name_en + '</td>';
                        if(item.type == 1){
                            programs += '<td>' + item.brand + '</td>';
                            programs += '<td>' + item.volume + '</td>';
                            programs += '<td>' + item.lastprice + '</td>';
                        }
                        programs += '<td> <a href="#" onclick="add_price(event, '+ item.id +')" \n' +
                            '                                                           class="btn btn-primary btn-xs" data-toggle="tooltip"\n' +
                            '                                                           data-placement="bottom" title="" data-original-title="اضافة سعر"><i\n' +
                            '                                                                    class="fa fa-money"></i></a>@if($type == null)\n' +
                            '                                                        <a href="#" onclick="open_edit(event, '+ item.id +', '+ item.type +')" \n' +
                            '                                                           class="btn btn-primary btn-xs" data-toggle="tooltip"\n' +
                            '                                                           data-placement="bottom" title="" data-original-title="تعديل"><i\n' +
                            '                                                                    class="fa fa-pencil"></i></a>\n' +
                            '                                                    @else\n' +
                            '                                                        <a href="#" onclick="open_edit(event, '+ item.id +', {{ $type }})" \n' +
                            '                                                           class="btn btn-primary btn-xs" data-toggle="tooltip"\n' +
                            '                                                           data-placement="bottom" title="" data-original-title="تعديل"><i\n' +
                            '                                                                    class="fa fa-pencil"></i></a>\n' +
                            '                                                    @endif<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#' + item.id + '"><i class="fa fa-trash-o"></i></a>\n' +
                            '\n' +
                            '                                        <!-- Delete Modal -->\n' +
                            '                                            <div id="' + item.id + '" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">\n' +
                            '                                                <div class="modal-dialog">\n' +
                            '                                                    <!-- Modal content-->\n' +
                            '                                                    <div class="modal-content">\n' +
                            '                                                        <div class="modal-header">\n' +
                            '                                                            <button type="button" class="close" data-dismiss="modal"> &times; </button>\n' +
                            '                                                            <h4 class="modal-title">{{ __('strings.confirm') }}</h4>\n' +
                            '                                                        </div>\n' +
                            '                                                        <div class="modal-body">\n' +
                            '                                                            <p>{{ __('strings.delete_modal_message') }}</p>\n' +
                            '                                                        </div>\n' +
                            '                                                        <form method="post" action="{{ url('admin/categories') }}/' + item.id + '/destroy">\n' +
                            '                                                            <div class="modal-footer">\n' +
                            '                                                                {{csrf_field()}}\n' +
                            '                                                                {{ method_field('DELETE') }}\n' +
                            '                                                                <button type="submit" class="btn btn-danger">{{ __('strings.delete_btn') }}</button>\n' +
                            '                                                                <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('strings.no') }}</button>\n' +
                            '                                                            </div>\n' +
                            '                                                        </form>\n' +
                            '                                                    </div>\n' +
                            '                                                </div>\n' +
                            '                                            </div>\n</td>';
                        programs += '</tr>';
                    }
                });
            }

            table1 = '<table class="table">\n' +
                '\t\t\t\t\t\t\t<thead>\n' +
                '\t\t\t\t\t\t\t\t<tr>\n' +
                '\t\t\t\t\t\t\t\t\t<th>@lang('strings.Arabic_name')</th>\n' +
                '\t\t\t\t\t\t\t\t\t<th>@lang('strings.English_name')</th>\n' +
                    @if(Request::is('admin/categories_type/items'))
                        '\t\t\t\t\t\t\t\t\t<th>@lang('strings.brand')</th>\n' +
                '\t\t\t\t\t\t\t\t\t<th>@lang('strings.volume')</th>\n' +
                '\t\t\t\t\t\t\t\t\t<th>@lang('strings.price')</th>\n' +
                    @endif
                        '\t\t\t\t\t\t\t\t\t<th>@lang('strings.Settings')</th>\n' +
                '\t\t\t\t\t\t\t\t</tr>\n' +
                '\t\t\t\t\t\t\t</thead>\n' +
                '\t\t\t\t\t\t\t<tbody>\n' +
                programs +
                '\t\t\t\t\t\t\t</tbody>\n' +
                '\t\t\t\t\t\t</table>';


            return table1
        }

        function format2(d) {
            var table1;
            var programs = '';
            if (d != []) {
                $.each(d, function (key, item) {
                    programs += '<tr>';
                    programs += '<td style="width: 195px;" >' + item.id + '</td>';
                    programs += '<td>' + item.name + '</td>';
                    programs += '<td>' + item.type + '</td>';
                });
            }

            table1 = '<table class="table">\n' +
                '\t\t\t\t\t\t\t<thead>\n' +
                '\t\t\t\t\t\t\t\t<tr>\n' +
                '\t\t\t\t\t\t\t\t\t<th>#</th>\n' +
                '\t\t\t\t\t\t\t\t\t<th>@lang('strings.name')</th>\n' +
                '\t\t\t\t\t\t\t\t\t<th>@lang('strings.Type')</th>\n' +
                '\t\t\t\t\t\t\t\t</tr>\n' +
                '\t\t\t\t\t\t\t</thead>\n' +
                '\t\t\t\t\t\t\t<tbody>\n' +
                programs +
                '\t\t\t\t\t\t\t</tbody>\n' +
                '\t\t\t\t\t\t</table>';


            return table1
        }



        $(document).ready(function () {

            $('#add_cat_type_submit').click(function () {
                $("#add_cat_type_store").ajaxForm({
                    url: siteUrl + '/admin/categories_type/store', type: 'post',
                    beforeSubmit: function (response) {
                        /*if (iti.isValidNumber() == false) {
                            alert("Please check your phone again");
                            return false;
                        }*/
                    },
                    success: function (response) {
                        $('#addcat_type').modal('toggle');
                        location.reload();

                    }
                })
            });

            $('input[name="type"]').val($('#modal_button').data('type'));
            var table = $('#xtreme-table').DataTable();
            $.fn.dataTable.ext.errMode = 'none';
            $('#xtreme-table tbody').on('click', 'td.suggestion-details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    $.get("{{ url('admin/categories_type/suggestion-details/') }}/" + row.data()[1], function (data) {
                        row.child(format2(data)).show();
                    });
                    tr.addClass('shown');
                }
            });

            $('#xtreme-table tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    $.get("{{ url('admin/offers/get-categories/') }}/" + row.data()[1], function (data) {
                        row.child(format(data)).show();
                    });
                    tr.addClass('shown');
                }
            });
        });

        $(document).on('click', '.open-modal', function () {
            jQuery('#open-modal').modal('show', {backdrop: 'true'});
            $.ajax({
                url: '{{ url('admin/ajax/categories_modal') }}/1',
                success: function (response) {
                    jQuery('#open-modal .modal-body').html(response);
                }
            });
            return false;
        });


        $(document).on('click', '.open-modal-2', function () {
            jQuery('#open-modal').modal('show', {backdrop: 'true'});
            $.ajax({
                url: '{{ url('admin/ajax/categories_modal') }}/2',
                success: function (response) {
                    jQuery('#open-modal .modal-body').html(response);
                }
            });
            return false;
        });

        $("#classification").change(function () {
            $.get("{{ url('admin/offers/get-categories/') }}/" + this.value, function (data) {
                $("#services").empty();
                $("#services").append("<option value='0'> @lang('strings.all_services')</option>");
                $.each(data, function (key, value) {
                    $("#services").append("<option value='" + value.id + "'>" + @if(app()->getLocale() == 'ar') value.name @else value.name_en @endif + "</option>");
                });
            });
        });
        $('.selectpicker').selectpicker({
            selectAllText: 'اختر الكل',
            deselectAllText: 'الغاء الكل'
        });

        function open_edit(e, id, type) {
            console.log('id '+ id +' type '+ type);
            jQuery('#open-modal').modal('show', {backdrop: 'true'});

            $.ajax({
                url: '{{ url('admin/ajax/category_modal') }}/'+ id + '/' + type,
                success: function (response) {
                    jQuery('#open-modal .modal-body').html(response);
                }
            });
            return false;
        }
        
   function modal_show(id){
  
  $('input[name="name"]').val($('#update_button'+id).data('name'));
  $('input[name="id"]').val($('#update_button'+id).data('id'));
  $('input[name="name_en"]').val($('#update_button'+id).data('name_en'));
  $('input[name="description"]').val($('#update_button'+id).data('description'));
  $('input[name="description_en"]').val($('#update_button'+id).data('description_en'));
  
 }

function add_price(e, id) {
            jQuery('#open-modal').modal('show', {backdrop: 'true'});

            $.ajax({
                url: '{{ url('admin/ajax/price_modal') }}?cat_id='+ id,
                success: function (response) {
                    jQuery('#open-modal .modal-body').html(response);
                }
            });
            return false;
        }
        
    </script>
@endsection