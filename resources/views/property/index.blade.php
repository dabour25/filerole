@extends('layouts.admin', ['title' => __('strings.property') ])
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
                @if(count($propertys)==0)

                    <h2><strong>   لا توجد وحدات عقارية من فضلك اضاف وحده عقارية</h2>


                @endif
            @if(!empty($serachpropertys))
                <form method="post" action="{{url('admin/property/search')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-lg-3 col-md-4 col-sm-6 m-b-sm">

                        <select class="form-control js-select" name="property_name"  >
                            <option value="0" >@lang('strings.property')</option>
                            @foreach($serachpropertys as $property)
                                <option {{ app('request')->input('property_name') == $property->id ? 'selected' : ''}}  value="{{$property->name}}">{{ app()->getLocale() == 'ar' ? $property->name  : $property->name_en  }}</option>
                            @endforeach
                        </select>                                        </div>
                    <button id="search_button" type="submit"  onclick="" class="btn btn-primary btn-lg">@lang('strings.Search')</button>
                </form>

                @endif

                <a href="{{url('admin/property/add')}}">
                    <button type="button" class="btn btn-primary btn-lg">@lang('strings.create_property')</button>
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
                                    <th>{{app()->getLocale() == 'ar'? __('strings.Arabic_name'): __('strings.English_name')}}</th>
                                    <th>{{ __('strings.destinations') }}</th>
                                    <th>{{ __('strings.Photo') }}</th>
                                    <th>{{ __('strings.photos_slider') }}</th>
                                    <th>@lang('strings.Settings')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($propertys))
                                @foreach($propertys as $property)
                                    <tr>
                                        <td>{{app()->getLocale() == 'ar'? $property->name :$property->name_en }}</td>
                                        <td>{{ app()->getLocale() == 'ar'?$property->destination_name_ar :$property->destination_name_en }}</td>
                                        <td><a href="{{ $property->image !== null ? asset(str_replace( ' ', '%20','images/'.$property->file)) : asset('images/profile-placeholder.png') }}" target="_blank"><img src="{{ $property->image !== null ? asset(str_replace( ' ', '%20','images/'.$property->file)) : asset('images/profile-placeholder.png') }}" width="40" height="40"></a></td>
                                        <td>
                                            <a href="{{url('admin/property/slider/'.$property->id )}}"
                                               class="btn btn-primary btn-xs" data-toggle="tooltip"
                                               data-placement="bottom" title=""
                                               data-original-title="{{ __('strings.property_slider_show') }} "> <i
                                                        class="fa fa-image"></i></a>
                                        </td>
                                        <td>
                                            <a href="{{url('admin/property/updated/'. $property->id) }}"
                                               class="btn btn-primary btn-xs" data-toggle="tooltip"
                                               data-placement="bottom" title=""
                                               data-original-title="{{ __('strings.edit') }} "> <i
                                                        class="fa fa-pencil"></i></a>
                                            <a href="{{url('admin/delete_hotel_pay_method/'.$property->id)}}"
                                               class="btn btn-danger btn-xs" data-toggle="tooltip"
                                               data-placement="bottom" title=""
                                               data-original-title="{{ __('strings.remove') }} "
                                            > <i class="fa fa-trash"></i></a>


                                        </td>
                                    </tr>
                                @endforeach
                               @endif
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
