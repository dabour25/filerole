@extends('layouts.admin', ['title' => __('strings.rooms_types') ])
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


    <div class="modal fade newModel" id="addroomType" role="dialog">
           <div class="modal-dialog">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Modal content-->
               <div class="modal-content">
                   <div class="modal-body" style="overflow: hidden">
                       <form method="post" action="{{url('admin/store_category_type')}}" enctype="multipart/form-data">
                           {{csrf_field()}}
                          <input type="hidden" name="id">
                           <div class="col-md-6 form-group{{$errors->has('unit_type') ? ' has-error' : ''}}">
                            <label  class="text-center">@lang('strings.Gender')</label>
                            <select class="New_select" onchange="show_details()" name="unit_type" id="unit_type">

                          <option value="غرفة">{{ app()->getLocale() == 'ar' ? غرفة : Room }}</option>
                          <option value="فيلا">{{ app()->getLocale() == 'ar' ? فيلا : Villa }}</option>
                          <option value="شقة">{{ app()->getLocale() == 'ar' ? شقة :Apartment }}</option>
                            </select>
                                   @if ($errors->has('destination_id'))
                                       <span class="help-block">
                                       <strong class="text-danger">{{ $errors->first('destination_id') }}</strong>
                                   </span>
                                   @endif
                           </div>
                           <div class="col-md-6 form-group{{$errors->has('kind') ? ' has-error' : ''}}">
 					 									<div class="form-group">
 					 									<label class="control-label" for="kind">{{ __('strings.types') }}</label>
 					 										<div class="form-field">

                              <select class="New_select" name="kind" id="kind">
                              <option value="للايجار">{{ app()->getLocale() == 'ar' ? للايجار : 'for rent' }}</option>
                              <option value="للبيع">{{ app()->getLocale() == 'ar' ? للبيع : 'for sell' }}</option>
                              <option value="الكل">{{ __('strings.All') }}</option>
                                </select>
 					 										</div>
 					 									</div>
 					 	</div>
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

                           <div class="col-md-6 form-group{{$errors->has('description') ? ' has-error' : ''}}">
                               <label class="control-label" for="description_ar">{{ __('strings.description_ar') }}</label>
                               <input type="text" class="form-control" name="description" value="{{old('description')}}">
                               @if ($errors->has('description'))
                                   <span class="help-block">
                                       <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                   </span>
                               @endif
                           </div>


                           <div class="col-md-6 form-group{{$errors->has('description_en') ? ' has-error' : ''}}">
                               <label class="control-label" for="address">{{ __('strings.description_en') }}</label>
                               <input type="text" class="form-control" name="description_en" value="{{old('description_en')}}" >
                               @if ($errors->has('description_en'))
                                   <span class="help-block">
                                       <strong class="text-danger">{{ $errors->first('description_en') }}</strong>
                                   </span>
                               @endif
                           </div>

                           <div class="col-md-6 form-group{{$errors->has('max_kids') ? ' has-error' : ''}}">
                               <label class="control-label" for="max_kids">{{ __('strings.max_chidren_no') }}</label>
                               <select name="max_kids" id="max_kids" class="form-control">
                                 @php
                                 for($i=1;$i<=20;$i++){
                                   echo '<option value="'.$i.'">'.$i.'</option>';
                                 }
                                 @endphp
                                  </select>
                           </div>
                           <div class="col-md-6 form-group{{$errors->has('max_adult') ? ' has-error' : ''}}">
                               <label class="control-label" for="max_adult">{{ __('strings.max_adult_no') }}</label>
                               <select name="max_adult" id="max_adult" class="form-control">
                                 @php
                                 for($i=1;$i<=20;$i++){
                                   echo '<option value="'.$i.'">'.$i.'</option>';
                                 }
                                 @endphp
                               </select>
                           </div>
                           <div class="col-md-6 form-group{{$errors->has('max_people') ? ' has-error' : ''}}">
                               <label class="control-label" for="max_people">{{ __('strings.max_people_no') }}</label>
                               <select name="max_people" id="max_people" class="form-control">
                                 @php
                                 for($i=1;$i<=20;$i++){

                                   echo '<option value="'.$i.'">'.$i.'</option>';
                                 }
                                 @endphp
                               </select>
                           </div>

                          <div id="flat_details"  style="display:none">
                            <div class="col-md-6 form-group{{$errors->has('no_rooms') ? ' has-error' : ''}}">
                              <div class="form-group">
                              <label class="control-label" for="no_rooms">{{ __('strings.rooms_no') }}</label>
                                <div class="form-field">
                        <input type="number" class="form-control" name="no_rooms" value="" >
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('no_bathrooms') ? ' has-error' : ''}}">
                              <div class="form-group">
                              <label class="control-label" for="no_bathrooms">{{ __('strings.bathroom_no') }}</label>
                                <div class="form-field">
                        <input type="number" class="form-control" name="no_bathrooms" value="{{old('no_bathrooms')}}" >
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('no_kitchen') ? ' has-error' : ''}}">
                              <div class="form-group">
                              <label class="control-label" for="no_kitchen">{{ __('strings.kitchen_no') }}</label>
                                <div class="form-field">
                        <input type="number" class="form-control" name="no_kitchen" value="{{old('no_kitchen')}}" >
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6 form-group{{$errors->has('area') ? ' has-error' : ''}}">
                              <div class="form-group">
                              <label class="control-label" for="area">{{ __('strings.area') }}</label>
                                <div class="form-field">
                        <input type="text" class="form-control" name="area" value="{{old('area')}}" >
                                </div>
                              </div>
                            </div>
                          </div>

                           <div class="col-md-6 form-group{{$errors->has('active') ? ' has-error' : ''}}">
                            <label class="control-label" for="active">{{ __('strings.Status') }}</label>
                            <select class="form-control" name="active" required>
                                <option value="1">{{ __('strings.Active') }}</option>
                                <option value="0">{{ __('strings.Deactivate') }}</option>
                            </select>
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
            {{ DB::table('function_new')->where('id',237)->value('description') }}
            @else
            {{ DB::table('function_new')->where('id',237)->value('description_en') }}
            @endif
                          </p>
                          <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                          </a>
                      </div>
                      </br>
                       @if(count($rooms_types)==0)

                      <h2><strong>توجد غرف حالية من فضلك اضاف غرفة</strong></h2>


                          @endif
                            </br>  </br>
                      <form method="get" action="{{url('admin/category_type_search')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                      <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">

                                            <select class="form-control js-select" name="rooms_types_name"  >
                                           <option value="0" >@lang('strings.All')</option>
                                            @foreach($rooms_types as $rooms_type)
                                            <option {{ app('request')->input('rooms_types_name') == $rooms_type->id ? 'selected' : ''}}  value="{{$rooms_type->id}}">{{ app()->getLocale() == 'ar' ? $rooms_type->name  : $rooms_type->name_en  }}</option>
                                                @endforeach
                                            </select>
                        </div>
                    <button id="search_button" type="submit"  onclick="" class="btn btn-primary btn-lg">@lang('strings.Search')</button>
                   @if(permissions('rooms_type_add') ==1)
                    <button type="button" onclick="add_data()" class="btn btn-primary btn-lg NewBtn btnclient" data-toggle="modal" data-target="#addroomType">@lang('strings.create_rooms_types')</button>
                    @endif
                      </form>



                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">@lang('strings.rooms_types')</h4>
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
                                    @foreach($rooms_types as $value)
                                        <tr>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->name_en }}</td>
                                            <td>
                                              @if(permissions('rooms_type_edit') == 1)
                                              <button type="button" class="btn btn-primary btn-lg NewBtn btnclient" onclick="show_data()" data-toggle="modal" data-id="{{$value->id}}" data-target="#addroomType"><i  class="fa fa-pencil"></i></button>
                                              @endif
                                  <a href="delete_cat_type/{{ $value->id }}" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ __('strings.delete_btn') }}"> <i class="fa fa-trash-o"></i></a>
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
