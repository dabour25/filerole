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


    <div class="modal fade newModel" id="addcancel_reason" role="dialog">
           <div class="modal-dialog">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Modal content-->
               <div class="modal-content">
                   <div class="modal-body" style="overflow: hidden">
                       <form method="post" action="{{url('admin/store_book_cancel_reason')}}" enctype="multipart/form-data">
                           {{csrf_field()}}
                          <input type="hidden" name="id">
                           <div class="col-md-6 form-group{{$errors->has('property_id') ? ' has-error' : ''}}">
                            <label  class="text-center">@lang('strings.Unit')</label>
                            <select class="New_select"  name="property_id" id="property_id" required>
                          <option value="">{{ app()->getLocale() == 'ar' ? اختار : choose }}</option>
                         @foreach($properties as $property )
                          <option value="{{$property->id}}">{{ app()->getLocale() == 'ar' ? $property->name : $property->name_en }}</option>
                            @endforeach
                            </select>
                                   @if ($errors->has('property_id'))
                                       <span class="help-block">
                                       <strong class="text-danger">{{ $errors->first('property_id') }}</strong>
                                   </span>
                                   @endif
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
                               <input type="text" class="form-control" name="name_en" value="{{old('name_en')}}" >
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
                           <div class="col-md-6 form-group{{$errors->has('rank') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                               <label class="control-label" for="rank">{{ __('strings.loginHistory_orderBy') }}</label>
                               <input type="number" class="form-control" name="rank" value="{{old('rank')}}" required>
                               @if ($errors->has('order'))
                                   <span class="help-block">
                                       <strong class="text-danger">{{ $errors->first('order') }}</strong>
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
            {{ DB::table('function_new')->where('id',262)->value('description') }}
            @else
            {{ DB::table('function_new')->where('id',262)->value('description_en') }}
            @endif
                          </p>
                          <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                          </a>
                      </div>
                      </br>

                            <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                              <form method="get" action="get_book_cancel_reasons" enctype="multipart/form-data">

                                                <select class="form-control js-select" name="property_id" onchange="this.form.submit()" >
                                                 <option value="0" >@lang('strings.properties_list')</option>
                                                  @foreach($properties as $property)
                                                  <!-- <option {{ app('request')->input('property_id') == $property->id ? 'selected' : ''}}  value="{{$property->id}}">{{ app()->getLocale() == 'ar' ? $property->name  : $property->name_en  }}</option> -->
                                                  <option  {{ session()->get('hotel_id') == $property->id ? 'selected' : app('request')->input('property_id')}} value="{{$property->id}}">{{ app()->getLocale()== 'ar' ? $property->name : $property->name_en}}</option>

                                                      @endforeach
                                                  </select>
                              </form>
                              </div>

                       @if(permissions('add_reason') == 1)
                      <button type="button" onclick="clear_old_data()" class="btn btn-primary btn-lg NewBtn btnclient" data-toggle="modal" data-target="#addcancel_reason">@lang('strings.add_reason')</button>
                        @endif


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
                                            <th>{{ __('strings.loginHistory_orderBy') }}</th>
                                            <th>@lang('strings.Settings')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($reasons as $value)
                                        <tr>
                                            <td>{{app()->getLocale() =='ar' ? $value->name : $value->name_en }}</td>
                                            <td>{{ $value->rank }}</td>
                                            <td>
                                             @if(permissions('edit_reason') == 1)
                                              <button type="button" class="btn btn-primary btn-lg NewBtn btnclient" onclick="book_cancel_data({{$value->id}})" data-toggle="modal" data-hotel="{{$value->property_id}}" id="modal_button{{$value->id}}" data-id="{{$value->id}}" data-rank="{{$value->rank}}" data-name="{{$value->name}}" data-name_en="{{$value->name_en}}" data-description="{{$value->description}}" data-target="#addcancel_reason"><i  class="fa fa-pencil"></i></button>
                                              @endif
                                  <a href="delete_cancel_reasons/{{ $value->id }}" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ __('strings.delete_btn') }}"> <i class="fa fa-trash-o"></i></a>
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
