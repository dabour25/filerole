<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.10/css/bootstrap-select.min.css" rel="stylesheet">
<form method="post" action="#" enctype="multipart/form-data" id="price_store">
    {{csrf_field()}}
    <div class="col-md-12">
        <div class="panel panel-white">
            <div class="panel-heading clearfix">
                <div class="col-md-12">
                    <h4 class="panel-title">{{ __('strings.Categories_add_price') }}</h4>
                </div>
            </div>
            <div class="panel-body">
                <input name="active" type="hidden" value="1">
                @if(empty($cat_id))
                <div class="col-md-6 form-group{{$errors->has('categories') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                    <label class="control-label" for="categories">@lang('strings.Categories')</label>
                    <select class="form-control selectpicker" data-live-search="true" data-actions-box="true" id="categories" name="categories" required>
                        <option value="0">@lang('strings.select')</option>
                        @foreach(App\Category::where(['active' => 1, 'org_id' => Auth::user()->org_id])->get() as $v)
                            <option {{ old('categories') == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{   app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('categories'))
                        <span class="help-block">
                            <strong class="text-danger">{{ $errors->first('categories') }}</strong>
                        </span>
                    @endif
                </div>
                @else
                    <input name="categories" type="hidden" value="{{ $cat_id }}">
                @endif

                <div class="col-md-6 form-group{{$errors->has('price') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                    <label class="control-label" for="price">@lang('strings.Price')</label>
                    <input type="text" class="form-control" name="price" value="{{old('price')}}" id="price" required>
                    @if ($errors->has('price'))
                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('price') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="col-md-6 form-group{{$errors->has('tax_type') ? ' has-error' : ''}}">
                    <label class="control-label" for="tax_type">@lang('strings.Tax_type')</label>
                    <select class="form-control selectpicker" data-live-search="true" data-actions-box="true" id="tax_type" name="tax_type" required>
                        <option value="0">@lang('strings.Select_tax_type')</option>
                        @foreach(App\Tax::where(['active' => 1, 'org_id' => Auth::user()->org_id])->get() as $v)
                            <option value="{{ $v->id }}">{{ $v->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('tax_type'))
                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('tax_type') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="col-md-6 form-group{{$errors->has('date') ? ' has-error' : ''}}">
                    <label class="control-label" for="date">@lang('strings.Date')</label>
                    <input type="date" class="form-control" name="date" id="date" required>
                    @if ($errors->has('date'))
                        <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('date') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="col-md-12 form-group text-right">
                    <button type="submit" class="btn btn-primary btn-lg" id="price_submit"> @lang('strings.Save') </button>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.10/js/bootstrap-select.min.js"></script>
<script>
    $('.selectpicker').selectpicker();
    $('#price_submit').click(function() {
        $("#price_store").ajaxForm({url: '{{ url('admin/ajax/add_price') }}', type: 'post',
            success: function (response) {
                $('#open-modal').modal('toggle');
            },
            error: function (response) {
                alert("Please check your entry date again");
            }
        })
    });
    $("#tax_type").change(function () {
        $.get("{{ url('admin/price_list/get-tax/') }}/" + this.value, function (data) {
            $("#tax").empty();
            $("#pricec").empty();
            $.each(data, function (key, value) {
                if(value.value != null){
                    var total = parseFloat($('#price').val()) + parseFloat(value.value);
                    $("#tax").append("<li>@lang('strings.Tax_value') :" +  parseFloat(value.value) + "</li>");
                    $("#tax_value").val(parseFloat(value.value));
                }else if(value.percent != null){
                    var total = Math.round(((parseFloat(value.percent) / 100) * parseFloat($('#price').val())));
                    $("#tax").append("<li>@lang('strings.Tax_value') :" +  value.percent + "</li>");
                    $("#tax_value").val(value.percent);
                }else{
                    $("#tax").empty();
                }

            });
        });
    });

    $("#date").change(function () {
        var item = $('#categories').val();
        $.get("{{ url('admin/price_list/check-price/') }}/" + item + '/' + this.value, function (data) {
            if(data == 1){
                alert('@lang('strings.Price_alert')');
            }
        });
    });
</script>