@extends('layouts.admin', ['title' => __('strings.add')])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')

    <div class="modal fade newModel" id="addcattype" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="overflow: hidden">
                    <form method="post" action="#" enctype="multipart/form-data" id="categories_type_store">

                        {{csrf_field()}}
                        <input name="type" value="{{ $type }}" type="hidden">
                        <input name="active" value="1" type="hidden">

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


                        <div class="col-md-12 form-group{{$errors->has('description') ? ' has-error' : ''}}">
                            <label class="control-label" for="description">{{ __('strings.Description') }}</label>
                            <textarea type="text" class="textall" name="description">{{old('description')}}</textarea>
                            @if ($errors->has('description'))
                                <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="col-md-12 form-group">
                            <button type="submit" class="btn btn-primary btn-lg" id="categories_type_submit"> {{ __('strings.Save') }} </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

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



    <div class="modal fade newModel" id="add_store" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" style="overflow: hidden">
                    <form method="post" action="#" id="stores">
                        {{csrf_field()}}
                        <input name="active" type="hidden" value="1" >
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
                            <button type="submit" class="btn btn-primary btn-lg" id="store_submit"> {{ __('strings.Save') }} </button>
                        </div>


                    </form>
                </div>
            </div>

        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <form method="post" action="{{route('categories.store')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="col-md-3">
                    <div class="col-md-12">
                        <img src="{{ asset('images/profile-placeholder.png') }}" class="img-responsive" id="blah">
                    </div>
                    <div class="col-md-12 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                        <label for="photo_id" class="control-label">@lang('strings.Upload_photo')</label>
                        <input type="file" id="photo_id" name="photo_id" onchange="readURL(this);" data-min-width="300" data-min-height="150">
                          <span class="help-block">
                              <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 300*150</strong>
                          </span>
                         <hr>
                        @if ($errors->has('photo_id'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                            </span>
                        @else
                            <span class="help-block">
                                @if($type == 1)
                                    <strong class="text-danger">@lang('strings.empty_image1')</strong>
                                @else
                                    <strong class="text-danger">@lang('strings.empty_image2')</strong>
                                @endif
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <div class="col-md-12">
                                <h4 class="panel-title">{{ __('strings.add') }}</h4>
                            </div>
                        </div>
                        <div class="panel-body">

                                <input type="hidden" name="type" value="{{ $type }}">
                                <div class="row">
                                    <div class="col-md-6 add_f2a form-group{{$errors->has('categories_type') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                        <label class="control-label" for="categories_type">@if($type == 1) {{ __('strings.Categories_type') }} @else {{ __('strings.Categories_type2') }} @endif</label>
                                        <select class="form-control js-select" name="categories_type" id="categories_typess" required>
                                                <option value="">@lang('strings.select')</option>
                                                @foreach(App\CategoriesType::where(['type' => $type, 'active' => 1, 'org_id' => Auth::user()->org_id])->get() as $value)
                                                     <option {{ old('categories_type') == $value->id ? 'selected' : ''}} value="{{ $value->id }}">{{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</option>
                                                @endforeach
                                        </select>
                                        <button type="button" class="btn btn-info btn-lg NewBtn" data-toggle="modal" data-target="#addcattype"><i class="fas fa-plus"></i></button>
                                        @if ($errors->has('categories_type'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('categories_type') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="name">{{ $type == 1 ? __('strings.category1_name_ar') : __('strings.category2_name_ar') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="name_en">{{ $type == 1 ? __('strings.category1_name_en') : __('strings.category2_name_en') }}</label>
                                    <input type="text" class="form-control" name="name_en" value="{{old('name_en') }}" required>
                                    @if ($errors->has('name_en'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="col-md-6 form-group{{$errors->has('barcode') ? ' has-error' : ''}}">
                                    <label class="control-label" for="barcode">{{ __('strings.Barcode') }}</label>
                                    <input type="text" class="form-control" name="barcode" value="{{ old('barcode') }}">
                                    @if ($errors->has('barcode'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('barcode') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                @if($type == 1)
                                <div class="items col-md-6 form-group{{$errors->has('limit') ? ' has-error' : ''}}" required>
                                    <label class="control-label" for="limit">@lang('strings.Demand_limit')</label>
                                    <input type="number" class="form-control" name="limit" value="{{ old('limit') }}">
                                    @if ($errors->has('limit'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('limit') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                @endif
                                <div class="model col-md-6 form-group{{$errors->has('cloths') ? ' has-error' : ''}}" style="display: none">
                                    <label class="control-label" for="cloths">@lang('strings.Cloth_type')</label>
                                    <select class="form-control select" name="cloths" id="cloths">

                                    </select>
                                    @if ($errors->has('cloths'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('cloths') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="model col-md-6 form-group{{$errors->has('preparation') ? ' has-error' : ''}}" style="display: none">
                                    <label class="control-label" for="preparation">@lang('strings.Preparation')</label>
                                    <input type="number" class="form-control" name="preparation" value="{{ old('preparation') }}">
                                    @if ($errors->has('preparation'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('preparation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 form-group">
                                <label for="photo_id" class="control-label">@lang('strings.selling_price')</label>
                                <input type="text" class="form-control" name="selling" value="{{ old('selling') }}">
                            </div>
                            <div class="col-md-6 form-group add_f2a">
                                    <label for="photo_id" class="control-label">@lang('strings.Tax')</label>
                                    <select class="form-control js-select" name="tax" id="select-tax">
                                        <option value="0">@lang('strings.select')</option>
                                        @foreach(App\Tax::where(['active' => 1, 'org_id' => Auth::user()->org_id])->get() as $value)
                                            <option {{ old('tax') == $value->id ? 'selected' : ''}} value="{{ $value->id }}">{{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-info btn-lg NewBtn" data-toggle="modal" data-target="#add_taxs"><i class="fas fa-plus"></i></button>
                                </div>
                                
                                
                                @if($type == 1)
                                <div class="col-md-6 form-group">
                                <label for="category_brand" class="control-label">@lang('strings.volume')</label>
                                <input type="text" class="form-control" name="volume" value="{{old('volume')}}">
                                </div>
                                <div class="items col-md-6 form-group{{$errors->has('unit') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="unit">@lang('strings.Unit')</label>
                                    <select class="form-control js-select" name="unit" required>
                                        <option {{ old('unit') == 0 ? 'selected' : ''}}  value="0">@lang('strings.Unit_select')</option>
                                        <option {{ old('unit') == 1 ? 'selected' : 'selected'}} value="1">@lang('strings.Units')</option>
                                        <option {{ old('unit') == 2 ? 'selected' : ''}}  value="2">@lang('strings.Count')</option>
                                        <option {{ old('unit') == 3 ? 'selected' : ''}}  value="3">@lang('strings.Kg')</option>
                                        <option {{ old('unit') == 4 ? 'selected' : ''}}  value="4">@lang('strings.G')</option>
                                        <option {{ old('unit') == 5 ? 'selected' : ''}}  value="5">@lang('strings.Meter')</option>
                                        <option {{ old('unit') == 6 ? 'selected' : ''}}  value="6">@lang('strings.CM')</option>
                                        <option {{ old('unit') == 7 ? 'selected' : ''}}  value="7">@lang('strings.Liter')</option>
                                        <option {{ old('unit') == 8 ? 'selected' : ''}}  value="8">@lang('strings.Box')</option>
                                        <option {{ old('unit') == 9 ? 'selected' : ''}}  value="9">@lang('strings.Ton')</option>
                                        <option {{ old('unit') == 10 ? 'selected' : ''}}  value="10">@lang('strings.Kg_l')</option>
                                        <option {{ old('unit') == 11 ? 'selected' : ''}}  value="11">@lang('strings.Kg_d')</option>
                                        <option {{ old('unit') == 12 ? 'selected' : ''}}  value="12">@lang('strings.Else')</option>
                                    </select>
                                    @if ($errors->has('unit'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('unit') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!--<div class="model col-md-6 form-group">
                                    <label class="control-label" for="preparation">@lang('strings.expected_price')</label>
                                    <input type="text" class="form-control" value="" name="expected" value="{{ old('expected') }}">
                                    @if ($errors->has('preparation'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('preparation') }}</strong>
                                        </span>
                                    @endif
                                </div>-->
                                @endif
                                <div class="cloth col-md-6 form-group{{$errors->has('color') ? ' has-error' : ''}}" style="display: none">
                                    <label class="control-label" for="color">@lang('strings.Color')</label>

                                    <select class="form-control js-select" name="color">
                                        <option {{ old('color') == 0 ? 'selected' : ''}} value="0">@lang('strings.Select_color')</option>
                                        <option {{ old('color') == 1 ? 'selected' : ''}} value="1">@lang('strings.Red')</option>
                                        <option {{ old('color') == 2 ? 'selected' : ''}} value="2">@lang('strings.Yellow')</option>
                                        <option {{ old('color') == 3 ? 'selected' : ''}} value="3">@lang('strings.Green')</option>
                                        <option {{ old('color') == 4 ? 'selected' : ''}} value="4">@lang('strings.Blue')</option>
                                        <option {{ old('color') == 5 ? 'selected' : ''}} value="5">@lang('strings.Black')</option>
                                        <option {{ old('color') == 6 ? 'selected' : ''}} value="6">@lang('strings.White')</option>
                                        <option {{ old('color') == 7 ? 'selected' : ''}} value="7">@lang('strings.Gray')</option>
                                        <option {{ old('color') == 8 ? 'selected' : ''}} value="8">@lang('strings.Orange')</option>
                                        <option {{ old('color') == 9 ? 'selected' : ''}} value="9">@lang('strings.Purple')</option>
                                        <option {{ old('color') == 10 ? 'selected' : ''}} value="10">@lang('strings.Else')</option>
                                    </select>

                                    @if ($errors->has('color'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('color') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <input name="active" type="hidden" value="1">


                                

                                @if($type == 2)
                                    <div class="col-md-6 form-group add_f2a">
                                        <label for="time" class="control-label">@lang('strings.service_time')</label>
                                        <select class="form-control js-select" name="time">
                                            @foreach(SplitTime(date('Y-m-d 00:00:00'), date('Y-m-d 12:00:00')) as $key => $value)
                                                @if($key == 0)
                                                @else
                                                    <option {{ old('time') == $key ? 'selected' : ''}} value="{{ $key }}">{{ $value }} @lang('strings.hour') </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                
                                @if($type == 1)
                                <div class="col-md-6 form-group">
                                <label for="category_brand" class="control-label">@lang('strings.brand')</label>
                                <input type="text" class="form-control" name="brand" value="{{old('brand')}}">
                                </div>
                                <div class="col-md-6 form-group{{$errors->has('stores') ? ' has-error' : ''}}">
                                    <label class="control-label" for="stores">@lang('strings.Stores')</label>
                                    <select class="form-control js-select" name="stores" id="select-store">
                                        @foreach(App\Stores::where('org_id', Auth::user()->org_id)->get() as $value)
                                            <option {{ old('stores') == $value->id ? 'selected' : ''}} value="{{ $value->id }}"> {{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-info btn-lg NewBtn" data-toggle="modal" data-target="#add_store"><i class="fas fa-plus"></i></button>

                                @if ($errors->has('stores'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('stores') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="col-md-12 form-group"></div>
                                @endif
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

                                <div class="col-md-12 form-group text-right">
                                    <button type="submit" class="btn btn-primary btn-lg"> @lang('strings.Save') </button>
                                </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
     <script src="{{asset('js/jquery.checkImageSize.min.js')}}"></script>
    <script> 
        $("input[type='file']").checkImageSize({
              minWidth: $(this).data('min-width'),
              minHeight: $(this).data('min-height'),
            showError:true,
            ignoreError:false
        });
        
    </script>
    <script>
        $(".js-example-tokenizer, .js-select").select2();
        $("#tax_type").change(function () {
            if (this.value == 1) {
                $('.value').show();
                $('#tax-value').attr("required");
                $('#tax-percent').removeAttr("required");
                $('.percent').hide();
            } else if (this.value == 2) {
                $('.percent').show();
                $('#tax-percent').attr("required");
                $('#tax-value').removeAttr("required");
                $('.value').hide();
            } else {
                $('.value').hide();
                $('.percent').hide();
                $('#tax-percent').removeAttr("required");
                $('#tax-value').removeAttr("required");
            }
        });

        $('#taxs_submit').click(function() {
            if($("#tax_type").val() == 0){
                alert("Please select tax type first");
            }
            $("#taxs").ajaxForm({url: '{{ url('admin/ajax/tax') }}', type: 'post',
                success: function (response) {
                    $('#add_taxs').modal('toggle');
                    $("#select-tax").append("<option selected value='" + response.data.id + "'>" + @if(app()->getLocale() == 'ar') response.data.name @else response.data.name_en @endif + "</option>");
                },
                error: function (response) {
                    alert("Please check your entry date again");
                }
            })
        });

        $('#store_submit').click(function() {
            $("#stores").ajaxForm({url: '{{ url('admin/ajax/add_store') }}', type: 'post',
                success: function (response) {
                    $('#add_store').modal('toggle');
                    $("#select-store").append("<option selected value='" + response.data.id + "'>" + @if(app()->getLocale() == 'ar') response.data.name @else response.data.name_en @endif + "</option>");
                },
                error: function (response) {
                    alert("Please check your entry date again");
                }
            })
        });

        $('#categories_type_submit').click(function() {
            $("#categories_type_store").ajaxForm({url: '{{ url('admin/ajax/categories_type') }}', type: 'post',
                success: function (response) {
                    $('#addcattype').modal('toggle');
                    $("#categories_typess").append("<option selected value='" + response.data.id + "'>" + @if(app()->getLocale() == 'ar') response.data.name @else response.data.name_en @endif + "</option>");
                },
                error: function (response) {
                    alert("Please check your entry date again");
                }
            })
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
    
                reader.onload = function (e) {
                    $('#blah')
                    .attr('src', e.target.result)
                };
    
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection