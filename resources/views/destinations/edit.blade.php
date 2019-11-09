@extends('layouts.admin', ['title' => __('strings.edit') ])

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
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">   
            
            
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">{{ __('strings.edit') }}</h4>
                </div>
                <div class="panel-body">
                  <form method="post" action="{{url('admin/update_destinations',$destination->id)}}" enctype="multipart/form-data" files ='true'>
                      {{csrf_field()}}
                      <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                          <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                          <input type="text" class="form-control" name="name" value="{{$destination->name}}" required>
                          @if ($errors->has('name'))
                              <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('name') }}</strong>
                              </span>
                          @endif
                      </div>

                      <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                          <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                          <input type="text" class="form-control" name="name_en" value="{{$destination->name_en}}" required>
                          @if ($errors->has('name_en'))
                              <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                              </span>
                          @endif
                      </div>

                      <div class="col-md-6 form-group{{$errors->has('description') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                          <label class="control-label" for="description_ar">{{ __('strings.description_ar') }}</label>
                          <input type="text" class="form-control" name="description" value="{{$destination->description}}">
                          @if ($errors->has('description'))
                              <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('description') }}</strong>
                              </span>
                          @endif
                      </div>


                      <div class="col-md-6 form-group{{$errors->has('description_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                          <label class="control-label" for="address">{{ __('strings.description_en') }}</label>
                          <input type="text" class="form-control" name="description_en" value="{{$destination->description_en}}" >
                          @if ($errors->has('description_en'))
                              <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('description_en') }}</strong>
                              </span>
                          @endif
                      </div>

                      <div class="col-md-6 form-group{{$errors->has('longitude') ? ' has-error' : ''}}"> 
                          <label class="control-label" for="longitude">{{ __('strings.line_ve') }}</label>
                          <input type="text" class="form-control" name="longitude" id="" value="{{$destination->longitude}}" >
                          @if ($errors->has('longitude'))
                              <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('longitude') }}</strong>
                              </span>
                          @endif
                      </div>
                      <div class="col-md-6 form-group{{$errors->has('latitude') ? ' has-error' : ''}}"> 
                          <label class="control-label" for="latitude">{{ __('strings.line_he') }}</label>
                          <input type="text" class="form-control" name="latitude" id="latitude" value="{{$destination->latitude}}" >
                          @if ($errors->has('latitude'))
                              <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('latitude') }}</strong>
                              </span>
                          @endif
                      </div>
                      <div class="col-md-6 form-group{{$errors->has('price_start') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                          <label class="control-label" for="price_start">{{ __('strings.start_price') }}</label>
                          <input type="text" class="form-control" name="price_start" id="price_start" value="{{$destination->price_start}}" required>
                          @if ($errors->has('price_start'))
                              <span class="help-block">
                                  <strong class="text-danger">{{ $errors->first('price_start') }}</strong>
                              </span>
                          @endif
                      </div>
                     <div class="col-md-6 form-group{{$errors->has('currency_id') ? ' has-error' : ''}}"> 
                       <div class="form-group">
                       <label class="control-label" for="currency_id">{{ __('strings.currency') }}</label>
                         <div class="form-field">
                           <i class="icon icon-arrow-down3"></i>
                           <select name="currency_id" id="currency_id" class="form-control js-select">
                              @if($destination->currency_id) 
                             <option value="{{ $destination->currency_id}}">{{ app()->getLocale() == 'ar' ? \App\Currency::findOrFail($destination->currency_id)->name  : \App\Currency::findOrFail($destination->currency_id)->name_en  }}</option>
                             @endif
                             @foreach($currencies as $currency)
                             <option value="{{$currency->id}}">{{ app()->getLocale()== 'ar' ? $currency->name :$currency->name_en}}</option>
                             @endforeach
                           </select>
                         </div>
                       </div>
                     </div>
                      <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}">
                       <label class="control-label" for="active">{{ __('strings.Status') }}</label>
                        <select class="form-control" name="active">
                           <option {{$destination->active==1?'selected':''}} value="1">{{ __('strings.Active') }}</option>
                           <option {{$destination->active==0?'selected':''}} value="0">{{ __('strings.Deactivate') }}</option>
                       </select>
                      </div>
                      <div class="col-md-6 form-group{{$errors->has('infrontpage') ? ' has-error' : ''}}">
                       <label class="control-label" for="infrontpage">{{ __('strings.front_page') }}</label>
                       <select class="form-control" name="infrontpage">
                           <option   {{$destination->infrontpage==1?'selected':''}} value="1">{{ __('strings.Yes') }}</option>
                           <option  {{$destination->infrontpage==0?'selected':''}}  value="0">{{ __('strings.No') }}</option>

                       </select>
                   </div>
                   <div class="col-md-6 form-group{{$errors->has('video_id') ? ' has-error' : ''}}"> 
                       <label class="control-label" for="video">{{ __('strings.video') }}</label>
                       <input type="file" class="form-control" name="video_id" id="video_id" >
                       @if ($errors->has('video_id'))
                           <span class="help-block">
                               <strong class="text-danger">{{ $errors->first('video') }}</strong>
                           </span>
                       @endif
                   </div>
                   @if($destination->video_id)
                   <div class="col-md-3">
                       <video width="263" src="{{ \App\Video::findOrFail($destination->video_id)->file  }}" controls></video>
                   </div>
                   @endif
                   <div class="col-md-6 form-group{{$errors->has('image') ? ' has-error' : ''}}">
                   <strong class="text-danger"></strong>
                   <label for="image"  class="control-label">@lang('strings.Photo')</label>
                    <input type="file" id="image"name="image"  data-min-width="300" data-min-height="200" >
                     <span class="help-block">
                       <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 300*200</strong>
                     </span>
                      <hr>
                    @if ($errors->has('image'))
                    <span class="help-block">
                   <strong class="text-danger">{{ $errors->first('image') }}</strong>
                    </span>
                    @endif
                  </div>
                   @if($destination->image)
                  <div class="col-md-3">
                      <img src="{{$destination->photo ? asset($destination->photo->file) : asset('images/profile-placeholder.png') }}" class="img-responsive">
                      <div class="col-md-12 form-group text-right">
                          @if(app()->getLocale()== 'ar')
                           <a onclick="return confirm('هل انتا متاكد من حذف الصوره ؟')" href="{{url('admin/del/destinations/photo/'.$destination->id)}}"><button type="button" class="btn btn-danger btn-lg">حذف</button></a>
                          @else
                           <a onclick="return confirm('Are you sure you want to delete the picture?')" href="{{url('admin/del/destinations/photo/'.$destination->id)}}"><button type="button" class="btn btn-danger btn-lg">Deleted</button></a>
                          @endif
                      </div>
                  </div>
                  @endif
                  <input type="hidden" name="url" value="{{$url}}">
                      <div class="col-md-12 form-group text-right">
                          <button type="submit" class="btn btn-primary btn-lg">{{ __('strings.Save') }}</button>
                      </div>
                  </form>
                </div>
        </div>
    </div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

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
      $('.js-select').select2();
      
  </script>
@endsection
