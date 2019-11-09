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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet"/>

    <div class="modal fade newModel" id="addclient" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>


        </div>
    </div>

    <div class="modal  newModel" id="Modal1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" onclick="close_modal1()" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-content">
                <div class="modal-body" style="overflow: hidden">
                    <form method="post" id="addCategories" action="{{url('admin/rooms/photos/add-new')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$room->id}}" >

                        <div class="panel panel-white">
                            <div class="panel-heading clearfix">
                                <h4 class="panel-title">@lang('strings.Photo')</h4>
                            </div>
                            <strong
                                    class="text-danger">*</strong>
                            <label>اختار الصوره</label>
                            <input type="file" name="photo" id="photo" data-min-width="400" data-min-height="200" >
                             <span class="help-block">
                                 <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 400*200</strong>
                             </span>
                             <hr>
                            <i id="photook" style="display:none" class="fa fa-check  color-success"></i>
                            <i id="photookcancel" style="display:none" class="fa fa-times color-danger"></i>
                            <div id="photook_error" style="color: red;"></div>
                        </div>


                        <div class="col-md-6 form-group{{$errors->has('rank') ? ' has-error' : ''}}"><strong
                                    class="text-danger"></strong>
                            <label class="control-label" for="rank">{{ __('strings.rank') }}</label>
                            <input type="number" class="form-control" name="rank" id="rank"
                                   value="{{old('rank')}}">
                            <i  style="display:none" class="fa fa-check  color-success nameokcategory_num"></i>
                            <i  style="display:none" class="fa fa-times color-danger namecancelcategory_num"></i>
                            <div class="category_num_error" style="color: red;"></div>
                        </div>

                        <div class="col-md-12 form-group text-right">
                            <button type="submit" class="btn btn-primary btn-lg"> {{ __('strings.Save') }} </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal  newModel" id="Modal2" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" onclick="close_modal()" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-content">
                <div class="modal-body" style="overflow: hidden">
                    <form method="post" id="updatedSlider" action="{{url('admin/rooms/photos/updated')}}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="slider_id" >

                        <div class="panel panel-white">
                            <div class="panel-heading clearfix">
                                <h4 class="panel-title"></h4>
                            </div>
                            <strong
                                    class="text-danger">@lang('strings.Photo')</strong>
                            <label>اختار الصوره</label>
                            <input type="file" name="photo" id="photo_" data-min-width="400" data-min-height="200">
                             <span class="help-block">
                                 <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 400*200</strong>
                             </span>
                             <hr>
                            <i id="photo_ook" style="display:none" class="fa fa-check  color-success"></i>
                            <i id="photo_kcancel" style="display:none" class="fa fa-times color-danger"></i>
                            <div id="photo_ook_error" style="color: red;"></div>
                        </div>
                        <div id="showPhoto">
                        </div>


                        <br>

                        <div class="col-md-6 form-group{{$errors->has('rank') ? ' has-error' : ''}}"><strong
                                    class="text-danger"></strong>
                            <label class="control-label" for="rank">{{ __('strings.rank') }}</label>
                            <input type="number" class="form-control" name="rank_2" id="rank_2"
                                   value="{{old('rank')}}">
                            <i  style="display:none" class="fa fa-check  color-success nameokcategory_num"></i>
                            <i  style="display:none" class="fa fa-times color-danger namecancelcategory_num"></i>
                            <div class="category_num_error"></div>
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
                            {{ DB::table('function_new')->where('id',235)->value('description') }}
                        @else
                            {{ DB::table('function_new')->where('id',235)->value('description_en') }}
                        @endif
                    </p>
                    <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                    </a>
                </div>

                </br>

                <br>
                <div class="" style=" text-align: center !important;">
                    <h1>{{ __('strings.show_rooms_photo') }}</h1>
                    <br>
                    <h2 ><strong>{{app()->getLocale() == 'ar'? $room->name :$room->name_en}}</strong></h2>
                    <br>
                    <div>
                        <img class="img-thumbnail img-circle" src="{{ $room->photo_id !== null ? asset($room->photo->file) : asset('images/profile-placeholder.png') }}">
                    </div>
                    <hr>
                    <br>
                    <a href="{{url('admin/rooms')}}">
                        <button type="button" class="btn btn-info btn-lg">@lang('strings.rooms')</button>
                    </a>

                </div>
                <hr>
                <br>
                @if(count($sliders)==0)

                    <h2><strong>لا يوجد اي صور لعرضها برجاء اضافه صور الان</strong></h2>

                @endif
                <a href="#">
                    <button type="button" id="modal_button1" onclick="add_room()" class="btn btn-primary btn-lg">@lang('strings.create_property_slider')</button>
                </a>


                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">@lang('strings.property')</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>{{ __('strings.slider_display') }}</th>
                                    <th>{{ __('strings.slider_num') }}</th>
                                    <th>@lang('strings.Settings')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sliders as $myslider)
                                    <tr>

                                        <td>
                                            @if($myslider->image)
                                                <a target="_blank" href="{{$myslider->image? asset($myslider->photo->file) : asset('images/profile-placeholder.png')}}"> <img src="{{$myslider->image? asset($myslider->photo->file) : asset('images/profile-placeholder.png') }}" width="40" height="40"></a>
                                            @endif
                                        </td>
                                        <td>{{ $myslider->rank }}</td>
                                        <td>
                                            <a href="#"
                                               class="btn btn-primary btn-xs" data-toggle="tooltip"
                                               data-placement="bottom" id="getPhotos{{$myslider->id}}" onclick="updated({{$myslider->id}})" data-image="{{$myslider->image?$myslider->photo->file:''}}" data-rank="{{$myslider->rank}}"
                                               data-original-title="{{ __('strings.edit') }} "> <i
                                                        class="fa fa-pencil"></i></a>
                                            <a href="{{url('admin/rooms/photos/deleted/'. $myslider->id )}}"
                                               class="btn btn-primary btn-xs" data-toggle="tooltip"
                                               data-placement="bottom" title=""
                                               data-original-title="{{ __('strings.remove') }} "
                                               @if(app()->getLocale() == 'ar')
                                               onclick="return confirm('تأكيد حذف الصوره')"
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
                </div>
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
    
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
        function add_room() {

            var modal2 = document.getElementById('Modal1');
            modal2.style.display = "block";

        };

        function close_modal1() {
            var modal2 = document.getElementById('Modal1');
            modal2.style.display = "none";
        };

        $("#addCategories").validate({
            errorClass: "has-error",
            validClass: "has-success",
            rules: {
              "photo":{
                    required: true,
                    accept: "image/*"
                },
                "rank":{
                    required: false,
                    number: true
                }

            },

            messages: {

              "photo":{
                    required:'يجب ادخال صوره',
                    accept:'يجب ان تكون صوره',
                },
                "rank":{
                    number:'يجب ان يكون رقما'
                }

            }, errorPlacement: function (error, element) {
                 if (element.attr('id') == 'photo') {
                    $('#photook').hide();
                    $('#photookcancel').show();
                    $('#photook_error').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();

                }
                 else if(element.attr('id') == 'rank'){
                     $('.nameokcategory_num').show();
                     $('.namecancelcategory_num').html('<div class="error-message">' + error.html() + '</div>');
                     error.remove();
                 }
                else {
                    element.next().remove();
                    error.insertAfter("#" + element.attr('id'));
                }

            },

        });
        $("#updatedSlider").validate({
            errorClass: "has-error",
            validClass: "has-success",
            rules: {
              "photo":{
                    required: false,
                    accept: "image/*"
                },
                "rank":{
                    required: false,
                    number: true
                }

            },

            messages: {
              "photo":{
                    accept:'يجب ان تكون صوره',
                },
                "rank_2":{
                    number:'يجب ان يكون رقما'
                }

            }, errorPlacement: function (error, element) {
                 if (element.attr('id') == 'photo_') {
                    $('#photo_ook').hide();
                    $('#photo_ookcancel').show();
                    $('#photo_ook_error').html('<div class="error-message">' + error.html() + '</div>');
                    error.remove();

                }
                 else if(element.attr('id') == 'rank'){
                     $('.nameokcategory_num').show();
                     $('.namecancelcategory_num').html('<div class="error-message">' + error.html() + '</div>');
                     error.remove();
                 }
                else {
                    element.next().remove();
                    error.insertAfter("#" + element.attr('id'));
                }

            },

        });

        function updated(id) {

            var modal2 = document.getElementById('Modal2');
            modal2.style.display = "block";

            var rank =$('#getPhotos'+id).data('rank');

            $('input[name="slider_id"]').val(id);
            $('input[name="rank_2"]').val(rank);
            var photo =$('#getPhotos'+id).data('image');
            console.log(photo);
            if(photo !=null)
            {
                $('#showPhoto').append(
                    '<img class="img-thumbnail" src="{{url('')}}'+ photo +'" width="100" height="100">'
                );

                console.log('not null');
            }



        };

        function close_modal() {
            var modal2 = document.getElementById('Modal2');
            modal2.style.display = "none";

            $('#showPhoto').empty();

        };




    </script>

@endsection