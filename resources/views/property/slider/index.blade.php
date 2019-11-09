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
    <!--<div class="page-title">-->
    <!--    <h3>{{ __('strings.Categories_type') }}</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>-->
    <!--            <li class="active">{{ __('strings.Categories_type') }}</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet"/>

    <div class="modal fade newModel" id="addclient" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
            </div>
            <!-- Modal content-->

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
                   <h1>{{ __('strings.property_slider_show_title') }}</h1>
                    <br>
                    <h2 ><strong>{{app()->getLocale() == 'ar'? $property->name :$property->name_en}}</strong></h2>
                    <br>
                    <div>
                        <img class="img-thumbnail img-circle" src="{{ $property->image !== null ? asset($property->myphoto->file) : asset('images/profile-placeholder.png') }}">
                    </div>
                    <hr>
                    <br>
                    <a href="{{url('admin/property')}}">
                        <button type="button" class="btn btn-info btn-lg">@lang('strings.back_to_property')</button>
                    </a>

                </div>
                <hr>
                <br>
                @if(count($mysliders)==0)

                    <h2><strong>لا يوجد اي صور لعرضها برجاء اضافه صور الان</strong></h2>

                @endif
                <a href="{{url('admin/property/slider/add/'.$property->id)}}">
                    <button type="button" class="btn btn-primary btn-lg">@lang('strings.create_property_slider')</button>
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
                                    <th>{{ __('strings.slider_show') }}</th>
                                    <th>@lang('strings.Settings')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($mysliders as $myslider)
                                    <tr>

                                        <td><img src="{{ $myslider->image !== null ? asset(str_replace( ' ', '%20', $myslider->photo->file)) : asset('images/profile-placeholder.png') }}" width="40" height="40"></td>
                                        <td>{{ $myslider->rank }}</td>
                                        <td><a href="{{ $myslider->image !== null ? asset(str_replace( ' ', '%20',$myslider->photo->file)) : asset('images/profile-placeholder.png') }}"
                                               class="btn btn-primary btn-xs" data-toggle="tooltip"
                                               data-placement="bottom" target="_blank"
                                               data-original-title="{{ __('strings.slider_show') }} "> <i
                                                        class="fa fa-eye"></i></a></td>
                                        <td>
                                            <a href="{{url('admin/property/slider/updated/'. $myslider->id)}}"
                                               class="btn btn-primary btn-xs" data-toggle="tooltip"
                                               data-placement="bottom" title=""
                                               data-original-title="{{ __('strings.edit') }} "> <i
                                                        class="fa fa-pencil"></i></a>
                                            <a href="{{url('admin/property/slider/remove/'. $myslider->id )}}"
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


@endsection