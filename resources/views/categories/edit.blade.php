@extends('layouts.admin', ['title' =>  __('strings.edit') ])
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')

    <div id="main-wrapper">
        <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
            {{csrf_field()}}
            {{ method_field('PATCH') }}
            <input name="active" type="hidden" value="1">
        <div class="row">
            <div class="col-md-3">
                <div class="col-md-12">
                    <img src="{{ $category->photo_id !== null ? asset(str_replace(' ', '%20', $category->photo->file)) : asset('images/profile-placeholder.png') }}" class="img-responsive">
                </div>
                <div class="col-md-12 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                    <label for="photo_id" class="control-label">@lang('strings.Upload_photo')</label>
                    <input type="file" id="photo_id" name="photo_id" data-min-width="300" data-min-height="150">
                    @if($category->photo_id !== null)
                     <a href="{{url('admin/categories/photos/del/'.$category->id)}}"  @if(app()->getLocale() == 'ar')
                                               onclick="return confirm('تأكيد حذف الصوره')"
                                               @else
                                               onclick="return confirm('Are you sure?')"
                                                    @endif><button type="button" class="btn btn-danger btn-lx">حذف الصوره</button></a>
                     @endif
                    <span class="help-block">
                       <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 300*150</strong>
                    </span>
                    <hr>
                    @if ($errors->has('photo_id'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                        </span>
                    @else
                        @if(empty($category->photo->file))
                            <span class="help-block">
                                @if($type == 1)
                                    <strong class="text-danger">@lang('strings.empty_image1')</strong>
                                @else
                                    <strong class="text-danger">@lang('strings.empty_image2')</strong>
                                @endif
                            </span>
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('strings.edit') }}</h4>
                    </div>
                    <div class="panel-body">
                            <input name="type" type="hidden" value="{{ $type }}">
                            <div class="col-md-6 form-group{{$errors->has('barcode') ? ' has-error' : ''}}" id="barcode">
                                <label class="control-label" for="barcode">{{ __('strings.Barcode') }}</label>
                                <input type="text" class="form-control" name="barcode" value="{{ $category->barcode }}">
                                @if ($errors->has('barcode'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('barcode') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('categories_type') ? ' has-error' : ''}}">
                                <label class="control-label" for="categories_type">@if($type == 1) {{ __('strings.Categories_type') }} @else {{ __('strings.Categories_type2') }} @endif</label>
                                <select class="form-control js-select" name="categories_type" id="categories_types">
                                    @foreach($categorietypes as $v)
                                        <option {{ $category->category_type_id == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{   app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('categories_type'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('categories_type') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="name">{{ $type == 1 ? __('strings.category1_name_ar') : __('strings.category2_name_ar') }}</label>
                                <input type="text" class="form-control" name="name" value="{{ $category->name}}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="name_en">{{ $type == 1 ? __('strings.category1_name_en') : __('strings.category2_name_en') }}</label>
                                <input type="text" class="form-control" name="name_en" value="{{ $category->name_en }}">
                                @if ($errors->has('name_en'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                    </span>
                                @endif
                            </div>



                            <div class="col-md-6 form-group{{$errors->has('limit') ? ' has-error' : ''}}" @if($type != 1) style="display: none" @endif>
                                <label class="control-label" for="limit">@lang('strings.Demand_limit')</label>
                                <input type="number" class="form-control" name="limit" value="{{ $category->d_limit }}">
                                @if ($errors->has('limit'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('limit') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="model col-md-6 form-group{{$errors->has('cloths') ? ' has-error' : ''}}" @if($type != 3) style="display: none" @endif>
                                <label class="control-label" for="cloths">@lang('strings.Cloth_type')</label>
                                <select class="form-control" name="cloths" id="cloths">
                                    @foreach($cloths as $vv)
                                        <option {{ $vv->id  == $category->cloth_id ? 'selected' : '' }} value="{{ $vv->id }}">{{ app()->getLocale() == 'ar' ?  $vv->name : $vv->name_en }}</option>
                                     @endforeach
                                </select>
                                @if ($errors->has('cloths'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('cloths') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="model col-md-6 form-group{{$errors->has('preparation') ? ' has-error' : ''}}" @if($type != 3) style="display: none" @endif>
                                <label class="control-label" for="preparation">@lang('strings.Preparation')</label>
                                <input type="number" class="form-control" name="preparation" value="{{ $category->req_days }}">
                                @if ($errors->has('preparation'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('preparation') }}</strong>
                                    </span>
                                @endif
                            </div>

                            @if($type == 1)
                            <div class="col-md-6 form-group">
                                <label for="category_brand" class="control-label">@lang('strings.volume')</label>
                                <input type="text" class="form-control" name="volume" value="{{$category->volume}}">
                                </div>
                                <div class="col-md-6 form-group{{$errors->has('unit') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                    <label class="control-label" for="unit">@lang('strings.Unit')</label>
                                    <select class="form-control" name="unit">
                                        <option {{ $category->cat_unit == 1 ? 'selected' : '' }} value="1">@lang('strings.Units')</option>
                                        <option {{ $category->cat_unit == 2 ? 'selected' : '' }} value="2">@lang('strings.Count')</option>
                                        <option {{ $category->cat_unit == 3 ? 'selected' : '' }} value="3">@lang('strings.Kg')</option>
                                        <option {{ $category->cat_unit == 4 ? 'selected' : '' }} value="4">@lang('strings.G')</option>
                                        <option {{ $category->cat_unit == 5 ? 'selected' : '' }} value="5">@lang('strings.Meter')</option>
                                        <option {{ $category->cat_unit == 6 ? 'selected' : '' }} value="6">@lang('strings.CM')</option>
                                        <option {{ $category->cat_unit == 7 ? 'selected' : '' }} value="7">@lang('strings.Liter')</option>
                                        <option {{ $category->cat_unit == 8 ? 'selected' : '' }} value="8">@lang('strings.Box')</option>
                                        <option {{ $category->cat_unit == 9 ? 'selected' : '' }} value="9">@lang('strings.Ton')</option>
                                        <option {{ $category->cat_unit == 10 ? 'selected' : '' }} value="10">@lang('strings.Else')</option>
                                    </select>
                                    @if ($errors->has('unit'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('unit') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <div class="col-md-6 form-group{{$errors->has('color') ? ' has-error' : ''}}" @if($type != 4) style="display: none" @endif>
                                <label class="control-label" for="color">@lang('strings.Color')</label>
                                <select class="form-control" name="color">
                                    <option value="0">@lang('strings.Select_color')</option>
                                    <option {{ $category->color == 1 ? 'selected' : '' }} value="1">@lang('strings.Red')</option>
                                    <option {{ $category->color == 2 ? 'selected' : '' }} value="2">@lang('strings.Yellow')</option>
                                    <option {{ $category->color == 3 ? 'selected' : '' }} value="3">@lang('strings.Green')</option>
                                    <option {{ $category->color == 4 ? 'selected' : '' }} value="4">@lang('strings.Blue')</option>
                                    <option {{ $category->color == 5 ? 'selected' : '' }} value="5">@lang('strings.Black')</option>
                                    <option {{ $category->color == 6 ? 'selected' : '' }} value="6">@lang('strings.White')</option>
                                    <option {{ $category->color == 7 ? 'selected' : '' }} value="7">@lang('strings.Gray')</option>
                                    <option {{ $category->color == 8 ? 'selected' : '' }} value="8">@lang('strings.Orange')</option>
                                    <option {{ $category->color == 9 ? 'selected' : '' }} value="9">@lang('strings.Purple')</option>
                                    <option {{ $category->color == 10 ? 'selected' : '' }} value="10">@lang('strings.Else')</option>
                                </select>

                                @if ($errors->has('color'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('color') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <!--<div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="active">@lang('strings.Status')</label>
                                <select class="form-control" name="active">
                                    <option {{ $category->active == 1 ? 'selected' : '' }} value="1">@lang('strings.Active')</option>
                                    <option {{ $category->active == 0 ? 'selected' : '' }} value="0">@lang('strings.Deactivate')</option>
                                </select>
                                @if ($errors->has('active'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('active') }}</strong>
                                    </span>
                                @endif
                            </div>-->

                            @if($type == 1)
                            <div class="model col-md-6 form-group">
                                <label class="control-label" for="preparation">@lang('strings.expected_price')</label>
                                <input type="text" class="form-control" value="" name="expected" value="{{ $category->expected_price }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="category_brand" class="control-label">@lang('strings.brand')</label>
                                <input type="text" class="form-control" name="brand" value="{{$category->brand}}">
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('stores') ? ' has-error' : ''}}">
                                <label class="control-label" for="stores">@lang('strings.Stores')</label>
                                <select class="form-control js-select" name="stores">
                                    @foreach(App\Stores::where('org_id', Auth::user()->org_id)->get() as $value)
                                        <option {{ $category->store_id == $value->id ? 'selected' : ''}} value="{{ $value->id }}"> {{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('stores'))
                                    <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('stores') }}</strong>
                                            </span>
                                @endif
                            </div>
                            @else
                                <div class="col-md-6 form-group add_f2a">
                                    <label for="time" class="control-label">@lang('strings.service_time')</label>
                                    <select class="form-control js-select" name="time">
                                        @foreach(SplitTime(date('Y-m-d 00:00:00'), date('Y-m-d 12:00:00')) as $key => $value)
                                            @if($key == 0)
                                            @else
                                                <option {{ $category->required_time == $key ? 'selected' : ''}} value="{{ $key }}">{{ $value }} @lang('strings.hour') </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            
                            
                            <div class="col-md-12 form-group"></div>
                            <div class="col-md-6 desk_New form-group{{$errors->has('description') ? ' has-error' : ''}}">
                                <label class="control-label" for="description">@lang('strings.description_ar')</label>
                                <textarea type="text" class="textall" name="description">{{ $category->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-6 desk_New form-group{{$errors->has('description_en') ? ' has-error' : ''}}">
                                <label class="control-label" for="description">@lang('strings.description_en')</label>
                                <textarea type="text" class="textall" name="description_en">{{ $category->description_en }}</textarea>
                                @if ($errors->has('description_en'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('description_en') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg">@lang('strings.Save')</button>
                                </div>
                            </div>




                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>

@endsection

@section('scripts')

<script src="{{asset('js/jquery.checkImageSize.min.js')}}"></script>
    <script> 
        $("input[type='file']").checkImageSize({
              minWidth: $(this).data('min-width'),
              minHeight: $(this).data('min-height'),
            showError:true,
            ignoreError:false
        });
        
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script>
        $(".js-example-tokenizer, .js-select").select2();
    </script>
@endsection