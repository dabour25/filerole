@extends('layouts.admin', ['title' => __('strings.rooms') ])
@section('content')
    <style>
        .modal {
            display: none; /* Hidden by default */
            overflow-y: auto;
        }

        td.details-control {
            background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
        }

        .modal-body {

        }
    </style>
    <div class="modal fade newModel" id="addclient" role="dialog">
           <div class="modal-dialog">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
    <div class="modal-content">
        <div class="modal-body" style="overflow: hidden">
          <form method="post" action="{{url('admin/update_policy_details_room')}}" enctype="multipart/form-data">
              {{csrf_field()}}
              <input type="hidden" name="id" id="id">
              <input type="hidden" name="type" id="type">
                <input type="hidden" name="tab" id="tab" value="tab-2">
              <div class="col-md-6 form-group{{$errors->has('destination_name') ? ' has-error' : ''}}">
               <label  class="text-center">@lang('strings.destination_name')</label>
               <div class="form-field">
                   <i class="icon icon-arrow-down3"></i>
               <select class="form-control" name="policy_type_id" id="policy_type_id">
                 @foreach($policys as $policy)
                   @if($policy->type==1)
                 <option value="{{$policy->id}}">{{ app()->getLocale()== 'ar' ? $policy->name : $policy->name_en}}</option>
                  @endif
                 @endforeach
                      </select>
                    </div>

                      @if ($errors->has('policy_type_id1'))
                          <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('policy_type_id1') }}</strong>
                      </span>
                      @endif
              </div>
              <div class="col-md-12 form-group{{$errors->has('details') ? ' has-error' : ''}}">
                                           <label class="control-label" for="details">@lang('strings.details_protery')</label>
                                           <textarea type="text"  name="details"  id="details"></textarea>
                                           @if ($errors->has('details'))
                                               <span class="help-block">
                                                   <strong class="text-danger">{{ $errors->first('details') }}</strong>
                                               </span>
                                           @endif
                                       </div>
                                       <div class="col-md-12 form-group{{$errors->has('details_en') ? ' has-error' : ''}}">
                                                                    <label class="control-label" for="details_en">@lang('strings.details_protery_en')</label>
                                                                    <textarea type="text"  name="details_en" id="details_en"></textarea>
                                                                    @if ($errors->has('details'))
                                                                        <span class="help-block">
                                                                            <strong class="text-danger">{{ $errors->first('details_en') }}</strong>
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
  <div class="modal fade newModel" id="addclient1" role="dialog">
         <div class="modal-dialog">
             <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
             </div>
  <div class="modal-content">
      <div class="modal-body" style="overflow: hidden">
        <form method="post" action="{{url('admin/update_policy_details_room')}}" id="update_policy" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="id" id="id">
            <input type="hidden" name="type" id="type">
            <input type="hidden" name="tab" id="tab" value="tab-3">
            <div class="col-md-6 form-group{{$errors->has('destination_name') ? ' has-error' : ''}}">
             <label  class="text-center">@lang('strings.destination_name')</label>
             <div class="form-field">
                 <i class="icon icon-arrow-down3"></i>
             <select class="form-control" name="policy_type_id" id="policy_type_id">
               @foreach($policys as $policy)
                 @if($policy->type==2)
               <option value="{{$policy->id}}">{{ app()->getLocale()== 'ar' ? $policy->name : $policy->name_en}}</option>
                @endif
               @endforeach
              </select>
                  </div>

                    @if ($errors->has('policy_type_id1'))
                        <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('policy_type_id1') }}</strong>
                    </span>
                    @endif
            </div>
            <div class="col-md-12 form-group{{$errors->has('details') ? ' has-error' : ''}}">
                                         <label class="control-label" for="details">@lang('strings.details_information')</label>
                                         <textarea  type="text"  name="details" id="details_information" ></textarea>
                                         @if ($errors->has('details'))
                                             <span class="help-block">
                                                 <strong class="text-danger">{{ $errors->first('details') }}</strong>
                                             </span>
                                         @endif
                                     </div>
                                     <div class="col-md-12 form-group{{$errors->has('details_en') ? ' has-error' : ''}}">
                                                                  <label class="control-label" for="details_en">@lang('strings.details_information_en')</label>
                                                                  <textarea type="text"  name="details_en" id="details_en_information"></textarea>
                                                                  @if ($errors->has('details'))
                                                                      <span class="help-block">
                                                                          <strong class="text-danger">{{ $errors->first('details_en') }}</strong>
                                                                      </span>
                                                                  @endif
                                                              </div>
              <div class="col-md-12 form-group text-right">
                  <button type="submit" id="update_policy_submit" class="btn btn-primary btn-lg"> {{ __('strings.Save') }} </button>
              </div>
          </form>
  </div>
  </div>
  </div>
  </div>



  <div class="modal fade newModel" id="addpolicy" role="dialog">
       <div class="modal-dialog">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
           </div>
  <div class="modal-content">
    <div class="modal-body" style="overflow: hidden">
      <form method="post"  action="{{url('admin/policy_main/save_room')}}" enctype="multipart/form-data">
          {{csrf_field()}}
          <input type="hidden" name="type_add" id="type">
          <input type="hidden" name="pre_tab" id="tab">
          <div    class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}">
              <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
              <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" >
              @if ($errors->has('name'))
                  <span class="help-block">
                      <strong class="text-danger">{{ $errors->first('name') }}</strong>
                  </span>
              @endif
          </div>
          <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
              <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
              <input type="text" class="form-control" name="name_en" id="name_en" value="{{old('name_en')}}"  >
              @if ($errors->has('name_en'))
                  <span class="help-block">
                      <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                  </span>
              @endif
          </div>
          <div id="information_checkcard" style="display:none;">
          <div class="col-md-6 form-group{{$errors->has('checkin_card') ? ' has-error' : ''}}">

             <input type="checkbox" name="checkin_card" selected="selected" value="y" ? :   value="n">{{ __('strings.check_card') }}
              @if ($errors->has('checkin_card'))
                  <span class="help-block">
                      <strong class="text-danger">{{ $errors->first('checkin_card') }}</strong>
                  </span>
              @endif
          </div>
        </div>

            <div class="col-md-12 form-group text-right">
                <button type="submit"  class="btn btn-primary btn-lg"> {{ __('strings.Save') }} </button>
            </div>
        </form>
  </div>
  </div>
  </div>
  </div>
    <div id="main-wrapper">
        <div class="row">
            @include('alerts.index')
            <div class="" style=" text-align: center !important;">
                <h1>@lang('strings.updated_rooms')</h1>
                <br>
                <h2><strong>{{app()->getLocale() == 'ar'? $room->name :$room->name_en}}</strong></h2>
                <br>
                <a href="{{url('admin/rooms')}}">
                    <button type="button" class="btn btn-info btn-lg">@lang('strings.rooms')</button>
                </a>

            </div>
            <hr>
            <br>
            <div class="row">
              <ul class="nav nav-pills" role="tablist" id="myTab">
                  <li role="presentation"  id="basic_tab" class="active">
                    <a href="#tab-1" role="tab" data-toggle="tab"><i
                                  class="icon-basket"></i>&nbsp;&nbsp;البيانات الاساسة
                      </a></li>
                  <li role="presentation"  id="myTab_policy">
                    <a href="#tab-2" role="tab" data-toggle="tab"><i
                                  class="icon-basket"></i>&nbsp;&nbsp;السياسات
                      </a></li>
                  <li role="presentation" id="myTab_information">
                    <a href="#tab-3" role="tab" data-toggle="tab"><i
                                  class="icon-basket"></i>&nbsp;&nbsp;معلومات
                      </a></li>

              </ul>

              <div class="tab-content">
                <div role="tabpanel"  class="tab-pane active" id="tab-1"  >
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('strings.edit') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="" style=" text-align: center !important;">
                            <p style="font-size: 25px;">{{__('strings.lastPrices')}}</p>
                        <p style="font-size: 20px;">{{cat_price($room->id)['catPrice']!=null?cat_price($room->id)['catPrice']:0}}</p>
                        </div>
                        <form method="post" id="addCategories" action="{{url('admin/rooms/updated')}}"
                              enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$room->id}}">

                            <div class="col-md-6 panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group{{$errors->has('cate_id') ? ' has-error' : ''}}">
                                        <strong
                                                class="text-danger">*</strong>
                                        <label class="control-label">@lang('strings.rome_type')</label>
                                        <select class="js-select2 New_select form-control" ids="cate_id" name="cate_id"
                                                id="cate_id_selected">
                                            @foreach($categoriesType as $cate)
                                                <option id="option-{{$cate->id}}" data-max_kids="{{$cate->max_kids}}"
                                                        data-max_adult="{{$cate->max_adult}}"
                                                        data-max_people="{{$cate->max_people}}"
                                                        value="{{$cate->id}}"
                                                @if(old('cate_id')!=null)
                                                    {{old('cate_id')== $cate->id ?'selected':''}}
                                                        @else
                                                    {{($room->category_type_id == $cate->id)?'selected':''}}
                                                        @endif
                                                >{{ app()->getLocale() == 'ar' ? $cate->name : $cate->name_en }}</option>
                                            @endforeach
                                        </select>
                                        <i id="cate_id_sf" style="display:none" class="fa fa-check  color-success"></i>
                                        <i id="subcate_id" style="display:none" class="fa fa-times color-danger"></i>
                                        <div id="cate_id_error"></div>


                                        <div id="showDataAfterSele">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 panel panel-default">
                                <div class="panel-body">
                                    <div class="col-md-12 form-group{{$errors->has('property_id') ? ' has-error' : ''}}">
                                        <strong
                                                class="text-danger">*</strong>
                                        <label class="control-label">@lang('strings.property_name')</label>
                                        <select class="js-select New_select form-control" id="property_id" name="property_id">

                                            @foreach($hotels as $hotel)
                                                <option id="iam_here_my_op" value="{{ $hotel->id }}"

                                                @if(old('property_id')!=null)
                                                    {{old('property_id')== $hotel->id ?'selected':''}}
                                                        @else
                                                    {{($room->property_id == $hotel->id)?'selected':''}}
                                                        @endif
                                                >{{ app()->getLocale() == 'ar' ? $hotel->name : $hotel->name_en }}</option>
                                            @endforeach
                                        </select>

                                        <i id="subok" style="display:none" class="fa fa-check  color-success"></i>
                                        <i id="subcancel" style="display:none" class="fa fa-times color-danger"></i>
                                        <div id="property_id_error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 panel panel-default">
                                <div class="panel-body">
                                    <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"><strong
                                                class="text-danger">*</strong>
                                        <label class="control-label"
                                               for="name">{{ __('strings.rooms_name_ar') }}</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                               value="{{old('name')!=null?old('name') :$room->name}}">
                                        <i id="nameok" style="display:none" class="fa fa-check  color-success"></i>
                                        <i id="namecancel" style="display:none" class="fa fa-times color-danger"></i>
                                        <div id="name_error"></div>

                                    </div>

                                    <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                                        <strong
                                                class="text-danger">*</strong>
                                        <label class="control-label"
                                               for="name_en">{{ __('strings.rooms_name_en') }}</label>
                                        <input type="text" class="form-control" name="name_en" id="name_en"
                                               value="{{old('name_en')!=null?old('name_en') :$room->name_en}}"
                                               required="required">
                                        <i id="nameok_en" style="display:none" class="fa fa-check  color-success"></i>
                                        <i id="namecancel_en" style="display:none" class="fa fa-times color-danger"></i>
                                        <div id="name_error_en"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group{{$errors->has('cancel_policy') ? ' has-error' : ''}}">
                                        <label class="control-label">@lang('strings.cancel_policy')</label>
                                        <select class="js-select2 New_select form-control" name="cancel_policy"
                                                id="cancel_policy_selected">
                                            <option>@lang('strings.cancel_policy')</option>
                                            <option value="free cancelation"
                                            @if(old('cancel_policy')!=null)
                                                {{old('cancel_policy')=='free cancelation'?'selected':''}}
                                                    @else
                                                {{$room->cancel_policy =='free cancelation'?'selected':''}}
                                                    @endif

                                            >{{__('strings.free_cancelation')}}</option>
                                            <option value="before check in"
                                            @if(old('cancel_policy')!=null)
                                                {{old('cancel_policy')=='before check in'?'selected':''}}
                                                    @else
                                                {{$room->cancel_policy =='before check in'?'selected':''}}
                                                    @endif

                                            >{{__('strings.before_check_in')}}</option>
                                        </select>

                                        @if ($errors->has('cancel_policy'))
                                            <span class="help-block">
                                              <strong class="text-danger">{{ $errors->first('cancel_policy') }}</strong>
                                          </span>
                                        @endif
                                    </div>
                                    @if($room->cancel_policy =='before check in' or old('cancel_policy')=='before check in')
                                        <div class="col-md-6">
                                            <label class="control-label"
                                                   for="rank">{{ __("strings.the_number_of_days") }}</label>
                                            <input type="number"
                                                   value="{{old('cancel_days')!=null?old('cancel_days'):$room->cancel_days}}"
                                                   class="form-control" name="cancel_days" id="rank">
                                            <p>{{__("strings.day_notes")}}</p>
                                            <label class="control-label"
                                                   for="rank">{{ __("strings.cancel_charge_title") }}</label>
                                            <input type="number"
                                                   value="{{old('cancel_charge')?old('cancel_charge'):$room->cancel_charge}}"
                                                   class="form-control" step=0.01 name="cancel_charge">
                                            <p>{{__("strings.cancel_charge_notes")}}</p>
                                        </div>

                                    @else
                                        <div id="day_cancel_policy_appen">

                                        </div>
                                    @endif


                                </div>
                            </div>
                            <hr>
                            <div class="panel panel-white {{$errors->has('photo') ? ' has-error' : ''}}">
                                <div class="panel-heading clearfix">
                                    <h4 class="panel-title">@lang('strings.Photo')</h4>
                                </div>
                                <strong
                                        class="text-danger"></strong>
                                <label>اختار الصوره</label>
                                <input type="file" name="photo" id="photo" data-min-width="500" data-min-height="400">
                                 <span class="help-block">
                                     <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 500*400</strong>
                                 </span>
                                 <hr>
                                <i id="photook" style="display:none" class="fa fa-check  color-success"></i>
                                <i id="photookcancel" style="display:none" class="fa fa-times color-danger"></i>
                                <div id="photook_error"></div>
                            </div>
                            @if ($errors->has('photo'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('image') }}</strong>
                                </span>
                        @endif

                    @if(!empty($room->photo))
                        <div class="col-md-3">
                            <img src="{{$room->photo_id ? asset($room->photo->file): asset('images/profile-placeholder.png')}}"
                                 class="img-responsive">
                                    <a href="{{url('admin/rooms/iamge/del/'.$room->id)}}"
                     @if(app()->getLocale() == 'ar')
                        onclick="return confirm('تأكيد حذف الصوره')"
                      @else
                       onclick="return confirm('Are you sure?')"
                    @endif
                    ><button type="button" class="btn btn-danger btn-lx">حذف الصوره</button></a>
                    </div>
                        </div>

                    @endif


                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">تواريخ اغلاق الغرف</h4>
                        </div>
                        <div class="panel-body">
                            <table id="xtreme-table" class="table table-striped table-bordered"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th>*</th>
                                    <th> {{ __('strings.Date_fromm') }} </th>
                                    <th> {{ __('strings.date_to') }} </th>
                                    <th> {{ __('strings.reason') }} </th>
                                    <th> {{ __('strings.external_req_setting') }} </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($closeDays as $cday)
                                    <tr>
                                        <td>{{$cday->id}}</td>
                                        <td>{{$cday->from_date}}</td>
                                        <td>{{$cday->date_to}}</td>
                                        <td>{{$cday->reason}}</td>
                                        <td>

                                            <a href="{{url('admin/rooms/cloth/day/del/'.$cday->id)}}"
                                               class="btn btn-primary btn-xs" data-toggle="tooltip"
                                               data-placement="bottom" title=""
                                               data-original-title="{{ __('strings.remove') }} "
                                               @if(app()->getLocale() == 'ar')
                                               onclick="return confirm('تتاكيد حذف تاريخ الاغلاق')"
                                               @else
                                               onclick="return confirm('Are you sure?')"
                                                    @endif
                                            > <i
                                                        class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <button type="button" class="btn btn-primary" onclick="add_date()"><i
                                class="fas fa-plus"></i> اضافه مواعيد اغلاق جديده
                    </button>

                    <hr>

                    @if(isset($amentities))
                        <div class="col-md-6 form-group{{$errors->has('amentities') ? ' has-error' : ''}}">
                            <label class="control-label" for="amentities">{{ __('strings.amentities') }}</label>
                            <select name="amentities[]" class="js-example-basic-multiple" multiple="multiple">
                                @foreach($amentities as $cate)
                                    <option value="{{$cate->id}}"
                                    @if(old('amentities')!=null)
                                        {{ (collect(old('amentities'))->contains($cate->id)) ? 'selected':'' }}
                                                {{ (in_array($cate->id,$info->$amentities)) ? 'selected' : ''}}
                                            @else

                                        {{ (collect($amentitiesData['cat_id'])->contains($cate->id)) ? 'selected':'' }}
                                                {{ (in_array($cate->id,$amentitiesData)) ? 'selected' : ''}}
                                            @endif
                                    >{{ app()->getLocale()== 'ar' ? $cate->name :$cate->name_en}}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div>
                            add categories <a href="#"></a>
                        </div>
                    @endif

                    <div class="col-md-3 form-group{{$errors->has('category_num') ? ' has-error' : ''}}"><strong
                                class="text-danger"></strong>
                        <label class="control-label" for="rank">{{ __('strings.New_Rooms') }}</label>
                        <input type="number" class="form-control" name="category_num" id="category_num"
                               value="{{old('category_num')}}">
                        <i style="display:none" class="fa fa-check  color-success nameokcategory_num"></i>
                        <i style="display:none" class="fa fa-times color-danger namecancelcategory_num"></i>
                        <div class="category_num_error"></div>
                    </div>
                    <div class="col-md-3 form-group{{$errors->has('category_num') ? ' has-error' : ''}}"><strong
                                class="text-danger"></strong>
                        <label class="control-label" for="rank">{{ __('strings.countRoomsOld') }}</label>
                        <input class="form-control" value="{{$countCateNum}}" disabled>
                    </div>

                    <div class="col-md-12 form-group text-right">
                        <button type="submit" class="btn btn-primary btn-lg"> {{ __('strings.Save') }} </button>
                    </div>
                    </form>
                </div>

              </div>

              <div role="tabpanel" class="tab-pane" id="tab-2">

                            <div class="panel panel-white">
                              <div class="panel-heading clearfix">
                                  <h4 class="panel-title">{{ app()->getLocale()=='ar' ? $property->name : $property->name_en}}</h4>
                              </div>

                              <form method="post" action="{{url('admin/policy/save_room')}}" enctype="multipart/form-data">
                               {{csrf_field()}}
                                <input type="hidden" id="type1" name="type" value="1">
                                <input type="hidden" name="tab" id="tab_policy" value="tab-2">

                                <input type="hidden" name="cat_id" value="{{$room->id}}">
                              <div class="col-md-6 form-group{{$errors->has('policy_type') ? ' has-error' : ''}}">
                                <div class="form-group">
                                <label class="control-label" for="currency_id">{{ __('strings.policy_type') }}</label>
                                  <div class="form-field">
                                    <i class="icon icon-arrow-down3"></i>
                                    <select name="policy_type_id" id="policy_type" class="form-control js-select">
                                      @if(session()->get('policy_id'))
                                      <option value="{{session()->get('policy_id')}}">{{ app()->getLocale()== 'ar' ? $policy->name : $policy->name_en}}</option>
                                      @else
                                      <option value="">{{ __('strings.choose_policy') }}</option>
                                      @endif
                                      @foreach($policys as $policy)
                                        @if($policy->type==1)
                                      <option value="{{$policy->id}}">{{ app()->getLocale()== 'ar' ? $policy->name : $policy->name_en}}</option>
                                       @endif
                                      @endforeach
                                    </select>
                                    @if ($errors->has('policy_type_id'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('policy_type_id') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                                </div>
                              </div>
                               <div class="col-md-6 form-group">
                               <button  type="button" data-toggle="modal" id="policy_add"  onclick="modal_add_policy()" data-type="1" data-tab="tab-2"  data-target= "#addpolicy"  class="btn btn-info btn-lg"><i class="fas fa-plus"></i></button>
                             </div>
                              <div  class="col-md-12 form-group{{$errors->has('details') ? ' has-error' : ''}}">
                                  <label class="control-label" for="details">{{ __('strings.details_protery') }}</label>
                                  <input type="text" class="form-control" name="details" id="details_ar" value="{{old('details') }}">
                                  @if ($errors->has('details'))
                                      <span class="help-block">
                                          <strong class="text-danger">{{ $errors->first('details') }}</strong>
                                      </span>
                                  @endif
                              </div>
                              <div  class="col-md-12 form-group{{$errors->has('details') ? ' has-error' : ''}}">
                                  <label class="control-label" for="details">{{ __('strings.details_protery_en') }}</label>

                                  <input type="text" class="form-control" name="details_en" id="details_en" value="">
                                  @if ($errors->has('details_en'))
                                      <span class="help-block">
                                          <strong class="text-danger">{{ $errors->first('details_en') }}</strong>
                                      </span>
                                  @endif
                              </div>
                              </br>  </br></br>  </br></br>  </br>
                              <button type="submit" class="btn btn-primary btn-lg">{{ __('strings.Save') }}</button>
                            </form>

                  </br>  </br></br>  </br></br>  </br>
                              <div class="table-responsive">
                                  <table id="xtreme-table1" class="display table" style="width: 100%; cellspacing: 0;">
                                      <thead>
                                          <tr>
                                              <th>{{ __('strings.policy_type') }}</th>
                                              <th>{{ __('strings.details_protery') }}</th>
                                              <th>@lang('strings.Settings')</th>
                                          </tr>
                                      </thead>
                                      <tbody>

                                        @foreach($policy_types as $value)
                                        @if($value->type==1)
                                          <tr>
                                              <td>{{ $value->name }}</td>
                                              <td>{{ $value->details }}</td>
                                              <td>
                                <!-- <button type="button" class="btn btn-primary btn-lg NewBtn btnclient" onclick="show_data()" data-toggle="modal" data-id="{{$value->id}}" data-target="#addroomType"><i  class="fa fa-pencil"></i></button> -->
                               <button  class="btn btn-primary btn-xs" id="modal_button{{$value->id}}" onclick="modal_show_data('{{$value->id}}')" data-type="{{$value->type}}" data-tab="tab-2"  data-id="{{$value->id}}" data-details="{{$value->details}}" data-details_en="{{$value->details_en}}" data-policy_type_id="{{$value->policy_type_id}}"   data-toggle="modal" data-target="#addclient" ><i  class="fa fa-pencil"></i></button>
                                <a href="{{url('admin/delete_propery_polic_room/').'/'.$value->id.'/'.$value->type.'/'.'tab-2'}}" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ __('strings.delete_btn') }}"> <i class="fa fa-trash-o"></i></a>
                                              </td>
                                          </tr>
                                            @endif
                                            @endforeach
                                            </tbody>
                                          </table>
                                   </div>
                                </div>

              </div>

              <div role="tabpanel" class="tab-pane" id="tab-3">
                <div class="panel panel-white">
                  <div class="panel-heading clearfix">
                    <h4 class="panel-title">{{ app()->getLocale()=='ar' ? $property->name : $property->name_en}}</h4>
                  </div>
                        <form method="post" action="{{url('admin/policy/save_room')}}" enctype="multipart/form-data">
                         {{csrf_field()}}

                         <input type="hidden" name="type" id="type2" value="2">
                         <input type="hidden" name="cat_id" value="{{$room->id}}">
                         <input type="hidden" name="tab" id="tab_information" value="tab-3">
                        <div class="col-md-6 form-group{{$errors->has('policy_type') ? ' has-error' : ''}}">
                          <div class="form-group">
                          <label class="control-label" for="currency_id">{{ __('strings.information_type') }}</label>
                            <div class="form-field">
                              <i class="icon icon-arrow-down3"></i>
                              <select name="policy_type_id" id="policy_type2" class="form-control js-select">
                                @if(session()->get('policy_id'))
                                <option value="{{session()->get('policy_id')}}">{{ app()->getLocale()== 'ar' ? $policy->name : $policy->name_en}}</option>
                                @else
                                <option value="">{{ __('strings.choose_informatiom') }}</option>
                                @endif
                                @foreach($policys as $policy)
                                @if($policy->type==2)
                                <option value="{{$policy->id}}">{{ app()->getLocale()== 'ar' ? $policy->name : $policy->name_en}}</option>
                                @endif
                                @endforeach
                              </select>
                              @if ($errors->has('policy_type'))
                                  <span class="help-block">
                                      <strong class="text-danger">{{ $errors->first('policy_type') }}</strong>
                                  </span>
                              @endif
                            </div>
                          </div>
                        </div>
                        <button  type="button" data-toggle="modal" id="information_add"  onclick="modal_add_information()" data-type="2" data-tab="tab-3"  data-target= "#addpolicy"  class="btn btn-info btn-lg"><i class="fas fa-plus"></i></button>
                        <div  class="col-md-12 form-group{{$errors->has('details') ? ' has-error' : ''}}">
                            <label class="control-label" for="details"> {{ __('strings.details_information') }}</label>

                            <input type="text" class="form-control" name="details" id="details_ar1" value="{{old('details') }}">
                            @if ($errors->has('details'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('details') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div  class="col-md-12 form-group{{$errors->has('details') ? ' has-error' : ''}}">
                           <label class="control-label" for="details">{{ __('strings.details_information_en') }}</label>

                           <input type="text" class="form-control" name="details_en" id="details_en1" value="">
                           @if ($errors->has('details_en'))
                               <span class="help-block">
                                   <strong class="text-danger">{{ $errors->first('details_en') }}</strong>
                               </span>
                           @endif
                       </div>
                        
                        </br>  </br></br>  </br></br>  </br>
                        <button type="submit" class="btn btn-primary btn-lg">{{ __('strings.Save') }}</button>
                      </form>
            </br>  </br></br>  </br></br>  </br>
                        <div class="table-responsive">
                            <table id="xtreme-table1" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                    <tr>
                                        <th>{{ __('strings.information_type') }}</th>
                                        <th>{{ __('strings.details_information') }}</th>
                                        <th>@lang('strings.Settings')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($policy_types as $value1)
                                @if($value1->type==2)
                                    <tr>
                                        <td>{{ $value1->name }}</td>
                                        <td>{{ $value1->details }}</td>
                                        <td>

                          <!-- <button type="button" class="btn btn-primary btn-lg NewBtn btnclient" onclick="show_data()" data-toggle="modal" data-id="{{$value->id}}" data-target="#addroomType"><i  class="fa fa-pencil"></i></button> -->
             <button  class="btn btn-primary btn-xs" id="modal_button{{$value1->id}}" onclick="modal_show_data('{{$value1->id}}')" data-tab="tab-3" data-id="{{$value1->id}}" data-details="{{$value1->details}}" data-details_en="{{$value1->details_en}}" data-policy_type_id="{{$value1->policy_type_id}}"  data-type="{{$value1->type}}"    data-toggle="modal" data-target="#addclient1" ><i  class="fa fa-pencil"></i></button>
              <a href="{{url('admin/delete_propery_polic_room/').'/'.$value1->id.'/'.$value1->type.'/'.'tab-3'}}" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ __('strings.delete_btn') }}"> <i class="fa fa-trash-o"></i></a>
                                        </td>
                                      </tr>
                                @endif
                                        @endforeach
                                      </tbody>
                                    </table>
                         </div>



                          </div>




              </div>
              <input type="hidden" value="{{ session()->get('mytab') }}" name="session_tab">

            </div>
            </div>


        </div>
    </div>
    </div>


  <script>
        $('.js-example-basic-multiple').select2();
    </script>

    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>


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

    $(document).ready(function () {
            $(function() {
          $('a[data-toggle="tab"]').on('click', function(e) {
              window.localStorage.setItem('activeTab', $(e.target).attr('href'));
          });

          var activeTab = window.localStorage.getItem('activeTab');
          if (activeTab) {
              $('#myTab a[href="' + activeTab + '"]').tab('show');
              window.localStorage.removeItem("activeTab");
          }

      });
      var test=$('input[name=session_tab]').val();
       if(test==2){
         $('#myTab_policy a[href="#{{ old('tab') }}"]').tab('show');

       }
      else if(test==3) {
        $('#myTab_information a[href="#{{ old('tab') }}"]').tab('show');
      }
      else {
        $('#basic_tab a[href="#{{ old('tab') }}"]').tab('show');
      }


      $("#policy_type").change(function(){

        var itemid = $(this).val();
        var room_id={{$room->id}};
        var func_url = '/admin/get_itemdetails2/' + itemid +'/' + room_id;
        $.ajax({
          type:"GET",
          url: func_url,
          success: function(data){

              $('input[id="details_ar"]').val(data['details']);
              $('input[id="details_en"]').val(data['details_en']);
          }

        });
      });
      $("#policy_type2").change(function(){
        var itemid = $(this).val();
        var room_id={{$room->id}};
        var func_url = '/admin/get_itemdetails2/' + itemid +'/' + room_id;
        $.ajax({
          type:"GET",
          url: func_url,
          success: function(data){
              $('#details_ar1').val(data['details']);
              $('#details_en1').val(data['details_en']);
          }

        });
      });

      $('select').selectpicker();
      $('.js-select').select2();



    });

        $('#cate_id_selected').on('change', function () {
            console.log($('#cate_id_selected').val());
            var max_adult = $('#option-' + $('#cate_id_selected').val()).data('max_adult') != undefined ? $('#option-' + $('#cate_id_selected').val()).data('max_adult') : '';
            var max_kids = $('#option-' + $('#cate_id_selected').val()).data('max_kids') != undefined ? $('#option-' + $('#cate_id_selected').val()).data('max_kids') : '';
            var max_people = $('#option-' + $('#cate_id_selected').val()).data('max_people') != undefined ? $('#option-' + $('#cate_id_selected').val()).data('max_people') : '';

            var mydi = document.getElementById('showDataAfterSele');
            mydi.style.display = "";

            $('#showDataAfterSele').empty();
            $('#showDataAfterSele').append(
                '<p>' + 'عدد كبار السن =   ' + max_adult + ' </p>' +
                '<p>' + 'عدد صغار السن =   ' + max_kids + ' </p>' +
                '<p>' + 'الحد الاقصي للافراد بالغرفه =   ' + max_people + ' </p>'
            );


        });


        $('#cancel_policy_selected').on('change', function () {

            var cansel_sele = $('#cancel_policy_selected').val();

            if (cansel_sele == 'before check in') {
                $('#day_cancel_policy_appen').append(
                    '<label class="control-label" for="rank">{{ __("strings.the_number_of_days") }}</label>' +
                    '<input type="number"  class="form-control" name="cancel_days" id="rank">' +
                    '<p>{{__("strings.day_notes")}}</p>' +
                    '<label class="control-label" for="rank">{{ __("strings.cancel_charge_title") }}</label>' +
                    ' <input type="number" class="form-control" step=0.01 name="cancel_charge">' +
                    '<p>{{__("strings.cancel_charge_notes")}}</p>'
                );
            } else {
                $('#day_cancel_policy_appen').empty();
            }


        });


        $("#addCategories").validate({
            errorClass: "has-error",
            validClass: "has-success",
            rules: {
                "property_id": {
                    required: true,
                    digits: true
                },
                "name": {
                    required: true,
                    maxlength: 70
                },
                "name_en": {
                    required: true,
                    maxlength: 70
                },
                "cate_id": {
                    required: true,
                    digits: true

                }, "photo": {
                    required: false,
                    accept: "image/*"
                }

            },

            messages: {
                "property_id": {
                    required: "{{__('strings.valid_property')}}",

                },
                "cate_id": {
                    required: "{{__('strings.valid_cate_id')}}",

                },

                "name": {
                    required: "{{__('strings.valid_name')}}",
                    maxlength: "{{trans('admin.max_length_validate')}}"
                },
                "name_en": {
                    required: "{{__('strings.valid_name')}}",
                    maxlength: "{{trans('admin.max_length_validate')}}"
                }, "photo": {
                    accept: 'يجب ان تكون صوره',
                },

            }, errorPlacement: function (error, element) {
                if (element.attr('id') == 'property_id') {
                    $('#subok').hide();
                    $('#subcancel').show();
                    $('#property_id_error').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();
                } else if (element.attr('ids') == 'cate_id') {
                    $('#cate_id_sf').hide();
                    $('#subcate_id').show();
                    $('#cate_id_error').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();
                } else if (element.attr('id') == 'name') {
                    $('#nameok').hide();
                    $('#namecancel').show();
                    $('#name_error').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();
                } else if (element.attr('id') == 'name_en') {
                    $('#nameok_en').hide();
                    $('#namecancel_en').show();
                    $('#name_error_en').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();

                } else if (element.attr('id') == 'photo') {
                    $('#photook').hide();
                    $('#photookcancel').show();
                    $('#photook_error').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();

                } else {
                    element.next().remove();
                    error.insertAfter("#" + element.attr('id'));
                }

            },

        });

        function add_date() {

            var counter;
            counter = parseInt(localStorage.getItem('cate_num_date'));

            var data = '<tr>\n' +
                '<td class="reg_flagg">\n' +
                '</td>\n' +
                '<td>\n' +
                '<input type="text" ids="from" placeholder="{{ __('strings.Date_fromm') }}" name="from[]" class="form-control datepicker_reservation' + counter + '">' +
                '</td>\n' +
                '<td>\n' +
                ' <input type="text" name="to[]" placeholder="{{ __('strings.To_date') }}" class="form-control datepicker_reservation2' + counter + '">' +
                '</td>\n' +
                '<td>\n' +
                ' <input type="text" placeholder="{{ __('strings.reason') }}"  class="form-control" name="reason[]" id="reason">' +
                '</td>\n' +
                '<td>\n' +
                '<button type="button" id="deltr" style="color: red;"   class="btn btn-defult btn-close-regust2"><i class="fas fa-times"></i></button>\n' +
                '</td>\n' +
                '</tr>';


            $('#xtreme-table tbody').append(data);

            var reservation_date = new Date();
            $(".datepicker_reservation" + counter).datepicker({

                date: reservation_date,
                startDate: reservation_date,
                rtl: true,
                viewMode: 'years',
                format: 'yyyy-mm-dd',


            }).on('changeDate', function (e) {
                var date2 =
                    $('.datepicker_reservation' + counter).datepicker('getDate', '+1d');
                date2.setDate(date2.getDate() + 1);

                var msecsInADay = 8640000;
                var endDate = new Date(date2.getTime() + msecsInADay);
                $('.datepicker_reservation2' + counter).datepicker('setStartDate', endDate);
                $('.datepicker_reservation2' + counter).datepicker('setDate', endDate);


            });


            $('.datepicker_reservation2' + counter).datepicker({

                format: 'yyyy-mm-dd',
            });

            var addnew = counter + 1;
            parseInt(localStorage.setItem('cate_num_date', addnew));

        }


        $("#xtreme-table").on('click', '.btn-close-regust2', function () {
            var minus = 0, plus = 0;
            if ($(this).parents('tr').find('.reg_flagg select').val() == -1) {
                minus = $('.finalTotalPrice').text() - $(this).parents('tr').find('.fPrice').text();
                $('.finalTotalPrice').text(minus);
            } else if ($(this).parents('tr').find('.reg_flagg select').val() == 1) {
                plus = $('.finalTotalPrice').text() + $(this).parents('tr').find('.fprice_1').text();
                $('.finalTotalPrice').text(plus);
            }
            $(this).parents('tr').remove();
        });

        function intializecategory_type() {
            console.log($('#cate_id_selected').val());
            var max_adult = $('#option-' + $('#cate_id_selected').val()).data('max_adult') != undefined ? $('#option-' + $('#cate_id_selected').val()).data('max_adult') : '';
            var max_kids = $('#option-' + $('#cate_id_selected').val()).data('max_kids') != undefined ? $('#option-' + $('#cate_id_selected').val()).data('max_kids') : '';
            var max_people = $('#option-' + $('#cate_id_selected').val()).data('max_people') != undefined ? $('#option-' + $('#cate_id_selected').val()).data('max_people') : '';

            var mydi = document.getElementById('showDataAfterSele');
            mydi.style.display = "";


            $('#showDataAfterSele').empty();
            $('#showDataAfterSele').append(
                '<p>' + 'عدد كبار السن =   ' + max_adult + ' </p>' +
                '<p>' + 'عدد صغار السن =   ' + max_kids + ' </p>' +
                '<p>' + 'الحد الاقصي للافراد بالغرفه =   ' + max_people + ' </p>'
            );
        }

        intializecategory_type();

        function  modal_add_policy(){
          document.getElementById('information_checkcard').style.display='none';
          $('input[name="type_add"]').val($('#policy_add').data('type'));
          $('input[name="pre_tab"]').val($('#policy_add').data('tab'));

        }
        function  modal_add_information(){
        document.getElementById('information_checkcard').style.display='block';
        $('input[name="type_add"]').val($('#information_add').data('type'));
        $('input[name="pre_tab"]').val($('#information_add').data('tab'));


        }
        function modal_show_data(id){

         $('#details').val($('#modal_button'+id).data('details'));

         $('#details_information').val($('#modal_button'+id).data('details'));
         $('input[name="id"]').val($('#modal_button'+id).data('id'));
         $('input[name="type"]').val($('#modal_button'+id).data('type'));
         $('input[name="tab"]').val($('#modal_button'+id).data('tab'));
         $('#details_en').val($('#modal_button'+id).data('details_en'));
         $('#details_en_information').val($('#modal_button'+id).data('details_en'));
         $('select[name="policy_type_id"]').val($('#modal_button'+id).data('policy_type_id'));


        }


    </script>


    </div>
@endsection
