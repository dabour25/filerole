@extends('layouts.admin', ['title' =>__('strings.allows')])

@section('content')

    <!--<div class="page-title">-->
    <!--    <h3>@lang('strings.allows')</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>-->
    <!--            <li class="active">@lang('strings.allows')</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->
    <div class="modal fade newModel" id="addclient_machines" role="dialog">
           <div class="modal-dialog">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
    <div class="modal-content">
        <div class="modal-body" style="overflow: hidden">
          <form method="post" action="{{url('admin/store_category')}}" enctype="multipart/form-data">
              {{csrf_field()}}
              <div class="col-md-6 form-group{{$errors->has('category_type_id') ? ' has-error' : ''}}">
               <label  class="text-center">@lang('strings.reservation_category')</label>
               <select class="New_select" name="category_type_id" id="category_type_id">
                 @foreach($cat_type_ids as $type_id)
                 @if($type_id->type==6)
                 <option value="{{$type_id->id}}">{{ app()->getLocale() =='ar' ?  $type_id->name : $type_id->name_en }}</option>
                  @endif
                   @endforeach
                  </select>
                      <!-- <button type="button" class="btn btn-info btn-lg NewBtn btnclient" data-toggle="modal" data-target="#addclient"><i class="fas fa-plus"></i></button> -->
                      @if ($errors->has('category_type_id'))
                          <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('category_type_id') }}</strong>
                      </span>
                      @endif
              </div>
              <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                  <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                  <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" required="required">
                  @if ($errors->has('name'))
                      <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('name') }}</strong>
                      </span>
                  @endif
              </div>

              <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                  <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                  <input type="text" class="form-control" name="name_en" id="name_en" value="{{old('name_en')}}" required="required">
                  @if ($errors->has('name_en'))
                      <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                      </span>
                  @endif
              </div>

              <div class="col-md-6 form-group{{$errors->has('description') ? ' has-error' : ''}}">
                  <label class="control-label" for="description_ar">{{ __('strings.description_ar') }}</label>
                  <input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">
                  @if ($errors->has('description'))
                      <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('description') }}</strong>
                      </span>
                  @endif
              </div>
              <div class="col-md-6 form-group{{$errors->has('description_en') ? ' has-error' : ''}}">
                  <label class="control-label" for="description_en">{{ __('strings.description_en') }}</label>
                  <input type="text" class="form-control" name="description_en" id="description_en" value="{{old('description_en')}}">
                  @if ($errors->has('description_en'))
                      <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('description') }}</strong>
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
              <div class="col-md-6 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
              <label for="photo_id"  class="control-label">@lang('strings.Photo')</label>
                <input type="file" id="photo_id"name="photo_id" >
                 @if ($errors->has('photo_id'))
                      <span class="help-block">
                      <strong class="text-danger">{{ $errors->first('image') }}</strong>
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
    <div class="modal fade newModel" id="addclient" role="dialog">
           <div class="modal-dialog">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
    <div class="modal-content">
        <div class="modal-body" style="overflow: hidden">
          <form method="post" action="{{url('admin/store_category')}}" enctype="multipart/form-data">
              {{csrf_field()}}
              <div class="col-md-6 form-group{{$errors->has('category_type_id') ? ' has-error' : ''}}">
               <label  class="text-center">@lang('strings.reservation_category')</label>
               <select class="New_select" name="category_type_id" id="category_type_id">
                 @foreach($cat_type_ids as $type_id)
                @if($type_id->type==5)
                 <option value="{{$type_id->id}}">{{ app()->getLocale() =='ar' ?  $type_id->name : $type_id->name_en }}</option>
                    @endif
                   @endforeach
                  </select>
                      <!-- <button type="button" class="btn btn-info btn-lg NewBtn btnclient" data-toggle="modal" data-target="#addclient"><i class="fas fa-plus"></i></button> -->
                      @if ($errors->has('category_type_id'))
                          <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('category_type_id') }}</strong>
                      </span>
                      @endif
              </div>
              <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                  <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                  <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" required="required">
                  @if ($errors->has('name'))
                      <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('name') }}</strong>
                      </span>
                  @endif
              </div>

              <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                  <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                  <input type="text" class="form-control" name="name_en" id="name_en" value="{{old('name_en')}}" required="required">
                  @if ($errors->has('name_en'))
                      <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                      </span>
                  @endif
              </div>

              <div class="col-md-6 form-group{{$errors->has('description') ? ' has-error' : ''}}">
                  <label class="control-label" for="description_ar">{{ __('strings.description_ar') }}</label>
                  <input type="text" class="form-control" name="description" id="description" value="{{old('description')}}">
                  @if ($errors->has('description'))
                      <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('description') }}</strong>
                      </span>
                  @endif
              </div>
              <div class="col-md-6 form-group{{$errors->has('description_en') ? ' has-error' : ''}}">
                  <label class="control-label" for="description_en">{{ __('strings.description_en') }}</label>
                  <input type="text" class="form-control" name="description_en" id="description_en" value="{{old('description_en')}}">
                  @if ($errors->has('description_en'))
                      <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('description') }}</strong>
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
              <div class="col-md-6 form-group{{$errors->has('photo_id') ? ' has-error' : ''}}">
              <label for="photo_id"  class="control-label">@lang('strings.Photo')</label>
                <input type="file" id="photo_id"name="photo_id" >
                 @if ($errors->has('photo_id'))
                      <span class="help-block">
                      <strong class="text-danger">{{ $errors->first('image') }}</strong>
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
                      @if(count($categories_furnitures)==0 &&  count($categories_Machines)==0)

                     <h2><strong>لا توجد بيانات متاحة</strong></h2>

                         @endif
                           </br>  </br>
                     <form method="get" action="{{url('admin/categorey_search')}}" enctype="multipart/form-data">
                       {{csrf_field()}}
                     <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                         <select class="form-control js-select" name="categorey_name"  >
                              @foreach($cat_type_ids as $cat_type_id)
                              @foreach($cat_type_id->categories as $cat_type_id->categorie)
                              <option {{ app('request')->input('destination_name') == $cat_type_id->categorie->id ? 'selected' : ''}}  value="{{$cat_type_id->categorie->name}}">{{ app()->getLocale() == 'ar' ? $cat_type_id->categorie->name  : $cat_type_id->categorie->name_en  }}</option>
                              @endforeach
                              @endforeach
                      </select>
                     </div>
                    <button id="search_button" type="submit"  onclick="" class="btn btn-primary btn-lg">@lang('strings.Search')</button>
                     </form>
                   </br>
                   <button type="button"     class="btn btn-info btn-lg NewBtn btnclient" data-toggle="modal" data-target="#addclient">اضافةالات ومعدات</button>
                          &nbsp;
                  <button type="button"  class="btn btn-info btn-lg NewBtn btnclient" data-toggle="modal" data-target="#addclient_machines">اضافة اثاث </button>


                         <div role="tabpanel">
                              </br>
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation"  class="active" ><a href="#furniture" role="tab" data-toggle="tab"><i class="icon-basket"></i>&nbsp;&nbsp;;@lang('strings.Machines')@lang('strings.furniture') </a></li>
                        <li role="presentation"  ><a href="#Machines" role="tab" data-toggle="tab"><i class="icon-basket"></i>&nbsp;&nbsp;@lang('strings.furniture')</a></li>


                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active   fade in" id="furniture">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">@lang('strings.furniture')</h4>
                                </div>
                              @if(count($categories))
                              <div class="panel-body">
                                  <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                      <thead>
                                      <tr>

                                          <th>@lang('strings.Name')</th>
                                          <th>{{ __('strings.Photo') }}</th>
                                          <th>@lang('strings.Status')</th>
                                          <th>@lang('strings.Settings')</th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                       @foreach($categories as $value)
                                          <tr>
                                          <td>{{ app()->getLocale() == 'ar' ?  $value->name :$value->name_en }}</td>
                                          <td><img src="{{ $value->photo_id !== null ? asset($value->photo->file) : asset('images/profile-placeholder.png') }}" width="40" height="40">
                                          </td>
                                              <td>
                                                  @if($value->active)
                                                      <span class="label label-success" style="font-size:12px;">@lang('strings.Active')</span>
                                                  @else
                                                      <span class="label label-danger" style="font-size:12px;">@lang('strings.Deactivate')</span>
                                                  @endif
                                              </td>
                                              <td>
                                <a href="edit_category/{{ $value->id }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title=""  data-original-title="{{ __('strings.edit') }} "> <i  class="fa fa-pencil"></i></a>
                                <a href="#" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ __('strings.delete_btn') }}"> <i class="fa fa-trash-o"></i></a>
                                              </td>
                                          </tr>

                                      @endforeach
                                      </tbody>
                                  </table>
                              </div>
                              @else
                                <div class="panel-body">
                                    <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                        <tr>

                                            <th>@lang('strings.Name')</th>
                                            <th>{{ __('strings.Photo') }}</th>
                                            <th>@lang('strings.Status')</th>
                                            <th>@lang('strings.Settings')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                         @foreach($cat_type_ids as $cat_type_id)
                                         @if($cat_type_id->type==5)
                                         @foreach($cat_type_id->categories as $value)
                                            <tr>
                                            <td>{{ app()->getLocale() == 'ar' ?  $value->name :$value->name_en }}</td>
												                    <td><img src="{{ $value->photo_id !== null ? asset($value->photo->file) : asset('images/profile-placeholder.png') }}" width="40" height="40">
                                            </td>
                                                <td>
                                                    @if($value->active)
                                                        <span class="label label-success" style="font-size:12px;">@lang('strings.Active')</span>
                                                    @else
                                                        <span class="label label-danger" style="font-size:12px;">@lang('strings.Deactivate')</span>
                                                    @endif
                                                </td>
                                                <td>
                                  <a href="edit_category/{{ $value->id }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title=""  data-original-title="{{ __('strings.edit') }} "> <i  class="fa fa-pencil"></i></a>
                                  <a href="#" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ __('strings.delete_btn') }}"> <i class="fa fa-trash-o"></i></a>
                                                </td>
                                            </tr>
                                              @endforeach
                                              @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                              @endif
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane  fade in" id="Machines">
                            <div class="panel panel-white">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">@lang('strings.Machines')</h4>
                                </div>
                                <div class="panel-body">
                                    <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                        <thead>
                                        <tr>
                                          <th>@lang('strings.Name')</th>
                                          <th>{{ __('strings.Photo') }}</th>
                                          <th>@lang('strings.Status')</th>
                                          <th>@lang('strings.Settings')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($cat_type_ids as $cat_type_id)
                                          @if($cat_type_id->type==6)
                                          @foreach($cat_type_id->categories as $value2)
                                            <tr>
                                                <td>{{ app()->getLocale() == 'ar' ?  $value2->name :$value2->name_en }}</td>
                                                <td><img src="{{ $value2->photo_id !== null ? asset($value2->photo->file) : asset('images/profile-placeholder.png') }}" width="40" height="40">
                                                 </td>
                                                <td>
                                                    @if($value2->active)
                                                        <span class="label label-success" style="font-size:12px;">@lang('strings.Active')</span>
                                                    @else
                                                        <span class="label label-danger" style="font-size:12px;">@lang('strings.Deactivate')</span>
                                                    @endif
                                                </td>
                                                <td>
                                  <a href="edit_category/{{ $value2->id }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title=""  data-original-title="{{ __('strings.edit') }} "> <i  class="fa fa-pencil"></i></a>
                                  <a href="#" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ __('strings.delete_btn') }}"> <i class="fa fa-trash-o"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
    <script>
       $('.js-select').select2();
    </script>
@endsection
