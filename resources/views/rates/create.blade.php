@extends('layouts.admin', ['title' => __('strings.add') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div id="main-wrapper">
        <div class="modal fade newModel" id="add_taxs" role="dialog">
            <div class="modal-dialog">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body" style="overflow: hidden">
                        <form method="post" action="#" id="taxs">
                            {{csrf_field()}}
                            <input name="active" type="hidden" value="1" >
                            <div class="col-md-6 col-sm-6 col-xs-12 required form-group{{$errors->has('tax_type') ? ' has-error' : ''}}">
                                <label><strong>@lang('strings.Tax_type')</strong></label>
                                <select class="form-control select" name="tax_type" id="tax_type" required>
                                    <option value="0">@lang('strings.Select_tax_type')</option>
                                    <option {{ old('tax_type') == 1 ? 'selected' : '' }}  value="1">@lang('strings.Value')</option>
                                    <option {{ old('tax_type') == 2 ? 'selected' : '' }} value="2">@lang('strings.Percentage')</option>
                                </select>
                                @if ($errors->has('tax_type'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('tax_type') }}</strong>
                                    </span>
                                @endif
                            </div>
    
    
                            <div class="col-md-6 col-sm-6 col-xs-12 required form-group{{$errors->has('name') ? ' has-error' : ''}}">
                                <label>@lang('strings.Arabic_name')</label>
                                <input class="form-control" type="text" name="name"
                                       value="{{ old('name') }}"
                                       id="tax-name" required>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                                    </span>
                                @endif
                            </div>
    
                            <div class="col-md-6 col-sm-6 col-xs-12 required form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                                <label><strong>@lang('strings.English_name')</strong></label>
                                <input class="form-control" type="text" name="name_en"
                                       value="{{ old('name_en') }}"
                                       id="tax-name-en" required>
                                @if ($errors->has('name_en'))
                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                                    </span>
                                @endif
                            </div>
    
    
    
                            <div class="percent required col-md-6 col-sm-6 col-xs-12 form-group"
                                 @if($errors->has('percent')) @else style="display: none" @endif>
                                <label><strong>@lang('strings.Percentage')</strong></label>
                                <input class="form-control" type="number" name="percent" required
                                       value="{{ old('percent') }}" id="tax-percent" max="100"
                                       min="1">
                                @if ($errors->has('percent'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('percent') }}</strong>
                                    </span>
                                @endif
                            </div>
    
                            <div class="value col-md-6 required col-sm-6 col-xs-12 form-group"
                                 @if($errors->has('value')) @else style="display: none" @endif>
                                <label><strong>@lang('strings.Tax_value')</strong></label>
                                <input class="form-control" type="number" name="value"
                                       value="{{ old('value') }}" id="tax-value" required>
                                @if ($errors->has('value'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('value') }}</strong>
                                    </span>
                                @endif
                            </div>
    
                            <div class="col-md-12 col-sm-12 col-xs-12  form-group{{$errors->has('description') ? ' has-error' : ''}}">
                                <label class="control-label"
                                       for="description">@lang('strings.Description')</label>
                                <textarea name="description" class="textall" id="tax-description"> {{ old('description') }} </textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
    
                            <div class="col-md-12 form-group">
                                <button type="submit" class="btn btn-primary btn-lg" id="taxs_submit"> {{ __('strings.Save') }} </button>
                            </div>
    
    
                        </form>
                    </div>
                </div>
    
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-white">
                    <form method="post" action="{{route('rates.store')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="panel-heading clearfix">
                            <div class="col-md-12">
                                <h4 class="panel-title">{{ __('strings.add_price')}}  - {{ app()->getLocale() == 'ar' ? App\Category::where('id', $id)->value('name') : App\Category::where('id', $id)->value('name_en') }}</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <input name="active" type="hidden" value="1">
                            <input name="categories" type="hidden" value="{{ $id }}">
                        <!--<div class="col-md-6 form-group{{$errors->has('property_hotel') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="property_hotel">@lang('strings.property_hotel')</label>
                                <select class="form-control js-select" name="property_hotel" required>
                                    <option value="0">@lang('strings.select')</option>
                                    @foreach(App\Property::where(['prop_type' => 'hotel','org_id' => Auth::user()->org_id])->get() as $v)
                            <option {{ $id == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{   app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-info btn-lg NewBtn btnclient" data-toggle="modal" data-target="#addclient"><i class="fas fa-plus"></i></button>
                            @if ($errors->has('property_hotel'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('property_hotel') }}</strong>
                                    </span>
                                @endif
                                </div>
                                <div class="col-md-6 form-group{{$errors->has('room_type') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="room_type">@lang('strings.room_type')</label>
                                <select class="form-control js-select" name="room_type" required>
                                    <option value="0">@lang('strings.select')</option>
                                    @foreach(App\CategoriesType::where(['type' => 7, 'active' => 1,'org_id' => Auth::user()->org_id])->get() as $v2)
                            <option {{ old('room_type') == $v2->id ? 'selected' : '' }} value="{{ $v2->id }}">{{ app()->getLocale() == 'ar' ? $v2->name : $v2->name_en }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-info btn-lg NewBtn btnclient" data-toggle="modal" data-target="#addclient"><i class="fas fa-plus"></i></button>
                                @if ($errors->has('room_type'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('room_type') }}</strong>
                                    </span>
                                @endif
                                </div>-->
                            <div class="col-md-6 form-group{{$errors->has('date') ? ' has-error' : ''}}">
                                <label class="control-label" for="date">@lang('strings.Date')</label>
                                <input type="date" class="form-control" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                @if ($errors->has('date'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('tax_type') ? ' has-error' : ''}}">
                                <label class="control-label" for="tax_type">@lang('strings.Tax_type')</label>
                                <select class="form-control js-select" name="tax_type" id="tax_type">
                                    <option value="0">@lang('strings.Select_tax_type')</option>
                                    @foreach($taxs as $v)
                                        <option value="{{ $v->id }}">{{ $v->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-info btn-lg NewBtn" data-toggle="modal" data-target="#add_taxs"><i class="fas fa-plus"></i></button>
                                @if ($errors->has('tax_type'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('tax_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('room_price') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="price">@lang('strings.hotel_room_price')</label>
                                <input type="number" step="any" class="form-control" name="room_price" value="{{old('room_price')}}" id="price" required>
                                @if ($errors->has('room_price'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('room_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('final_price') ? ' has-error' : ''}}">
                                <label class="control-label" for="price">@lang('strings.hotel_final_price')</label>
                                <input type="number" step="any" class="form-control" name="final_price" value="" id="final_price" readonly>
                                @if ($errors->has('final_price'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('final_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="panel-heading clearfix">
                            <div class="col-md-12">
                                <h4 class="panel-title">{{ app()->getLocale() == 'ar' ? App\CategoriesType::where(['type' => 9, 'active' => 1,'org_id' => Auth::user()->org_id])->value('name') : App\CategoriesType::where(['type' => 9, 'active' => 1,'org_id' => Auth::user()->org_id])->value('name_en') }}</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <table id="tab_items" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>@lang('strings.type')</th>
                                        <th>@lang('strings.price')</th>
                                        <th>@lang('strings.Settings')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $details = App\CategoryDetails::where('cat_id', $id)->get(); @endphp
                                    @php $count = 1; $details_count0 = 0;@endphp
                                        @foreach($details as $val)
                                            @php
                                                if(App\Category::where('id', $val2->catsub_id)->first()->type->type == 9){
                                                    $details_count0  +=1; 
                                                }
                                            @endphp
                                            @if(App\Category::where('id', $val->catsub_id)->first()->type->type == 9)
                                                <tr id='row-{{ $count }}'>
                                                    <td>
                                                        <select class="form-control" id="children-{{ $count }}" name="childrens[]" required>
                                                            <option value="0">@lang('strings.select')</option>
                                                            @php
                                                                $types = App\Category::join('categories_type', function ($join) {
                                                                    $join->on('categories_type.id', '=', 'categories.category_type_id')->where(['categories_type.type' => 9, 'categories.org_id' => Auth::user()->org_id]);
                                                                })->select('categories.*')->where(['categories.org_id' => Auth::user()->org_id])->get()
                                                            @endphp
                                                            @foreach($types as $value)
                                                                <option {{ $val->catsub_id == $value->id ? 'selected' : '' }}  value="{{ $value->id }}">{{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input name="price[]" class="form-control" type="number" value="{{ $val->price }}">
                                                    </td>
                                                    <td>
                                                        <a href="#" class="delete_row_2" data-toggle="tooltip" data-placement="bottom" data-original-title="حذف الصورة"><i class="fa fa-close"></i></a>
                                                    </td>
                                                </tr>
                                            @endif
                                            @php $count++; @endphp
                                        @endforeach
                                        @if($details_count0 == 0)
                                            <tr id='row-1'>
                                                <td>
                                                    <select class="form-control" id="children-{{ $count }}" name="childrens[]" required>
                                                        <option value="0">@lang('strings.select')</option>
                                                        @php
                                                            $types = App\Category::join('categories_type', function ($join) {
                                                                $join->on('categories_type.id', '=', 'categories.category_type_id')->where(['categories_type.type' => 9, 'categories.org_id' => Auth::user()->org_id]);
                                                            })->select('categories.*')->where(['categories.org_id' => Auth::user()->org_id])->get()
                                                        @endphp
                                                        @foreach($types as $value)
                                                            <option {{ $val->catsub_id == $value->id ? 'selected' : '' }}  value="{{ $value->id }}">{{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input name="price[]" class="form-control" type="number" value="{{ $val->price }}">
                                                </td>
                                                <td>
                                                    <a href="#" class="delete_row_2" data-toggle="tooltip" data-placement="bottom" data-original-title="حذف الصورة"><i class="fa fa-close"></i></a>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                <div class="row clearfix">
                                    <div class="col-md-12">
                                        <a href="#" onclick="addphoto(this)" class="btn btn-default pull-left">@lang('strings.add_file')</a>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel-heading clearfix">
                            <div class="col-md-12">
                                <h4 class="panel-title">{{ __('strings.hotel_prices')}}</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table id="tab_item" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>@lang('strings.type')</th>
                                    <th>@lang('strings.price')</th>
                                    <th>@lang('strings.Settings')</th>
                                </tr>
                                </thead>

                                <tbody>

                                @php $count = 1; $details_count = 0; @endphp
                                    @foreach($details as $val2)
                                        @php
                                            if(App\Category::where('id', $val2->catsub_id)->first()->type->type == 8){
                                                $details_count  +=1; 
                                            }
                                        @endphp
                                        @if(App\Category::where('id', $val2->catsub_id)->first()->type->type == 8)
                                            <tr id='row-{{ $count }}'>
                                                <td>
                                                    <select class="form-control" id="type-{{ $count }}" name="types[]" required>
                                                        <option value="0">@lang('strings.select')</option>
                                                        @php
                                                            $types = App\Category::join('categories_type', function ($join) {
                                                                $join->on('categories_type.id', '=', 'categories.category_type_id')->where(['categories_type.type' => 8, 'categories.org_id' => Auth::user()->org_id]);
                                                            })->select('categories.*')->where(['categories.org_id' => Auth::user()->org_id])->get()
                                                        @endphp
                                                        @foreach($types as $value)
                                                            <option {{ $val2->catsub_id == $value->id ? 'selected' : '' }} value="{{ $value->id }}">{{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input name="other_price[]" class="form-control" type="number" value="{{ $val2->price }}">
                                                </td>
                                                <td>
                                                    <a href="#" class="delete_row" data-toggle="tooltip" data-placement="bottom" data-original-title="حذف الصورة"><i class="fa fa-close"></i></a>
                                                </td>
                                            </tr>
                                        @endif
                                        @php $count++; @endphp
                                    @endforeach
                                    @if($details_count == 0)
                                    <tr id='row-1'>
                                        <td>
                                            <select class="form-control" id="type-1" name="types[]" required>
                                                <option value="0">@lang('strings.select')</option>
                                                @php
                                                    $types = App\Category::join('categories_type', function ($join) {
                                                        $join->on('categories_type.id', '=', 'categories.category_type_id')->where(['categories_type.type' => 8, 'categories.org_id' => Auth::user()->org_id]);
                                                    })->select('categories.*')->where(['categories.org_id' => Auth::user()->org_id])->get()
                                                @endphp
                                                @foreach($types as $value)
                                                    <option {{ $val2->catsub_id == $value->id ? 'selected' : '' }} value="{{ $value->id }}">{{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input name="other_price[]" class="form-control" type="number" value="{{ $val2->price }}">
                                        </td>
                                        <td>
                                            <a href="#" class="delete_row" data-toggle="tooltip" data-placement="bottom" data-original-title="حذف الصورة"><i class="fa fa-close"></i></a>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <a href="#" onclick="addprice(this)" class="btn btn-default pull-left">@lang('strings.add_file')</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg" id="button_submit"> @lang('strings.Save') </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script>
        function addphoto(){
            var row = $("#tab_items tr").last().clone().find('input').val('').end();
            var oldId = Number(row.attr('id').slice(-1));
            var id = 1 + oldId;
            row.attr('id', 'row-' + id );
            row.find('#children-' + oldId).attr('id', 'children-' + id);
            /*row.find('#ids-' + oldId).attr('id', 'ids-' + id).attr('value', {{ App\CategoriesType::where(['type' => 9, 'active' => 1,'org_id' => Auth::user()->org_id])->value('id') }});*/
            $('#tab_items').append(row);
        }

        function addprice(){
            var row = $("#tab_item tr").last().clone().find('input').val('').end();
            var oldId = Number(row.attr('id').slice(-1));
            var id = 1 + oldId;
            row.attr('id', 'row-' + id );

            $('#tab_item').append(row);
        }

        $(document).on('click', '.delete_row', function () {
            if($('#tab_item tbody tr').length != 1 && $(this).closest('tr').attr('id') != 'row-1') {
                $(this).closest('tr').remove();
                return false;
            }
        });
        $(document).on('click', '.delete_row_2', function () {
            if($('#tab_items tbody tr').length != 1 && $(this).closest('tr').attr('id') != 'row-1') {
                $(this).closest('tr').remove();
                return false;
            }
        });

        $( "#price, #tax_type" ).change(function() {
            $.get("{{ url('admin/rates/check-tax') }}/" + $('#tax_type :selected').val() + '/' + parseFloat($('#price').val()), function (data) {
                $('#final_price').val(data);
            });
        });
        
        $('#taxs_submit').click(function() {
            if($("#tax_type").val() == 0){
                alert("Please select tax type first");
            }
            $("#taxs").ajaxForm({url: '{{ url('admin/ajax/tax') }}', type: 'post',
                success: function (response) {
                    $('#add_taxs').modal('toggle');
                    $("#tax_type").append("<option selected value='" + response.data.id + "'>" + @if(app()->getLocale() == 'ar') response.data.name @else response.data.name_en @endif + "</option>");
                },
                error: function (response) {
                    alert("Please check your entry date again");
                }
            })
        });
    </script>
@endsection