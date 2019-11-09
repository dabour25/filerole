@extends('layouts.admin', ['title' => __('strings.stores_value_report_title') ])

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
    <!--<div class="page-title">-->
    <!--    <h3>@lang('strings.stores_value_report_title') </h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>-->
    <!--            <li class="active">@lang('strings.stores_value_report_title')</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-body">

                        <form action="" enctype="multipart/form-data" id="add">
                            {{csrf_field()}}
                            <div class="col-lg-6"></div>
                            <div class="col-lg-6 col-md-4 col-sm-6 m-b-sm form-group{{$errors->has('stores') ? ' has-error' : ''}}">
                                <label class="control-label" for="stores">{{ __('strings.Stores') }}</label>
                                <select class="form-control" name="stores" id="type">
                                    <option value="0">{{ __('strings.All') }}</option>
                                    @foreach(App\Stores::where(['org_id' => Auth::user()->org_id, 'active' => 1])->get() as $value)
                                        <option value="{{ $value->id }}">{{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('stores'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('stores') }}</strong>
                                    </span>
                                @endif
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
                           @foreach($stores as $value)
                                <h3>#{{ $value->id }} -- {{ __('strings.Name') }}: {{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</h3>
                                <br>
                                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('strings.Barcode') }}</th>
                                            <th>{{ __('strings.Name') }}</th>
                                            <th>{{ __('strings.Quantity') }}</th>
                                            <th>{{ __('strings.LastPrice') }}</th>
                                            <th>{{ __('strings.AveragePrice') }}</th>
                                            <th>{{ __('strings.TotalSale') }}</th>
                                            <th>{{ __('strings.TotalPurchase') }}</th>
                                            <th>{{ __('strings.ExpectedProfit') }}</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($transactions = App\Transactions::where(['store_id' => $value->id])->groupBy('cat_id')->get() as $v2)
                                            @php
                                                $total_price = 0; $quantity = 0; $average = 0; $average_quantity = 0;
                                                $category = App\Category::findOrFail($v2->cat_id);

                                                if(count($transactions) != 0){
                                                   foreach (App\Transactions::where(['cat_id' => $v2->cat_id])->get() as $v3){
                                                        $total_price += $v3->price * $v3->quantity * $v3->req_flag;
                                                        //$quantity += $v2->quantity * $v2->req_flag;
                                                        if($v3->description	== "اضافة مشتراة"){
                                                            $average += $v3->price * $v3->quantity;
                                                            $average_quantity += $v3->quantity;
                                                        }
                                                   }
                                                   foreach (App\Transactions::where(['store_id' => $value->id, 'cat_id' => $v2->cat_id])->get() as $v4){
                                                        $quantity += $v4->quantity * $v4->req_flag;
                                                   }
                                                }
                                                $external = App\externalReq::join('external_trans', function ($join) {
                                                    $join->on('external_req.id', '=', 'external_trans.external_req_id')
                                                        ->where('external_req.confirm', 'd');
                                                })->select('external_trans.*')->where([ 'cat_id' => $v2->cat_id ])->sum(\DB::raw('quantity * reg_flag'));

                                                $quantity = ($quantity + $external);

                                                $final_price = App\PriceList::where(['cat_id' => $v2->cat_id, 'active' => 1,'org_id' => Auth::user()->org_id ])->orderBy('date', 'desc')->value('final_price');
                                                $AveragePrice = $average != 0 ? ( $average/ $average_quantity) : 0;
                                                $TotalSale = $quantity * $final_price;
                                                $TotalPurchase = $quantity * $average != 0 ? ( $average/ $average_quantity) : 0;
                                            @endphp
                                            @if($category->type->type == 1 || $category->type->type == 4)
                                                <tr>
                                                    <td>{{ $category->id }}</td>
                                                    <td>{{ $category->barcode }}</td>
                                                    <td>{{ $category->name }}</td>
                                                    <td>{{ $quantity }}</td>
                                                    <td>{{ Decimalplace($final_price) }}</td>
                                                    <td>{{ Decimalplace($AveragePrice) }}</td>
                                                    <td>{{ Decimalplace($TotalSale) }}</td>
                                                    <td>{{ Decimalplace($quantity * $TotalPurchase) }}</td>
                                                    <td>{{ Decimalplace($TotalSale - ($quantity * $TotalPurchase)) }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
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

@endsection