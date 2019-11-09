<form method="post" action="#" enctype="multipart/form-data" id="categories_edit">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <div class="col-md-12">
                    <h4 class="panel-title">{{ $type == 1 ? __('strings.Categories_edit') : __('strings.Categories_edit_service') }}</h4>
                </div>
            </div>
            <div class="panel-body">
                <input type="hidden" name="id" value="{{ $data->id }}">
                <input type="hidden" name="type" value="{{ $type }}">
                <input name="active" type="hidden" value="1">

                <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                    <label class="control-label" for="name">{{ $type == 1 ? __('strings.category1_name_ar') : __('strings.category2_name_ar') }}</label>
                    <input type="text" class="form-control" name="name" value="{{ $data->name }}" required>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                    <label class="control-label" for="name_en">{{  $type == 1 ? __('strings.category1_name_en') : __('strings.category2_name_en')}}</label>
                    <input type="text" class="form-control" name="name_en" value="{{ $data->name_en }}" required>
                    @if ($errors->has('name_en'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="col-md-6 form-group{{$errors->has('barcode') ? ' has-error' : ''}}">
                    <label class="control-label" for="barcode">{{ __('strings.Barcode') }}</label>
                    <input type="text" class="form-control" name="barcode" value="{{ $data->barcode }}">
                    @if ($errors->has('barcode'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('barcode') }}</strong>
                        </span>
                    @endif
                </div>
                @if($type == 2)
                    <div class="col-md-6 form-group add_f2a">
                        <label for="time" class="control-label">@lang('strings.service_time')</label>
                        <select class="form-control js-select" name="time">
                            @foreach(SplitTime(date('Y-m-d 00:00:00'), date('Y-m-d 12:00:00')) as $key => $value)
                                @if($key == 0)
                                @else
                                    <option {{ $data->required_time == $key ? 'selected' : ''}} value="{{ $key }}">{{ $value }} @lang('strings.hour') </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                        <label for="photo_id" class="control-label">@lang('strings.Upload_photo')</label>
                        <input type="file" id="photo_id" name="photo_id">
                        @if ($errors->has('photo_id'))
                            <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="photo_id" class="control-label">@lang('strings.View_photo')</label>
                        <img src="{{ $data->photo_id !== null ? asset($data->photo->file) : asset('images/profile-placeholder.png') }}" class="img-responsive">
                    </div>
                @endif
                @if($type == 1)
                <div class="col-md-6 form-group">
                    <label for="category_brand" class="control-label">@lang('strings.brand')</label>
                    <input type="text" class="form-control" name="brand" value="{{ $data->brand }}">
                </div>
                <div class="col-md-6 form-group">
                    <label for="category_brand" class="control-label">@lang('strings.volume')</label>
                    <input type="text" class="form-control" name="volume" value="{{ $data->volume }}">
                </div>
                <div class="items col-md-6 form-group{{$errors->has('limit') ? ' has-error' : ''}}" required>
                    <label class="control-label" for="limit">@lang('strings.Demand_limit')</label>
                    <input type="number" class="form-control" name="limit" value="{{ $data->d_limit }}">
                    @if ($errors->has('limit'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('limit') }}</strong>
                        </span>
                    @endif
                </div>
                
                <div class="items col-md-6 form-group{{$errors->has('unit') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                    <label class="control-label" for="unit">@lang('strings.Unit')</label>
                    <select class="form-control js-select" name="unit" required>
                        <option {{ $data->cat_unit == 0 ? 'selected' : ''}}  value="0">@lang('strings.Unit_select')</option>
                        <option {{ $data->cat_unit == 1 ? 'selected' : 'selected'}} value="1">@lang('strings.Units')</option>
                        <option {{ $data->cat_unit == 2 ? 'selected' : ''}}  value="2">@lang('strings.Count')</option>
                        <option {{ $data->cat_unit == 3 ? 'selected' : ''}}  value="3">@lang('strings.Kg')</option>
                        <option {{ $data->cat_unit == 4 ? 'selected' : ''}}  value="4">@lang('strings.G')</option>
                        <option {{ $data->cat_unit == 5 ? 'selected' : ''}}  value="5">@lang('strings.Meter')</option>
                        <option {{ $data->cat_unit == 6 ? 'selected' : ''}}  value="6">@lang('strings.CM')</option>
                        <option {{ $data->cat_unit == 7 ? 'selected' : ''}}  value="7">@lang('strings.Liter')</option>
                        <option {{ $data->cat_unit == 8 ? 'selected' : ''}}  value="8">@lang('strings.Box')</option>
                        <option {{ $data->cat_unit == 9 ? 'selected' : ''}}  value="9">@lang('strings.Ton')</option>
                        <option {{ $data->cat_unit == 10 ? 'selected' : ''}}  value="10">@lang('strings.Else')</option>
                    </select>
                    @if ($errors->has('unit'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('unit') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="col-md-6 form-group{{$errors->has('stores') ? ' has-error' : ''}}">
                    <label class="control-label" for="stores">@lang('strings.Stores')</label>
                    <select class="form-control js-select" name="stores" id="select-store">
                        @foreach(App\Stores::where('org_id', Auth::user()->org_id)->get() as $value)
                            <option {{ $data->store_id == $value->id ? 'selected' : ''}} value="{{ $value->id }}"> {{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('stores'))
                        <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('stores') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-md-6 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
                    <label for="photo_id" class="control-label">@lang('strings.Upload_photo')</label>
                    <input type="file" id="photo_id" name="photo_id" data-min-width="500" data-min-height="400">
                    @if ($errors->has('photo_id'))
                        <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('photo_id') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="col-md-6 form-group">
                    <label for="photo_id" class="control-label">@lang('strings.View_photo')</label>
                    <img src="{{ $data->photo_id !== null ? asset($data->photo->file) : asset('images/profile-placeholder.png') }}" class="img-responsive">
                </div>
                @endif
                <div class="col-md-12"></div>
                <div class="col-md-6 desk_New form-group{{$errors->has('description') ? ' has-error' : ''}}">
                    <label class="control-label" for="description">@lang('strings.description_ar')</label>
                    <textarea type="text" class="textall" name="description">{{ $data->description }}</textarea>
                    @if ($errors->has('description'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="col-md-6 desk_New form-group{{$errors->has('description_en') ? ' has-error' : ''}}">
                    <label class="control-label" for="description">@lang('strings.description_en')</label>
                    <textarea type="text" class="textall" name="description_en">{{ $data->description_en }}</textarea>
                    @if ($errors->has('description_en'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('description_en') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="col-md-12 form-group text-right">
                    <button type="submit" class="btn btn-primary btn-lg" id="categories_submit"> @lang('strings.Save') </button>
                </div>
            </div>
        </div>
    </div>
</form>


  <script src="{{asset('js/jquery.checkImageSize.min.js')}}"></script>
<script>
   $("input[name='photo_id']").checkImageSize({

            minWidth:500,
            minHeight:400,
            showError:true,
            ignoreError:false
        });

    $('#categories_submit').click(function() {
        $("#categories_edit").ajaxForm({url: '{{ url('admin/ajax/edit_categories') }}', type: 'post', data: $('#categories_edit').serialize(),
            success: function (response) {
                $('#open-modal').modal('toggle');
                alert(response.message);
            },
            error: function (response) {
                alert("Please check your entry date again");
            }
        })
    });
</script>
