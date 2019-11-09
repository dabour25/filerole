@extends('layouts.admin', ['title' => __('strings.destinations') ])
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
    <!--<div class="page-title">-->
    <!--    <h3>{{ __('strings.Categories_type') }}</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>-->
    <!--            <li class="active">{{ __('strings.Categories_type') }}</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    
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

                           <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"><strong class="text-danger">*</strong>
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

                           <div class="col-md-6 form-group{{$errors->has('longitude') ? ' has-error' : ''}}"> 
                               <label class="control-label" for="longitude">{{ __('strings.line_ve') }}</label>
                               <input type="text" class="form-control" name="longitude" id="" value="{{old('longitude')}}">
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
                           <div class="col-md-6 form-group{{$errors->has('price_start') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                               <label class="control-label" for="price_start">{{ __('strings.start_price') }}</label>
                               <input type="text" class="form-control" name="price_start" id="price_start" value="{{old('price_start')}}" required>
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
 					 											<select name="currency_id" id="currency_id" class="form-control js-select2">
 																	@foreach($currencies as $currency)
 					 												<option value="{{$currency->id}}">{{ app()->getLocale()== 'ar' ? $currency->name :$currency->name_en}}</option>
 																	@endforeach
 					 											</select>
 					 										</div>
 					 									</div>
 					 								</div>
                           <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}"> 
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
                           <div class="col-md-6 form-group{{$errors->has('infrontpage') ? ' has-error' : ''}}"> 
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
                                                                    <input type="file" id="image"name="image" >
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

             @include('alerts.index')


                      <style>
                          .btn-primary:hover {
                              background: #2c9d6f !important;
                          }
                      </style>
                     
                      <div class="alert_new">
                          <span class="alertIcon">
                              <i class="fas fa-exclamation-circle"></i>
                           </span>
                          <p>
                              @if (app()->getLocale() == 'ar')
            {{ DB::table('function_new')->where('id',231)->value('description') }}
            @else
            {{ DB::table('function_new')->where('id',231)->value('description_en') }}
            @endif
                          </p>
                          <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                          </a>
                      </div>
                      </br>
                       @if(count($destinations)==0)
                    
                      <h2><strong>لا توجد جهات حالية من فصلك اضاف جهة</strong></h2>
                          
                        
                          @endif
                            </br>  </br>
                      <form method="get" action="{{url('admin/search')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                      <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                            
                                            <select class="form-control js-select" name="destination_name"  >
                                               <option value="0" >@lang('strings.destination_name')</option>
                                            @foreach($destinations as $destination)
                                            <option {{ app('request')->input('destination_name') == $destination->id ? 'selected' : ''}}  value="{{$destination->name}}">{{ app()->getLocale() == 'ar' ? $destination->name  : $destination->name_en  }}</option>
                                                @endforeach
                                            </select>                                        </div>
                                        <button id="search_button" type="submit"  onclick="" class="btn btn-primary btn-lg">@lang('strings.Search')</button>
                      </form>
                    </br>
                        <button type="button" class="btn btn-primary btn-lg NewBtn btnclient" data-toggle="modal" data-target="#addclient">@lang('strings.create_destinations')</button>


                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">@lang('strings.destinations')</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('strings.Arabic_name') }}</th>
                                            <th>{{ __('strings.English_name') }}</th>
                                            <th>@lang('strings.Settings')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($destinations as $value)
                                        <tr>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->name_en }}</td>
                                            <td>
                              <a href="edit_destinations/{{ $value->id }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title=""  data-original-title="{{ __('strings.edit') }} "> <i  class="fa fa-pencil"></i></a>
                              <!-- <a href="delete_destinations/{{ $value->id }}" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ __('strings.delete_btn') }}"> <i class="fa fa-trash-o"></i></a> -->
                                            </td>
                                          </tr>
                                            @endforeach
                                          </tbody>
                                        </table>


            </div>
        </div>
    </div>
  </div>
</div>

   <script>
      $('.js-select').select2();
      
  </script>
@endsection
