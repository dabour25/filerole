@extends('layouts.admin', ['title' => __('strings.add') ])

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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />



<div class="modal fade newModel" id="addclient" role="dialog">
       <div class="modal-dialog">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
           </div>
           <!-- Modal content-->
           <div class="modal-content">
               <div class="modal-body" style="overflow: hidden">
                   <form method="post" action="{{url('admin/add_destinations')}}" enctype="multipart/form-data">
                       {{csrf_field()}}
                       <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                           <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                           <input type="text" class="form-control" name="name" value="{{old('name')}}" required>
                           @if ($errors->has('name'))
                               <span class="help-block">
                                   <strong class="text-danger">{{ $errors->first('name') }}</strong>
                               </span>
                           @endif
                       </div>

                       <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                           <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                           <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}" required>
                           @if ($errors->has('name_en'))
                               <span class="help-block">
                                   <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                               </span>
                           @endif
                       </div>

                       <div class="col-md-6 form-group{{$errors->has('description') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                           <label class="control-label" for="description_ar">{{ __('strings.description_ar') }}</label>
                           <input type="text" class="form-control" name="description" value="{{old('description')}}">
                           @if ($errors->has('description'))
                               <span class="help-block">
                                   <strong class="text-danger">{{ $errors->first('description') }}</strong>
                               </span>
                           @endif
                       </div>


                       <div class="col-md-6 form-group{{$errors->has('description_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                           <label class="control-label" for="address">{{ __('strings.description_en') }}</label>
                           <input type="text" class="form-control" name="description_en" value="{{old('description_en')}}" >
                           @if ($errors->has('description_en'))
                               <span class="help-block">
                                   <strong class="text-danger">{{ $errors->first('description_en') }}</strong>
                               </span>
                           @endif
                       </div>

                       <div class="col-md-6 form-group{{$errors->has('longitude') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                           <label class="control-label" for="longitude">{{ __('strings.line_ve') }}</label>
                           <input type="text" class="form-control" name="longitude" id="" value="{{old('')}}" required>
                           @if ($errors->has('longitude'))
                               <span class="help-block">
                                   <strong class="text-danger">{{ $errors->first('longitude') }}</strong>
                               </span>
                           @endif
                       </div>
                       <div class="col-md-6 form-group{{$errors->has('latitude') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                           <label class="control-label" for="latitude">{{ __('strings.line_he') }}</label>
                           <input type="text" class="form-control" name="latitude" id="latitude" value="{{old('latitude')}}" required>
                           @if ($errors->has('latitude'))
                               <span class="help-block">
                                   <strong class="text-danger">{{ $errors->first('latitude') }}</strong>
                               </span>
                           @endif
                       </div>
                       <div class="col-md-6 form-group{{$errors->has('price_start') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                           <label class="control-label" for="price_start">{{ __('strings.start_price') }}</label>
                           <input type="text" class="form-control" name="price_start" id="price_start" value="{{old('price_start')}}" required>
                           @if ($errors->has('price_start'))
                               <span class="help-block">
                                   <strong class="text-danger">{{ $errors->first('price_start') }}</strong>
                               </span>
                           @endif
                       </div>
                      <div class="col-md-6 form-group{{$errors->has('currency_id') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                        <div class="form-group">
                        <label class="control-label" for="currency_id">{{ __('strings.currency') }}</label>
                          <div class="form-field">
                            <i class="icon icon-arrow-down3"></i>
                            <select name="currency_id" id="currency_id" class="form-control js-select2s">
                              @foreach($currencies as $currency)
                              <option value="{{$currency->id}}">{{ app()->getLocale()== 'ar' ? $currency->name :$currency->name_en}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                       <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                        <label class="control-label" for="active">{{ __('strings.Status') }}</label>
                        <select class="form-control" name="active" required>
                            <option value="1">{{ __('strings.Active') }}</option>
                            <option value="0">{{ __('strings.Deactivate') }}</option>
                        </select>
                        @if ($errors->has('Status'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('Status') }}</strong>
                            </span>
                        @endif
                       </div>
                       <div class="col-md-6 form-group{{$errors->has('infrontpage') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                        <label class="control-label" for="infrontpage">{{ __('strings.front_page') }}</label>
                        <select class="form-control" name="infrontpage" required>
                            <option value="1">{{ __('strings.Yes') }}</option>
                            <option value="0">{{ __('strings.No') }}</option>
                        </select>
                        @if ($errors->has('infrontpage'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('infrontpage') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6 form-group{{$errors->has('video') ? ' has-error' : ''}}">
                        <label class="control-label">@lang('strings.video')</label>
                        <input type="file" class="form-control" name="video" id="video" value="{{old('video')}}" >
                        @if ($errors->has('video'))
                            <span class="help-block">
                                <strong class="text-danger">{{ $errors->first('video') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="col-md-6 form-group{{$errors->has('image') ? ' has-error' : ''}}">
                           <label for="image"  class="control-label">@lang('strings.Photo')</label>
                           <input type="file" id="image"name="image" data-min-width="200" data-min-height="150" >
                           <span class="help-block">
                              <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 200*150</strong>
                          </span>
                           <hr>
                           @if ($errors->has('image'))
                              <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('image') }}</strong>
                              </span>
                            @endif
                         </div>
                       <div class="col-md-12 form-group text-right">
                           <button type="submit" class="btn btn-primary btn-lg">{{ __('strings.Save') }}</button>
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
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('strings.add')}}</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                      <form method="post" action="{{url('admin/save_locations')}}" enctype="multipart/form-data">
                          {{csrf_field()}}
                          <div class="col-md-6 form-group{{$errors->has('destination_name') ? ' has-error' : ''}}">
                           <label  class="text-center">@lang('strings.destination_name')</label>
                           <select class="js-select New_select" name="destination_id" id="destination_id" required="required">
                                @foreach($destinations as $destination)
                         <option value="{{ $destination->id }}">{{ app()->getLocale() == 'ar' ? $destination->name : $destination->name_en }}</option>
                                 @endforeach
                                  </select>
                                  <button type="button" class="btn btn-info btn-lg NewBtn btnclient" data-toggle="modal" data-target="#addclient"><i class="fas fa-plus"></i></button>
                                  @if ($errors->has('destination_id'))
                                      <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('destination_id') }}</strong>
                                  </span>
                                  @endif
                          </div>
                          <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                              <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                              <input type="text" class="form-control" name="name" value="{{old('name')}}">
                              @if ($errors->has('name'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                  </span>
                              @endif
                          </div>

                          <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                              <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                              <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}">
                              @if ($errors->has('name_en'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                  </span>
                              @endif
                          </div>

                          <div class="col-md-6 form-group{{$errors->has('description') ? ' has-error' : ''}}">
                              <label class="control-label" for="description_ar">{{ __('strings.description_ar') }}</label>
                              <input type="text" class="form-control" name="description" value="{{old('description')}}">
                              @if ($errors->has('description'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                  </span>
                              @endif
                          </div>
                          <div class="col-md-6 form-group{{$errors->has('longitude') ? ' has-error' : ''}}">
                              <label class="control-label" for="longitude">{{ __('strings.line_ve') }}</label>
                              <input type="text" class="form-control" name="longitude" id="" value="{{old('')}}" >
                              @if ($errors->has('longitude'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('longitude') }}</strong>
                                  </span>
                              @endif
                          </div>
                          <div class="col-md-6 form-group{{$errors->has('latitude') ? ' has-error' : ''}}">
                              <label class="control-label" for="latitude">{{ __('strings.line_he') }}</label>
                              <input type="text" class="form-control" name="latitude" id="latitude" value="{{old('latitude')}}" >
                              @if ($errors->has('latitude'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('latitude') }}</strong>
                                  </span>
                              @endif
                          </div>
                          <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}">
                           <label class="control-label" for="active">{{ __('strings.Status') }}</label>
                           <select class="form-control" name="active">
                               <option value="1">{{ __('strings.Active') }}</option>
                               <option value="0">{{ __('strings.Deactivate') }}</option>
                           </select>
                           @if ($errors->has('Status'))
                               <span class="help-block">
                                   <strong class="text-danger">{{ $errors->first('Status') }}</strong>
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
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

    <script>
       $('.js-select').select2();
    </script>
    
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
