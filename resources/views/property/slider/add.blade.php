@extends('layouts.admin', ['title' => __('strings.property_slider_show') ])
@section('content')
    <style>
        td.details-control {
            background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/css/intlTelInput.css" rel="stylesheet" />
    <div id="main-wrapper">
        <div class="row">
            <!-- Modal content-->
            <div class="modal-body" style="overflow: hidden">
                <div class="" style=" text-align: center !important;">
                    <h1>{{ __('strings.property_slider_show_title') }}</h1>
                    <br>
                    <h2 ><strong>{{app()->getLocale() == 'ar'? $property->name :$property->name_en}}</strong></h2>
                </div>
                <hr>
                <br>
                <form method="post" action="{{url('admin/property/slider/add')}}" enctype="multipart/form-data">
                    {{csrf_field()}}


                    <div class="col-md-6 form-group{{$errors->has('image') ? ' has-error' : ''}}">

                        <label for="image"  class="control-label">@lang('strings.Photo')</label>
                        <input type="file" id="image" name="image" data-min-width="500" data-min-height="400" >
                        
                          <span class="help-block">
                                    <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 500*400</strong>
                           </span>
                        <hr>
                        @if ($errors->has('image'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-6 form-group{{$errors->has('rank') ? ' has-error' : ''}}"> <strong class="text-danger"></strong>
                        <label class="control-label" for="rank">{{ __('strings.rank') }}</label>
                        <input type="number" class="form-control" name="rank" id="rank" value="{{old('rank')}}">
                        @if ($errors->has('rank'))
                            <span class="help-block">
                             <strong class="text-danger">{{ $errors->first('rank') }}</strong>
                           </span>
                        @endif
                    </div>

                    <input type="hidden" name="property" value="{{$property->id}}">

                    <div class="col-md-12 form-group text-right">
                        <button type="submit" class="btn btn-primary btn-lg">{{ __('strings.Save') }}</button>
                    </div>
                </form>
            </div>


        </div>
    </div>
    
    <script src="{{asset('js/jquery.checkImageSize.min.js')}}"></script>
    <script> 
       
          $("input[type='file']").checkImageSize({
              minWidth: $(this).data('min-width'),
              minHeight: $(this).data('min-height'),
            showError:true,
            ignoreError:false
           });
        
    </script>

@endsection








