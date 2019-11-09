@extends('layouts.admin', ['title' => __('strings.Locator') ])
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
    <div class="modal fade newModel" id="addclient_destination" role="dialog">
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
                            <select class="form-control" name="infrontpage" >
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
                          <input type="file" id="image"name="image" data-min-width="200" data-min-height="150">
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

    <div class="modal fade newModel" id="addclient" role="dialog">
           <div class="modal-dialog">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
    <div class="modal-content">
        <div class="modal-body" style="overflow: hidden">
          <form method="post" action="{{url('admin/update_locations')}}" enctype="multipart/form-data">
              {{csrf_field()}}
              <input type="hidden" name="id" id="id">
              <div class="col-md-6 form-group{{$errors->has('destination_name') ? ' has-error' : ''}}">
               <label  class="text-center">@lang('strings.destination_name')</label>
               <select class="js-select2 New_select" name="destination_id" id="destination_id">
                    @foreach($destinations as $destination)
             <option value="{{ $destination->id }}">{{ app()->getLocale() == 'ar' ? $destination->name : $destination->name_en }}</option>
                     @endforeach
                      </select>
                      <!-- <button type="button" class="btn btn-info btn-lg NewBtn btnclient" data-toggle="modal" data-target="#addclient"><i class="fas fa-plus"></i></button> -->
                      @if ($errors->has('destination_id'))
                          <span class="help-block">
                          <strong class="text-danger">{{ $errors->first('destination_id') }}</strong>
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
                          <strong class="text-danger">{{ $errors->first('description_en') }}</strong>
                      </span>
                  @endif
              </div>
              <div class="col-md-6 form-group{{$errors->has('longitude') ? ' has-error' : ''}}">
                  <label class="control-label" for="longitude">{{ __('strings.line_ve') }}</label>
                  <input type="text" class="form-control" name="longitude" id="longitude" value="{{old('')}}" >
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
            {{ DB::table('function_new')->where('id',233)->value('description') }}
            @else
            {{ DB::table('function_new')->where('id',233)->value('description_en') }}
            @endif
                          </p>
                          <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                          </a>
                      </div>
                      </br>
                       @if(count($destinations)==0)
                      <h2><strong>لا توجد جهات حالية من فصلك اضاف جهة</strong></h2>
                          @endif
                        </br>
                      <form method="get" action="{{url('admin/search')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                      <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">
                                            <label>@lang('strings.destination_name')</label>
                                            <select class="form-control js-select" name="destination_name"  >

                                            @foreach($destinations as $destination)
                                            <option  value="{{$destination->name}}">{{ app()->getLocale() == 'ar' ? $destination->name  : $destination->name_en  }}</option>
                                                @endforeach
                                            </select>
                      </div>
                            <button id="search_button" type="submit"  onclick="" class="btn btn-primary btn-lg">@lang('strings.Search')</button>
                    </form>
                    </br>
          @if(permissions('destinations_add') == 1)
        <button type="button"  onclick="add_des()" class="btn btn-primary btn-lg NewBtn btnclient" data-toggle="modal" data-target="#addclient_destination">@lang('strings.create_destinations')</button>
          @endif
                    <div class="panel panel-white">
                        <div class="panel-heading clearfix">
                            <h4 class="panel-title">@lang('strings.destinations')</h4>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                              <table id="xtreme-table_data" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th style="display:none;  width:0px; "></th>
                                            <th>{{ __('strings.Arabic_name') }}</th>
                                            <th>{{ __('strings.English_name') }}</th>
                                            <th>@lang('strings.Settings')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($destinations as $value)
                                        <tr>
                                            <td class=" details-control"></td>
                                            <td style="display:none;  width:0px; ">{{ $value->id }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->name_en }}</td>
                                            <td>
                            <!-- <button  class="btn btn-primary btn-xs" id="modal_button" onclick="modal_show()" data-name="{{$value->name}}" data-name_en="{{$value->name_en}}" data-description="{{$value->description}}" data-destination_id="{{$value->destination_id}}" data-longitude="{{$value->longitude}}" data-latitude="{{$value->latitude}}" data-active="{{$value->active}}" data-id="{{$value->id}}" data-toggle="modal" data-target="#addclient" ><i  class="fa fa-pencil"></button> -->
                            @if(permissions('location_add') == 1)
                            <button type="button"  id="modal_button" onclick="get_des({{$value->id}})"  class="btn btn-info btn-lg NewBtn btnclient" data-toggle="modal"  data-placement="bottom" title="{{ __('strings.locator_add') }} "  data-original-title="{{ __('strings.locator_add') }} " data-target="#addclient"><i class="fas fa-plus"></i></button>
                            @endif
                            <a href="edit_destinations/{{ $value->id }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title=""  data-original-title="{{ __('strings.edit') }} "> <i  class="fa fa-pencil"></i></a>
                            <a href="delete_destinations/{{ $value->id }}" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ __('strings.delete_btn') }}"> <i class="fa fa-trash-o"></i></a>

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
<script>

 function format(d) {
     var table1;
     var programs = '';
     if (d != []) {
         $.each(d, function (key, item) {
          if(item.description!=null){
          var des_newStr_ar = item.description.replace(/  +/g, ' ');
           var des_newStr = des_newStr_ar.split(' ').join('&nbsp');
          }else var des_newStr='&nbsp';

          if(item.description_en!=null){
          var des_newStr_en = item.description.replace(/  +/g, ' ');
           var des_en_newStr = des_newStr_en.split(' ').join('&nbsp');
          }else var des_en_newStr='&nbsp';
           var name_newStr_ar = item.name.replace(/  +/g, ' ');
           var name_newStr = name_newStr_ar.split(' ').join('&nbsp');

           var name_newStr_en = item.name_en.replace(/  +/g, ' ');
           var name_en_newStr = name_newStr_en.split(' ').join('');

             programs += '<tr>';
             programs += '<td ></td>';
             programs += '<td>' + item.name + '</td>';
             programs += '<td>' + item.name_en + '</td>';
             programs += '<td>@if(permissions('location_edit')=='1') \n' +
             ' <button  class="btn btn-primary btn-xs" id="modal_button'+item.id+'" onclick="modal_show('+item.id+')" data-name='+name_newStr+' data-name_en=' +name_en_newStr +' data-description='+des_newStr+ ' data-destination_id='+item.destination_id+' data-longitude='+item.longitude +' data-latitude='+item.latitude+' data-active='+item.active+' data-id='+item.id+'   data-description_en='+des_en_newStr+'  data-toggle="modal" data-target="#addclient" ><i  class="fa fa-pencil"></i></button>\n'+
             '@endif<a href="delete_location/'+item.id+'" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{ __('strings.delete_btn') }}"> <i class="fa fa-trash-o"></i></a>                                                  ' +
             '                                                        ' +
             '                                                  ' +

             '            </td>';
             programs += '</tr>';
         });
     }

     table1 = '<table class="table">\n' +
         '\t\t\t\t\t\t\t<thead>\n' +
         '\t\t\t\t\t\t\t\t<tr>\n' +
         '\t\t\t\t\t\t\t\t\t<th></th>\n' +
         '\t\t\t\t\t\t\t\t\t<th>@lang('strings.Arabic_name')</th>\n' +
         '\t\t\t\t\t\t\t\t\t<th>@lang('strings.English_name')</th>\n' +
         '\t\t\t\t\t\t\t\t\t<th>@lang('strings.Settings')</th>\n' +
         '\t\t\t\t\t\t\t\t</tr>\n' +
         '\t\t\t\t\t\t\t</thead>\n' +
         '\t\t\t\t\t\t\t<tbody>\n' +
         programs +
         '\t\t\t\t\t\t\t</tbody>\n' +
         '\t\t\t\t\t\t</table>';


     return table1
 }






 $(document).ready(function () {
     var table = $('#xtreme-table_data').DataTable();
     $.fn.dataTable.ext.errMode = 'none';
     $('#xtreme-table_data tbody').on('click', 'td.details-control', function () {
         var tr = $(this).closest('tr');
         var row = table.row(tr);
         if (row.child.isShown()) {
             row.child.hide();
             tr.removeClass('shown');
         } else {
             $.get("{{ url('admin/destination/get-location') }}/" + row.data()[1], function (data) {
                 row.child(format(data)).show();
             });
             tr.addClass('shown');
         }
     });
 });




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
