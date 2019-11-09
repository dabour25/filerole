@extends('layouts.admin', ['title' => __('strings.stores_report_title') ])

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">

    <div class="page-title">
        <h3>@lang('strings.stores_report_title') </h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>
                <li class="active">@lang('strings.stores_report_title')</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-body">

                        <form action="" enctype="multipart/form-data" id="add">
                            {{csrf_field()}}

                            <div class="col-lg-4 col-md-4 col-sm-6 m-b-sm form-group{{$errors->has('types') ? ' has-error' : ''}}">
                                <label class="control-label" for="types">{{ __('strings.Type') }}</label>
                                <select class="form-control" name="types" id="type">
                                    <option value="0">{{ __('strings.All') }}</option>
                                    <option value="1">{{ __('strings.Item') }}</option>
                                    <option value="4">{{ __('strings.Clothe') }}</option>
                                </select>
                                @if ($errors->has('types'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('types') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 m-b-sm form-group{{$errors->has('categories_type') ? ' has-error' : ''}}">
                                <label class="control-label" for="categories_type">@lang('strings.Categories_type')</label>
                                <select class="form-control" name="categories_type" id="categories_types">

                                </select>
                                @if ($errors->has('categories_type'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('categories_type') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 m-b-sm form-group{{$errors->has('categories') ? ' has-error' : ''}}">
                                <label class="control-label" for="categories">@lang('strings.Item')</label>
                                <select class="form-control" name="categories" id="categories">

                                </select>
                                @if ($errors->has('categories'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('categories') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 m-b-sm">
                                <label>@lang('strings.Stores')</label>
                                <select class="form-control" name="stores">
                                    <option value="0">@lang('strings.All')</option>
                                    @foreach(App\Stores::where(['active' => 1,'org_id' => Auth::user()->org_id])->get() as $role)
                                        <option {{ app('request')->input('search_name') == $role->id ? 'selected' : ''}} value="{{$role->id}}">{{ app()->getLocale() == 'ar' ? $role->name : $role->name_en}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 m-b-sm">
                                <div class="input-group text">
                                    <label>@lang('strings.Date_fromm')</label>
                                    <input name="search_date_from" type="text" class="form-control datepicker" autocomplete="off" value="{{ app('request')->input('search_date_from') }}">
                                </div>

                                @if (\Session::has('message'))
                                    <span class="help-block">
                                        <strong class="text-danger">{!! \Session::get('message') !!}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 m-b-sm">
                                <div class="input-group text">
                                    <label>@lang('strings.Date_too')</label>
                                    <input name="search_date_to" type="text" class="form-control datepicker" autocomplete="off" value="{{ app('request')->input('search_date_to') }}" id="">
                                </div>
                            </div>

                            <div class="col-md-12 form-group text-right">
                                <button name="save" type="submit" class="btn btn-primary btn-lg" value="1">{{ __('strings.Search') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-body">
                        <div class="table-responsive">
                           @php
                               if(!empty($categories) && $categories != 0){
                                  $CategoriesType = App\Category::where(['id' => $categories])->get();
                               }elseif (!empty($categories_type) && $categories_type != 0){
                                  $CategoriesType = App\CategoriesType::where(['id' => $categories_type])->get();
                               }

                               if(is_array($types)){
                                  $CategoriesType = App\CategoriesType::where(['org_id' => Auth::user()->org_id])->whereIn('type', $types)->get();
                               }else{
                                  $CategoriesType = App\CategoriesType::where(['type' => $types])->get();
                               }
                           @endphp

                           @foreach($CategoriesType as $type)
                                @php
                                    if(!empty($categories) && $categories != 0){
                                        $categoriess = App\Category::where(['id' => $categories])->get();
                                    }else{
                                        $categoriess = App\Category::where(['category_type_id' => $type->id])->get();
                                    }
                                @endphp

                                @foreach ($categoriess as $category)
                                    @php
                                       $total_category = 0; $total = 0; $total_price = 0;

                                       if(!empty($date_from) && empty($date_to)){
                                            $transactions = App\Transactions::where(['cat_id' => $category->id])->whereDate('date', $date_from)->get();
                                       }elseif (empty($date_from) && !empty($date_to)){
                                            $transactions = App\Transactions::where(['cat_id' => $category->id])->whereDate('date', $date_to)->get();
                                       }elseif (!empty($date_to) && !empty($date_from)){
                                            $transactions = App\Transactions::where(['cat_id' => $category->id])->whereBetween('date', [$date_from , $date_to])->get();
                                       }elseif(empty($date_from) && empty($date_to) && $stores == 0){
                                           $transactions = App\Transactions::where(['cat_id' => $category->id])->whereBetween('date', [date('Y-m-d') , date('Y-m-d')])->get();
                                       }elseif ($stores != 0){
                                            $transactions = App\Transactions::where(['cat_id' => $category->id, 'store_id' => $stores])->get();
                                       }

                                       if(count($transactions) != 0){
                                           foreach ($transactions as $value){
                                               $total_price += $value->price * $value->quantity * $value->req_flag;
                                               $total +=  ($value->quantity * $value->req_flag);
                                           }
                                       }

                                       if(empty($date_from) && empty($date_to)){
                                            $count_after = App\Transactions::where(['cat_id' => $category->id])->where('date' ,'>', date('Y-m-d'))->select(DB::raw('sum(quantity * req_flag) as total'))->value('total');
                                            $count_before = App\Transactions::where(['cat_id' => $category->id])->where('date' ,'<', date('Y-m-d'))->select(DB::raw('sum(quantity * req_flag) as total'))->value('total');
                                       }else{
                                           $count_after = App\Transactions::where(['cat_id' => $category->id])->where('date' ,'>', $date_to)->select(DB::raw('sum(quantity * req_flag) as total'))->value('total');
                                           $count_before = App\Transactions::where(['cat_id' => $category->id])->where('date' ,'<', $date_from)->select(DB::raw('sum(quantity * req_flag) as total'))->value('total');
                                       }
                                    @endphp
                                    <h3>{{ __('strings.Barcode') }}: {{ $category->barcode }} - {{ __('strings.Item_name') }}: {{ $category->name }}  - {{ __('strings.Item_categories_type') }}: {{ $category->type->name }} - @lang('strings.count_before'):  {{ abs($count_before)  }} </h3>

                                    <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                            <tr>
                                                <th>{{ __('strings.Date') }}</th>
                                                <th>{{ __('strings.Quantity') }}</th>
                                                <th>{{ __('strings.Amount') }}</th>
                                                <th>{{ __('strings.Description') }}</th>
                                                <th>{{ __('strings.Name') }}</th>
                                                <th>{{ __('strings.Number') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($transactions as $value)
                                                <tr>
                                                    <td>{{ $value->date }}</td>
                                                    <td>{{ $value->quantity * $value->req_flag }}</td>
                                                    <td>{{ abs($value->price * $value->quantity * $value->req_flag) }}</td>
                                                    <td>{{ $value->description }}</td>
                                                    <td>@if(!empty($value->supplier_id) && $value->supplier_id != 0) {{ app()->getLocale() == 'ar' ? App\Suppliers::findOrFail($value->supplier_id)->name : App\Suppliers::findOrFail($value->supplier_id)->name_en }} @elseif(!empty($value->cust_id) && $value->cust_id != 0) {{ app()->getLocale() == 'ar' ? App\Customers::findOrFail($value->cust_id)->name : App\Customers::findOrFail($value->cust_id)->name_en }} @elseif(!empty($value->damage_id) && $value->damage_id != 0) {{  app()->getLocale() == 'ar' ? App\User::findOrFail(App\Damaged::findOrFail($value->damage_id)->supervisor_id)->name : App\User::findOrFail(App\Damaged::findOrFail($value->damage_id)->supervisor_id)->name_en }} @endif </td>
                                                    <td>@if(!empty($value->cust_req_id)) {{ $value->cust_req_id }} @elseif(!empty($value->supplier_id)) {{ App\PermissionReceiving::where(['id' => $value->permission_receiving_id,'supplier_id' => $value->supplier_id])->value('supp_invoice_no')  }} @elseif(!empty($value->damage_id)) {{ $value->damage_id }} @endif</td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td>@lang('strings.count_after')  {{ $count_after }}</td>
                                                <td>{{ __('strings.SumTotal_price') }} {{ $total_price }}</td>
                                                <td>{{ __('strings.Total_transactions') }} {{ $total }}</td>
                                                <td>@lang('strings.Total_items') {{ ($count_after +  $count_before + $total) == 0 ? 0 : ($count_after +  $count_before + $total)  }} </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script>

        $(".datepicker").datepicker({defaultDate: null, @if(app()->getLocale() == 'ar')  rtl: true @endif });
        $('.js-select').select2({
            minimumInputLength: 2,
        });
    </script>
@endsection
@section('scripts')
    <script>
        $("#type").change(function () {
            $.get( "{{ url('admin/categories/get-type/') }}/" + this.value, function( data ) {
                $("#categories_types").empty();
                $("#categories").empty();
                $("#categories_types").append("<option value='0'> @lang('strings.All')</option>");
                $.each(data, function(key, value) {
                    $("#categories_types").append("<option value='" + value.id + "'>" + @if(app()->getLocale() == 'ar') value.name @else value.name_en @endif + "</option>");
                });

            });
        });

        $("#categories_types").change(function () {
            $.get("{{ url('admin/offers/get-categories/') }}/" + this.value, function (data) {
                $("#categories").empty();
                $("#categories").append("<option value='0'> @lang('strings.All')</option>");
                $.each(data, function (key, value) {
                    $("#categories").append("<option value='" + value.id + "'>" + @if(app()->getLocale() == 'ar') value.name @else value.name_en @endif + "</option>");
                });
            });
        });

    </script>
@endsection