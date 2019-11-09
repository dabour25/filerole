@extends('layouts.admin', ['title' => __('strings.Main_Settings') ])
@section('styles')
    <link href="{{ asset('plugins/bootstrap-colorpicker-master/dist/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')

    <!--<div class="page-title">-->
    <!--    <h3>@lang('strings.Main_Settings')</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>-->
    <!--            <li class="active">@lang('strings.Main_Settings')</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    @if(Session::has('settings_saved'))
        <div class="alert alert-success"><i class="icon-check"></i> {{session('settings_saved')}} </div>
    @endif

    @if ($errors->has('contact_email') or $errors->has('business_logo_light')
    or $errors->has('business_logo_dark') or $errors->has('cover'))
        <div class="alert alert-danger">
            {{ __('backend.settings_error') }}
        </div>
    @endif

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                 <div class="alert_new">
                          <span class="alertIcon">
                              <i class="fas fa-exclamation-circle"></i>
                           </span>
                          <p>
                              @if (app()->getLocale() == 'ar')
            {{ DB::table('function_new')->where('id',48)->value('description') }}
            @else
            {{ DB::table('function_new')->where('id',48)->value('description_en') }}
            @endif
                          </p>
                          <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                          </a>
                      </div>

                <div role="tabpanel" class="taps-set">

                    <div class="row">
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 no-padd">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills" role="tablist">
                                <li role="presentation" @if(Request::is('admin/settings')) class="active" @endif >
                                    <a href="#business" role="tab" data-toggle="tab">
                                        <i class="fas fa-cog"></i>&nbsp;&nbsp;@lang('strings.basic_settings')
                                    </a>
                                </li>
                                <li role="presentation"
                                    @if(Request::is('admin/settings/setcomp')) class="active" @endif >
                                    <a href="#setcomp" role="tab" data-toggle="tab">
                                        <i class="fas fa-home"></i>&nbsp;&nbsp;@lang('strings.settings')
                                    </a>
                                </li>
                                <li role="presentation"
                                    @if(Request::is('admin/settings/frontapp')) class="active" @endif >
                                    <a href="#frontapp" role="tab" data-toggle="tab">
                                        <i class="fas fa-laptop-code"></i>&nbsp;&nbsp;@lang('strings.front_settings')
                                    </a>
                                </li>
                                <li role="presentation"
                                    @if(Request::is('admin/settings/invoiceset')) class="active" @endif >
                                    <a href="#invoiceset" role="tab" data-toggle="tab">
                                        <i class="fas fa-file-alt"></i>&nbsp;&nbsp;@lang('strings.invoice_settings')
                                    </a>
                                </li>
                                <li role="presentation"
                                    @if(Request::is('admin/settings/buyinternet')) class="active" @endif >
                                    <a href="#buyinternet" role="tab" data-toggle="tab">
                                        <i class="fas fa-cart-plus"></i>&nbsp;&nbsp; @lang('strings.online_payment')
                                    </a>
                                </li>
                                <li role="presentation"
                                    @if(Request::is('admin/settings/backupset')) class="active" @endif >
                                    <a href="#backupset" role="tab" data-toggle="tab">
                                        <i class="fas fa-database"></i>&nbsp;&nbsp; @lang('strings.backup')
                                    </a>
                                </li>

                                @if(permissions('tax_view') == 1)
                                    <li role="presentation" @if(Request::is('admin/settings/tax')) class="active" @endif >
                                        <a href="#tax" role="tab" data-toggle="tab">
                                            <i class="icon-credit-card"></i>&nbsp;&nbsp;
                                            @lang('strings.Tax_Settings')
                                        </a>
                                    </li>
                                @endif
                                @if(permissions('banks_view') == 1)
                                    <li role="presentation"
                                        @if(Request::is('admin/settings/banking')) class="active" @endif>
                                        <a href="#banking" role="tab" data-toggle="tab">
                                            <i class="icon-calendar"></i>&nbsp;&nbsp;@lang('strings.Bank_accounts')
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 no-padd">

                            <!-- Tab panes -->
                            <div class="tab-content tap-up">

                                <div role="tabpanel"
                                     class="tab-pane @if(Request::is('admin/settings')) active @endif  fade in"
                                     id="business">

                                    <h3 class="title-tap">@lang('strings.basic_settings_title')</h3>

                                    <ul class="nav nav-tabs navinside">
                                        <li class="active"><a data-toggle="tab" href="#busn0">@lang('strings.basic')</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content tab-contentinside">
                                        <div id="busn0" class="tab-pane fade in active">
                                            <form method="post" action="{{ url('admin/settings/display')}}"
                                                  enctype="multipart/form-data" id="display">
                                                {{csrf_field()}}
                                                <div class="row clearfix">
                                                    <div class="col-md-6 col-xs-12">
                                                        <div class="row">

                                                            <div class="form-group col-md-12 col-xs-12">
                                                                <label><strong>@lang('strings.date_format')</strong></label>
                                                                <select name="date"
                                                                        data-placeholder="تحديد صيفة التاريخ"
                                                                        required="required" class="js-select">
                                                                    <option {{App\Settings::where(['key' => 'date', 'org_id' => Auth::user()->org_id])->value('value') == 'm-d-Y' ? 'selected' : ''}} value="m-d-Y">
                                                                        {{ date('m-d-Y') }}
                                                                    </option>
                                                                    <option {{App\Settings::where(['key' => 'date', 'org_id' => Auth::user()->org_id])->value('value') == 'm/d/Y' ? 'selected' : ''}} value="m/d/Y">
                                                                        {{ date('m/d/Y') }}
                                                                    </option>
                                                                    <option {{App\Settings::where(['key' => 'date', 'org_id' => Auth::user()->org_id])->value('value') == 'd-m-Y' ? 'selected' : ''}} value="d-m-Y">
                                                                        {{ date('d-m-Y') }}
                                                                    </option>
                                                                    <option {{App\Settings::where(['key' => 'date', 'org_id' => Auth::user()->org_id])->value('value') == 'd/m/Y' ? 'selected' : ''}} value="d/m/Y">
                                                                        {{ date('d/m/Y') }}
                                                                    </option>
                                                                    <option {{App\Settings::where(['key' => 'date', 'org_id' => Auth::user()->org_id])->value('value') == 'M d Y' ? 'selected' : ''}} value="M d Y">
                                                                        {{ date('M d Y') }}
                                                                    </option>
                                                                    <option {{App\Settings::where(['key' => 'date', 'org_id' => Auth::user()->org_id])->value('value') == 'Y M d' ? 'selected' : ''}} value="Y M d">
                                                                        {{ date('Y').date('M') .date('d')   }}
                                                                    </option>
                                                                    <option {{App\Settings::where(['key' => 'date', 'org_id' => Auth::user()->org_id])->value('value') == 'D M Y' ? 'selected' : ''}} value="D M Y">
                                                                        {{ date('D M Y') }}
                                                                    </option>
                                                                    <option {{App\Settings::where(['key' => 'date', 'org_id' => Auth::user()->org_id])->value('value') == 'd.m.Y' ? 'selected' : ''}} value="d.m.Y">
                                                                        {{ date('d.m.Y') }}
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group col-md-12 col-xs-12">
                                                                <label><strong>@lang('strings.decimal_place')</strong></label>
                                                                <select name="decimal_place" class="form-control js-select"
                                                                        id="decimal_place"
                                                                        data-placeholder="تحديد منزلة عشرية"
                                                                        required="required">
                                                                    <option {{App\Settings::where(['key' => 'decimal_place', 'org_id' => Auth::user()->org_id])->value('value') == '0' ? 'selected' : ''}}  value="0">
                                                                        0 (1)
                                                                    </option>
                                                                    <option {{App\Settings::where(['key' => 'decimal_place', 'org_id' => Auth::user()->org_id])->value('value') == '1' ? 'selected' : ''}} value="1">
                                                                        1 (1.0)
                                                                    </option>
                                                                    <option {{App\Settings::where(['key' => 'decimal_place', 'org_id' => Auth::user()->org_id])->value('value') == '2' ? 'selected' : ''}} value="2">
                                                                        2 (1.00)
                                                                    </option>
                                                                    <option {{App\Settings::where(['key' => 'decimal_place', 'org_id' => Auth::user()->org_id])->value('value') == '3' ? 'selected' : ''}} value="3">
                                                                        3 (1.000)
                                                                    </option>
                                                                    <option {{App\Settings::where(['key' => 'decimal_place', 'org_id' => Auth::user()->org_id])->value('value') == '4' ? 'selected' : ''}} value="4">
                                                                        4 (1.0000)
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <!--<div class="form-group col-md-12 col-xs-12">-->
                                                            <!--    <label><strong> انت تبيع </strong></label>-->
                                                            <!--    <select name="sold_item_type" class="form-control" id="sold_item_type" required="required">-->
                                                        <!--        <option {{  App\Settings::where(['key' => 'sold_item_type', 'org_id' => Auth::user()->org_id])->value('value') == '0' ? 'selected' : '' }} value="0" selected="selected">الخدمات والمنتجات</option>-->
                                                        <!--        <option {{  App\Settings::where(['key' => 'sold_item_type', 'org_id' => Auth::user()->org_id])->value('value') == '1' ? 'selected' : '' }} value="1">المنتجات فقط</option>-->
                                                        <!--        <option {{  App\Settings::where(['key' => 'sold_item_type', 'org_id' => Auth::user()->org_id])->value('value') == '2' ? 'selected' : '' }} value="2">الخدمات فقط</option>-->
                                                            <!--    </select>-->
                                                            <!--</div>-->
                                                            <div class="form-group col-md-12 col-xs-12">
                                                                <label><strong>{{__('strings.you_buy')}}</strong></label>
                                                                <select name="sold_item_type" class="form-control js-select" id="sold_item_type" required="required">
                                                                    @foreach($activity_labels as $value)

                                                                        <option {{  \App\Settings::where(['key' => 'sold_item_type', 'org_id' => Auth::user()->org_id])->first()->value == $value->value ? 'selected' : '' }} value="{{$value->value}}">{{$value->value}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            @if($basket==1)
                                                                <div class="form-group col-md-12 col-xs-12">
                                                                    <label><strong>@lang('strings.electronic_payment_availabilty')</strong></label>
                                                                    <label class="switch">
                                                                        <input name="basket" type="checkbox"
                                                                               id="basket" {{ App\Settings::where(['key' => 'basket', 'org_id' => Auth::user()->org_id])->first()->value == 'on' ? 'checked' : ''}}>
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-xs-12">
                                                        <div class="row">
                                                            <!--<div class="form-group col-md-12 col-xs-12">-->
                                                        <!--    <label><strong>@lang('strings.background_color')</strong></label>-->
                                                            <!--    <button type="button"-->
                                                            <!--            class="btn btn-info btn-md shape-btn"-->
                                                            <!--            id="myopenbg">-->
                                                        <!--        <i class="fa fa-plus"></i> @lang('strings.select')-->
                                                            <!--    </button>-->
                                                            <!--</div>-->
                                                            <!--<div class="form-group col-md-12 col-xs-12">-->
                                                        <!--    <label><strong>@lang('strings.buttons')</strong></label>-->
                                                            <!--    <button type="button"-->
                                                            <!--            class="btn btn-info btn-md shape-btn"-->
                                                            <!--            id="myBtn">-->
                                                        <!--        <i class="fa fa-plus"></i> @lang('strings.select')-->
                                                            <!--    </button>-->
                                                            <!--</div>-->


                                                            <div class="form-group col-md-12 col-xs-12">
                                                                <label><strong>@lang('strings.navbar')</strong></label>
                                                                <label class="switch">
                                                                    <input name="navbar" type="checkbox"
                                                                           id="checkbox4" {{App\Settings::where(['key' => 'navbar', 'org_id' => Auth::user()->org_id])->value('value') == 'on' ? 'checked' : ''}} >
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </div>

                                                            <div class="form-group col-md-12 col-xs-12">
                                                                <label><strong>@lang('strings.loading')</strong></label>
                                                                <label class="switch">
                                                                    <input name="loading" type="checkbox"
                                                                           id="loadingcheck" {{App\Settings::where(['key' => 'loading', 'org_id' => Auth::user()->org_id])->value('value') == 'on' ? 'checked' : ''}}>
                                                                    <span class="slider round"></span>
                                                                </label>

                                                            </div>

                                                            <div class="form-group col-md-12 col-xs-12">
                                                                <label><strong>@lang('strings.helplinks')</strong></label>
                                                                <label class="switch">
                                                                    <input name="helplinks" type="checkbox"
                                                                           id="helplinks_check" {{ App\Settings::where(['key' => 'helplinks', 'org_id' => Auth::user()->org_id])->value('value') == 'on' ? 'checked' : ''}}>
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </div>

                                                            <div class="form-group col-md-12 col-xs-12">
                                                                <label><strong>القائمة</strong></label>
                                                                <label class="switch">
                                                                    <input name="menu" type="checkbox"
                                                                           id="menu_check" {{ App\Settings::where(['key' => 'menu', 'org_id' => Auth::user()->org_id])->value('value') == 'on' ? 'checked' : ''}}>
                                                                    <span class="slider round"></span>
                                                                </label>
                                                            </div>

                                                            <div class="form-group col-md-12 col-xs-12">
                                                                <label><strong>@lang('strings.session')</strong></label>
                                                                <label class="switch">
                                                                    <input name="session" id="session" type="checkbox"  {{App\Settings::where(['key' => 'session', 'org_id' => Auth::user()->org_id])->value('value') == 'on' ? 'checked' : ''}}>
                                                                    <span class="slider round"></span>
                                                                </label>
                                                                <div @if(App\Settings::where(['key' => 'session', 'org_id' => Auth::user()->org_id])->value('value') == 'on')  class="timeformat" @else class="timeformat" style="display: none;" @endif>
                                                                    <input name="session_time" style="float: left; width: 16%;" class="form-control timeformat" maxlength="2" min="1" max="10" onkeyup="if(this.value > 10 || this.value<1) this.value = null;" type="number" value="{{ App\Settings::where(['key' => 'session_time', 'org_id' => Auth::user()->org_id])->value('value') }}">
                                                                    <label class="timeformat" style="float: left; width: 20%;">@lang('strings.minutes')</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="mybgs" role="dialog">
                                                        <div class="modal-dialog">

                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal">&times;
                                                                    </button>
                                                                    <h4 class="modal-title">@lang('strings.background_color')</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div id="colors">
                                                                        <span class="btncolor"
                                                                              style="background: linear-gradient(-45deg, #EE7752, #E73C7E, #23A6D5, #23D5AB);"></span>
                                                                        <span class="btncolor"
                                                                              style="background: linear-gradient(to top, #a18cd1 0%, #fbc2eb 100%);"></span>
                                                                        <span class="btncolor"
                                                                              style="background: linear-gradient(to top, #fbc2eb 0%, #a6c1ee 100%);"></span>
                                                                        <span class="btncolor"
                                                                              style="background: linear-gradient(to top, #30cfd0 0%, #330867 100%);"></span>
                                                                        <span class="btncolor"
                                                                              style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></span>
                                                                        <span class="btncolor"
                                                                              style="background: linear-gradient(to top, #48c6ef 0%, #6f86d6 100%);"></span>
                                                                        <span class="btncolor"
                                                                              style="background:#eee;"></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="myButtons" role="dialog">
                                                        <div class="modal-dialog">

                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal">&times;
                                                                    </button>
                                                                    <h4 class="modal-title">@lang('strings.buttons_type')</h4>
                                                                </div>
                                                                <div class="modal-body">

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <button class="btn btn-primary btn-lg btn-save"
                                                            onclick="document.forms['display'].submit(); return false;">
                                                        <i class="icon-check"></i>&nbsp;&nbsp; @lang('strings.update_settings')
                                                    </button>

                                                </div>
                                            </form>
                                        </div>
                                        <!-- <div id="busn1" class="tab-pane fade">

                                              after finish will make it work aging -->
                                    <!--<form method="post" id="settings" enctype="multipart/form-data"
                                      action="{{ route('settings.update', 1) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}

                                            <div class="form-group col-md-12">
                                                <label><strong>@lang('strings.InternalItem_title')</strong></label>
                                        <input @if(App\InternalItem::where('org_id', Auth::user()->org_id)->value('appear') == 1) checked
                                               @endif type="radio" id="internal_item" name="internal_item" value="1">&nbsp;
                                        @lang('strings.InternalItem_yes')
                                            &nbsp;&nbsp;<br>
                                        <input @if(App\InternalItem::where('org_id', Auth::user()->org_id)->value('appear') == 0) checked
                                               @endif type="radio" id="internal_item" name="internal_item" value="0">&nbsp;@lang('strings.InternalItem_no')
                                    @if ($errors->has('internal_item'))
                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('internal_item') }}</strong>
                                            </span>
                                        @endif
                                            </div>
                                            <button class="btn btn-primary btn-lg btn-save" onclick="document.forms['settings'].submit(); return false;">
                                       <i class="icon-check"></i>&nbsp;&nbsp;تحديث الإعدادات
                                    </button>
                                </form>
                              </div>

                              <div id="busn2" class="tab-pane fade">

                                  <div class="row">
                                      <div class="col-md-6 col-xs-12">
                                        <div class="row">
                                        <div class="form-group col-md-12 col-xs-12">
                                                <label><strong>الدعم</strong></label>
                                                <label class="switch">
                                                  <input type="checkbox" id="loadingcheck" checked>
                                                  <span class="slider round"></span>
                                                </label>
                                            </div>
                                            <div class="form-group col-md-12 col-xs-12">
                                                <label><strong>إسم الدعم</strong></label>
                                                <input type="text" placeholder="Support">
                                            </div>
                                            <div class="form-group col-md-12 col-xs-12">
                                                <label><strong>مشرف الدعم</strong></label>
                                                <select name="language" data-placeholder="تحديد اللغة" required="required">
                                                <option value="english">manager</option>
                                                <option value="arabic" selected="selected">admin</option>
                                                </select>
                                            </div>
                                          </div>
                                      </div>
                                      <div class="col-md-6 col-xs-12"></div>
                                  </div>

                                </div>-->


                                    </div>

                                </div>

                                <div role="tabpanel"
                                     class="tab-pane @if(Request::is('admin/settings/setcomp')) active @endif  fade in"
                                     id="setcomp">

                                    <h3 class="title-tap">@lang('strings.settings_title')</h3>

                                    <form method="post" action="{{ url('admin/orgs/update', $org->id) }}"
                                          enctype="multipart/form-data" id="edit">
                                        {{csrf_field()}}

                                        <div class="stat-info">
                                            <h5 class="title-infors"> @lang('strings.settings_s1')</h5>
                                            <!--Org english name -->
                                            <div class="col-md-6 required form-group{{$errors->has('name_en') ? ' has-error' : ''}}">

                                                <label class="control-label"
                                                       for="name"><strong>@lang('strings.English_name')</strong></label>
                                                <input type="text" class="form-control" name="name_en"
                                                       value="{{$org->name_en}}">
                                                @if ($errors->has('name_en'))
                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                                    </span>
                                                @endif
                                            </div>


                                            <div class="col-md-6 required form-group{{$errors->has('name') ? ' has-error' : ''}}">

                                                <label class="control-label"
                                                       for="name"><strong>@lang('strings.Arabic_name')</strong></label>
                                                <input type="text" class="form-control" name="name"
                                                       value="{{$org->name}}">
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <div class="col-md-6 required form-group{{$errors->has('phone') ? ' has-error' : ''}}">

                                                <label class="control-label"
                                                       for="phone"><strong>@lang('strings.Phone')</strong></label>
                                                <input type="text" class="form-control" name="phone"
                                                       value="{{$org->phone}}">
                                                @if ($errors->has('phone'))
                                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('phone') }}</strong>
                                        </span>
                                                @endif
                                            </div>


                                            <div class="col-md-6 required form-group{{$errors->has('address') ? ' has-error' : ''}}">
                                                <label class="control-label"
                                                       for="address"><strong>@lang('strings.Address')</strong></label>
                                                <input type="text" class="form-control" name="address"
                                                       value="{{$org->address}}">
                                                @if ($errors->has('address'))
                                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('address') }}</strong>
                                        </span>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="control-label" for="disp_language">
                                                    <strong>@lang('strings.language')</strong>
                                                </label>
                                                <select name="disp_language"
                                                        required="required" class="js-select">
                                                    <span class="arrow-down"></span>
                                                    <option {{ $org->disp_language == 'en' ? 'selected' : ''}}  value="en">
                                                        English
                                                    </option>
                                                    <option {{ $org->disp_language == 'ar' ? 'selected' : ''}} value="ar">
                                                        العربية (Arabic)
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 required form-group{{$errors->has('currency') ? ' has-error' : ''}}">

                                                <label class="control-label" for="currency">
                                                    <strong> @lang('strings.currency') </strong>
                                                </label>

                                                <select class="form-control js-select required" name="currency">
                                                    @php
                                                        $currency_org=App\Currency::where('id','=',$org->currency)->first();
                                                    @endphp
                                                    <option value="{{ $org->currency}}">{{ app()->getLocale() == 'ar' ? $currency_org->name  : $currency_org->name_en  }}</option>
                                                    @php
                                                        $currencys= App\Currency::get();
                                                    @endphp
                                                    @foreach($currencys as $currency)
                                                        <option value="{{ $currency->id}}">{{ app()->getLocale() == 'ar' ? $currency->name  : $currency->name_en  }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('currency'))
                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('currency') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="col-md-6 required form-group{{$errors->has('email_crm') ? ' has-error' : ''}}">
                                                <label class="control-label"
                                                       for="email_crm"><strong>@lang('strings.email_customer')</strong>
                                                </label>
                                                <input type="text" class="form-control" name="email_crm"
                                                       value="{{$org->email_crm}}">
                                                @if ($errors->has('email_crm'))
                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('email_crm') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="col-md-6 required form-group{{$errors->has('email') ? ' has-error' : ''}}">
                                                <label class="control-label"
                                                       for="email"><strong>@lang('strings.email_support')</strong>
                                                </label>
                                                <input type="text" class="form-control" name="email"
                                                       value="{{$org->email}}">
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('mobile1') }}</strong>
                                        </span>
                                                @endif
                                            </div>

                                            @if($org->attendance_flag)
                                                <div class="col-md-6 required form-group{{$errors->has('attendance_start_day') ? ' has-error' : ''}}"
                                                     style="display:block;">
                                                    <label class="control-label"
                                                           for="attendance_start_day"><strong>@lang('strings.day_calcuate_attenden')</strong></label>
                                                    <input type="text" class="form-control" name="attendance_start_day"
                                                           value="{{$org->attendance_start_day}}">
                                                    @if ($errors->has('attendance_start_day'))
                                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('attendance_start_day') }}</strong>
                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="col-md-6 required form-group{{$errors->has('attendance_start_day') ? ' has-error' : ''}}"
                                                     style="display:none;">
                                                    <label class="control-label"
                                                           for="attendance_start_day"><strong>@lang('strings.mobile_one') </strong></label>
                                                    <input type="text" class="form-control" name="attendance_start_day"
                                                           value="{{$org->attendance_start_day}}">
                                                    @if ($errors->has('attendance_start_day'))
                                                        <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('attendance_start_day') }}</strong>
                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                             <div class="col-md-6 form-group{{$errors->has('work_time') ? ' has-error' : ''}}">
                                                <label class="control-label"
                                                       for="work_time"><strong>@lang('strings.work_time')</strong>
                                                </label>
                                                <input type="text" class="form-control" name="work_time"
                                                       value="{{$org->work_time}}">
                                              
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="add-logo">
                                                    {{$errors->has('image_id') ? ' has-error' : ''}}

                                                    <label for="image_id"
                                                           class="control-label">@lang('strings.org_img')</label>
                                                    <input type="file" id="image_id" name="image_id" onchange="document.getElementById('set2').src = window.URL.createObjectURL(this.files[0])" data-min-width="500" data-min-height="400">
                                                    <span class="help-block">
                                                        <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 500*400</strong>
                                                    </span>
                                                    <hr>
                                                    @if ($errors->has('image_id'))
                                                        <span class="help-block">
                                                          <strong class="text-danger">{{ $errors->first('image_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div style=" width: 35%;margin: auto;">
                                                    <img src="{{$org->photo ? asset($org->photo->file) : asset('images/profile-placeholder.png') }}"
                                                         class="img-responsive " id="set2">
                                                         @if($org->photo)
                                                        <div class="col-md-12 form-group text-right">
                                                            @if(app()->getLocale()== 'ar')
                                                                <a onclick="return confirm('هل انتا متاكد من حذف الصوره ؟')" href="{{url('admin/org/del/image_id/'.$org->id)}}"><button type="button" class="btn btn-danger btn-lg">حذف</button></a>
                                                            @else
                                                                <a onclick="return confirm('Are you sure you want to delete the picture?')" href="{{url('admin/org/del/image_id/'.$org->id)}}"><button type="button" class="btn btn-danger btn-lg">Deleted</button></a>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                        
                                        </div>

                                        <div class="clearfix"></div>

                                        <div class="panel-group" id="accordion" role="tablist"
                                             aria-multiselectable="true">
                                            <div class="row">

                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingTwo">
                                                        <h4 class="panel-title">
                                                            <a class="collapsed" role="button" data-toggle="collapse"
                                                               data-parent="#accordion" href="#collapseTwo"
                                                               aria-expanded="false" aria-controls="collapseTwo">
                                                                <i class="fas fa-plus-square"></i> @lang('strings.contact_us')
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseTwo" class="panel-collapse collapse"
                                                         role="tabpanel" aria-labelledby="headingTwo">
                                                        <div class="panel-body">

                                                            <div class="col-md-6 required form-group{{$errors->has('mobile1') ? ' has-error' : ''}}">
                                                                <label class="control-label"
                                                                       for="mobile1">@lang('strings.mobile_one') </label>
                                                                <input type="text" class="form-control" name="mobile1"
                                                                       value="{{$org->mobile1}}">
                                                                @if ($errors->has('mobile1'))
                                                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('mobile1') }}</strong>
                                        </span>
                                                                @endif
                                                            </div>

                                                            <div class="col-md-6 required form-group{{$errors->has('mobile2') ? ' has-error' : ''}}">
                                                                <label class="control-label"
                                                                       for="mobile2"><strong>@lang('strings.mobile_two')</strong></label>
                                                                <input type="text" class="form-control" name="mobile2"
                                                                       value="{{$org->mobile2}}">
                                                                @if ($errors->has('mobile2'))
                                                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('mobile2') }}</strong>
                                        </span>
                                                                @endif
                                                            </div>

                                                            <div class="col-md-6 required form-group{{$errors->has('twitter') ? ' has-error' : ''}}">
                                                                <label class="control-label"
                                                                       for="twitter"><strong>@lang('strings.twitter')</strong></label>
                                                                <input type="text" class="form-control" name="twitter"
                                                                       value="{{$org->twitter}}">
                                                                @if ($errors->has('twitter'))
                                                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('twitter') }}</strong>
                                        </span>
                                                                @endif
                                                            </div>

                                                            <div class="col-md-6 required form-group{{$errors->has('facebook') ? ' has-error' : ''}}">
                                                                <label class="control-label"
                                                                       for="facebook"><strong>@lang('strings.facebook')</strong></label>
                                                                <input type="text" class="form-control" name="facebook"
                                                                       value="{{$org->facebook}}">
                                                                @if ($errors->has('facebook'))
                                                                    <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('facebook') }}</strong>
                                        </span>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-6 required form-group{{$errors->has('instgram') ? ' has-error' : ''}}">
                                                                <label class="control-label"
                                                                       for="instgram"><strong>إنستجرام</strong></label>
                                                                <input type="text" class="form-control" name="instgram"
                                                                       value="{{$org->instgram}}">
                                                                @if ($errors->has('instgram'))
                                                                    <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('instgram') }}</strong>
                                        </span>
                                                                @endif
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingOne">
                                                        <h4 class="panel-title">
                                                            <a role="button" data-toggle="collapse"
                                                               data-parent="#accordion" href="#collapseOne"
                                                               aria-expanded="false" aria-controls="collapseOne">
                                                                <i class="fas fa-plus-square"></i>@lang('strings.about_us')
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseOne" class="panel-collapse collapse"
                                                         role="tabpanel" aria-labelledby="headingOne">
                                                        <div class="panel-body">


                                                            <div class="col-md-12 required form-group{{$errors->has('about_us') ? ' has-error' : ''}}">

                                                                <label class="control-label"
                                                                       for="about_us"><strong>@lang('strings.about_org')</strong></label>
                                                                <textarea type="text"
                                                                          name="about_us">{{ app()->getLocale() == 'ar' ? $org->about_us  : $org->aboutus_en  }}</textarea>
                                                                @if ($errors->has('about_us'))
                                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('about_us') }}</strong>
                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-12 required form-group{{$errors->has('description') ? ' has-error' : ''}}">
                                                                <label class="control-label"
                                                                       for="description"><strong>@lang('strings.Description')</strong></label>
                                                                <textarea type="text"
                                                                          name="description">{{ app()->getLocale() == 'ar' ? $org->description  : $org->description_en  }}</textarea>
                                                                @if ($errors->has('description'))
                                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                                    </span>
                                                                @endif
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="bg-photo">
                                                                    {{$errors->has('front_image') ? ' has-error' : ''}}
                                                                    <label for="front_image"
                                                                           class="control-label"><strong>@lang('strings.log_img')</strong></label>
                                                                    <input type="file" id="front_image"
                                                                           name="front_image" onchange="document.getElementById('set3').src = window.URL.createObjectURL(this.files[0])" data-min-width="500" data-min-height="400">
                                                                            <span class="help-block">
                                                                                <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 500*400</strong>
                                                                            </span>
                                                                       <hr>
                                                                    @if ($errors->has('front_image'))
                                                                        <span class="help-block">
                                                                    <strong class="text-danger">{{ $errors->first('front_image') }}</strong>
                                                                </span>
                                                                    @endif
                                                                </div>
                                                                <div style="width: 85%; margin: 15px auto;">
                                                                    <img src="{{$org->front ? asset($org->front->file) : asset('images/profile-placeholder.png') }}"
                                                                         class="img-responsive" id="set3">
                                                                         
                                                                         @if($org->front)
                                                                        <div class="col-md-12 form-group text-right">
                                                                            @if(app()->getLocale()== 'ar')
                                                                                <a onclick="return confirm('هل انتا متاكد من حذف الصوره ؟')" href="{{url('admin/org/front/del/'.$org->id)}}"><button type="button" class="btn btn-danger btn-lg">حذف</button></a>
                                                                            @else
                                                                                <a onclick="return confirm('Are you sure you want to delete the picture?')" href="{{url('admin/org/front/del/'.$org->id)}}"><button type="button" class="btn btn-danger btn-lg">Deleted</button></a>
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div> {{$errors->has('location_map') ? ' has-error' : ''}}
                                                                    <strong
                                                                            class="text-danger"></strong>
                                                                    <label for="location_map"
                                                                           class="control-label">@lang('strings.img_map')</label>
                                                                    <input type="file" id="location_map"
                                                                           name="location_map" onchange="document.getElementById('set1').src = window.URL.createObjectURL(this.files[0])" data-min-width="500" data-min-height="400" >
                                                                            <span class="help-block">
                                                                               <strong class="text-danger" style="font-size:12px;">ابعاد الصوره لا تقل عن 500*400</strong>
                                                                           </span>
                                                                            <hr>
                                                                    @if ($errors->has('location_map'))
                                                                        <span class="help-block">
                                                            <strong class="text-danger">{{ $errors->first('location_map') }}</strong>
                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div style="width: 85%;margin: 15px auto;">
                                                                    <img src="{{$org->map ? asset($org->map->file) : asset('images/profile-placeholder.png') }}"
                                                                         class="img-responsive" id="set1">
                                                                          @if($org->map)
                                                                        <div class="col-md-12 form-group text-right">
                                                                            @if(app()->getLocale()== 'ar')
                                                                                <a onclick="return confirm('هل انتا متاكد من حذف الصوره ؟')" href="{{url('admin/org/del/map/'.$org->id)}}"><button type="button" class="btn btn-danger btn-lg">حذف</button></a>
                                                                            @else
                                                                                <a onclick="return confirm('Are you sure you want to delete the picture?')" href="{{url('admin/org/del/map/'.$org->id)}}"><button type="button" class="btn btn-danger btn-lg">Deleted</button></a>
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <button id="edit" type="submit" class="btn btn-primary btn-lg btn-save">
                                                    <i class="icon-check"></i>&nbsp;&nbsp; @lang('strings.update_settings')
                                                </button>


                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div role="tabpanel"
                                     class="tab-pane @if(Request::is('admin/settings/frontapp')) active @endif fade in"
                                     id="frontapp">

                                    <h3 class="title-tap"> @lang('strings.front_settings')</h3>

                                </div>

                                <div role="tabpanel"
                                     class="tab-pane @if(Request::is('admin/settings/invoiceset')) active @endif fade in"
                                     id="invoiceset">
                                    <style>

                                        .taps-set .tab-content {

                                            padding: 20px 35px 30px 35px;
                                            background: #fff;
                                            min-height: 100%;
                                            border: 1px solid #ddd;
                                            border-right: 0;
                                            overflow: hidden;

                                        }
                                    </style>
                                    <h3 class="title-tap">@lang('strings.invoice_template')</h3>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                                <a role="button" data-toggle="collapse"
                                                   data-parent="#accordion" href="#collapse_invoice"
                                                   aria-expanded="false" aria-controls="collapseOne">
                                                    <i class="fas fa-plus-square"></i> @lang('strings.invoice_setup_settings')
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse_invoice" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                <form method="post" action="{{ url('admin/settings/invoice_setup')}}" enctype="multipart/form-data" role="form">
                                                    {{csrf_field()}}
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>@lang('strings.Type')</th>
                                                            <th width="30%">@lang('strings.Value')</th>
                                                            <th>@lang('strings.Description')</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <input name="ids[]" type="hidden" value="1">
                                                        <tr>
                                                            <td>@lang('strings.individual_name')</td>
                                                            @php
                                                                $individual_name = App\InvoiceSetup::where(['type' => 1, 'org_id' => Auth::user()->org_id])->first();
                                                                $collective_name = App\InvoiceSetup::where(['type' => 2, 'org_id' => Auth::user()->org_id])->first();
                                                                $prefix_characters = App\InvoiceSetup::where(['type' => 3, 'org_id' => Auth::user()->org_id])->first();
                                                                $sequence = App\InvoiceSetup::where(['type' => 4, 'org_id' => Auth::user()->org_id])->first();
                                                                $due_date = App\InvoiceSetup::where(['type' => 5, 'org_id' => Auth::user()->org_id])->first();
                                                                $invoice_footer = App\InvoiceSetup::where(['type' => 6, 'org_id' => Auth::user()->org_id])->first();
                                                            @endphp
                                                            <td><input type="text" class="form-control" name="type_value[]" value="{{ $individual_name->value }}" id="type_value"></td>
                                                            <td><textarea class="form-control" type="text"  name="type_description[]">{{ $individual_name->description }}</textarea></td>
                                                        </tr>
                                                        <input name="ids[]" type="hidden" value="2">
                                                        <tr>
                                                            <td>@lang('strings.collective_name')</td>
                                                            <td><input type="text" class="form-control" name="type_value[]" value="{{ $collective_name->value }}" id="type_value"></td>
                                                            <td><textarea class="form-control" type="text"  name="type_description[]">{{ $collective_name->description }}</textarea></td>
                                                        </tr>
                                                        <input name="ids[]" type="hidden" value="3">
                                                        <tr>
                                                            <td>@lang('strings.prefix_characters')</td>
                                                            <td><input type="text" class="form-control" name="type_value[]" value="{{ $prefix_characters->value }}" id="type_value">

                                                            </td>
                                                            <td><textarea class="form-control" type="text"  name="type_description[]">{{ $prefix_characters->description }}</textarea></td>
                                                        </tr>
                                                        <input name="ids[]" type="hidden" value="4">
                                                        <tr>
                                                            <td>@lang('strings.sequence')</td>
                                                            <td><input type="number" class="form-control" name="type_value[]" value="{{ $sequence->value }}" id="type_value"></td>
                                                            <td><textarea class="form-control" type="text"  name="type_description[]">{{ $sequence->description }}</textarea></td>
                                                        </tr>
                                                        <input name="ids[]" type="hidden" value="5">
                                                        <tr>
                                                            <td>@lang('strings.due_date')</td>
                                                            <td><input type="text" class="form-control" name="type_value[]" value="{{ $due_date->value }}" id="type_value"></td>
                                                            <td><textarea class="form-control" type="text"  name="type_description[]">{{ $due_date->description }}</textarea></td>
                                                        </tr>
                                                        @if(App\org::where(['id' => Auth::user()->org_id])->value('plan_id') != 1)
                                                            <input name="ids[]" type="hidden" value="6">
                                                            <tr>
                                                                <td>@lang('strings.invoice_footer')</td>
                                                                <td><input type="text" class="form-control" name="type_value[]" value="{{ $invoice_footer->value }}" id="type_value"></td>
                                                                <td><textarea class="form-control" type="text"  name="type_description[]">{{ $invoice_footer->description }}</textarea></td>
                                                            </tr>
                                                        @endif
                                                        </tbody>
                                                    </table>



                                                <!--<div class="col-md-6 required form-group{{$errors->has('type') ? ' has-error' : ''}}">
                                                        <label class="control-label" for="twitter"><strong>@lang('strings.Type')</strong></label>
                                                        <select class="form-control" name="type" id="invoice_setup_type">
                                                            <option {{ old('type') == 0 ? 'selected' : ''}} value="0">@lang('strings.select')</option>
                                                            <option {{ old('type') == 1 ? 'selected' : ''}} value="1">@lang('strings.individual_name')</option>
                                                            <option {{ old('type') == 2 ? 'selected' : ''}} value="2">@lang('strings.collective_name')</option>
                                                            <option {{ old('type') == 3 ? 'selected' : ''}} value="3">@lang('strings.prefix_characters')</option>
                                                            <option {{ old('type') == 4 ? 'selected' : ''}} value="4">@lang('strings.sequence')</option>
                                                            <option {{ old('type') == 5 ? 'selected' : ''}} value="5">@lang('strings.due_date')</option>
                                                            @if(App\org::where(['id' => Auth::user()->org_id])->value('plan_id') !== 1)
                                                    <option {{ old('type') == 6 ? 'selected' : ''}} value="6">@lang('strings.invoice_footer')</option>
                                                            @endif
                                                        </select>
                                                        @if ($errors->has('type'))
                                                    <span class="help-block text-center">
                                                        <strong class="text-danger">{{ $errors->first('type') }}</strong>
                                                        </span>
                                                        @endif
                                                        </div>
                                                        <div class="col-md-6 required invoice_setup form-group{{$errors->has('type_value') ? ' has-error' : ''}}" @if($errors->has('type_value')) @else style="display: none" @endif>
                                                        <label class="control-label" for="type_value"><strong>@lang('strings.Value')</strong></label>
                                                        <input type="text" class="form-control" name="type_value" value="{{ old('type_value') }}" id="type_value">
                                                        @if ($errors->has('type_value'))
                                                    <span class="help-block text-center">
                                                    <strong class="text-danger">{{ $errors->first('type_value') }}</strong>
                                                        </span>
                                                       @else
                                                    <span class="help-block text-center invoice_setup_type_3" style="display: none">
                                                        <strong class="text-danger" > عند اضافة رقم المسلسل لايمكن اعادة تغيرة مره اخرى</strong>
                                                    </span>
@endif
                                                        </div>

                                                        <div class="col-md-12 required invoice_setup form-group{{$errors->has('type_description') ? ' has-error' : ''}}" style="display: none">
                                                        <label class="control-label" for="type_description"><strong>@lang('strings.description')</strong></label>
                                                        <textarea type="text"  name="type_description" id="type_description">{{ old('type_description') }}</textarea>
                                                    @if ($errors->has('type_description'))
                                                    <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('type_description') }}</strong>
                                                        </span>
                                                        @endif
                                                        </div>-->

                                                    <div class="col-md-12 form-group text-right">
                                                        <button type="submit" class="btn btn-primary btn-lg"> <i class="fas fa-save"></i> @lang('strings.Save')</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="templates">
                                        <div class="template template_creat">
                                            <div class="template-image"
                                                 style="background-image: url(https://invoice.fr3on.info/assets/img/create_template.jpg);">
                                                <div class="template-actions">
                                                    <a href="{{ url('admin/settings/create_template') }}"
                                                       class="btn btn-secondary btn-block" style="background:#469a1c !important;border-color:#469a1c !important">@lang('strings.create')</a>
                                                </div>
                                            </div>
                                            <h4 class="template-title">@lang('strings.blank')</h4>
                                        </div>

                                        @foreach(App\InvoiceTemplate::where('org_id', Auth::user()->org_id)->get() as $value)
                                            <div class="template">
                                                <div class="template-image"
                                                     style="background-image: url({{ asset('invoice_template').'/'.$value->preview }});">
                                                    @if(App\CustomerHead::where(['invoice_template' => $value->id,'org_id' => Auth::user()->org_id])->count() == 0)
                                                        <a href="{{ url('admin/settings/delete_template', $value->id) }}" class="overflow-delete"> <i class="fas fa-trash-alt"></i> </a>
                                                    @endif
                                                    <div class="overflow-number"> {{ App\CustomerHead::where(['invoice_template' => $value->id,'org_id' => Auth::user()->org_id])->count() }} </div>
                                                    <div class="template-actions">
                                                        @if(App\Settings::where(['key' => 'invoice_template', 'org_id' => Auth::user()->org_id])->value('value') == $value->id)
                                                            <a href="{{ url('admin/settings/customize_template', $value->id) }}"
                                                               class="btn btn-secondary btn-block " style="background:#5f5f5f !important;border-color:#5f5f5f !important">@lang('strings.edit')</a>
                                                        @else
                                                            <a href="{{ url('admin/settings/select_template', $value->id) }}"
                                                               class="btn btn-secondary btn-block" style="background:#5f5f5f !important;border-color:#5f5f5f !important">@lang('strings.select')</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <h4 class="template-title">{{ $value->name }}</h4>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>

                                <div role="tabpanel"
                                     class="tab-pane @if(Request::is('admin/settings/buyinternet')) active @endif fade in"
                                     id="buyinternet">

                                    <h3 class="title-tap">@lang('strings.update_online_payment') </h3>
                                    <div class="pay_steps">
                                        <div class="container">

                                            <!-- chash --->
                                            <div class="card card_payment">
                                                <div class="card-header" id="headingTwo">
                                                    <div class="row">
                                                        <form class="form_payment_back" method="post" action="{{ url('admin/settings/payment')}}" enctype="multipart/form-data" role="form">
                                                            {{csrf_field()}}
                                                            <div class="col-md-4 col-xs-12">
                                                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                                    <i class="fa fa-plus" aria-hidden="true"></i> {{__('strings.cash')}}
                                                                </button>
                                                            </div>
                                                            <div class="col-md-8 col-xs-12">
                                                                <div class="left_choose gateway-row">
                                                                    <div class="input-group ActiveButton">
                                                                        <input type="radio" name="cash_active" {{ \App\PaymentSetup::where(['gateway' => 'cash', 'org_id' => Auth::user()->org_id])->value('active') ==1  ? 'checked' : ''}} value="1"> {{__('strings.active')}}
                                                                    </div>
                                                                    <div class="input-group InActiveButton">
                                                                        <input type="radio" name="cash_active"  {{ \App\PaymentSetup::where(['gateway' => 'cash', 'org_id' => Auth::user()->org_id])->value('active') ==0  ? 'checked' : ''}} value="0"> {{__('strings.inactive')}}
                                                                    </div>
                                                                    <div class="input-group Default">
                                                                        <input type="radio" name="default" {{ \App\PaymentSetup::where(['gateway' => 'cash', 'org_id' => Auth::user()->org_id])->value('default') ==1  ? 'checked' : ''}} value="cash"> {{__('strings.default')}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4 col-xs-12">
                                                                <div class="right_img">
                                                                    <img src="https://cdn1.iconfinder.com/data/icons/business-finance-1-1/128/buy-with-cash-512.png">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 col-xs-12">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- paypal --->
                                            <div class="card card_payment">
                                                <div class="card-header" id="headingTwo">
                                                    <div class="row">
                                                        <div class="col-md-4 col-xs-12">
                                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                                                <i class="fa fa-plus" aria-hidden="true"></i> {{__('strings.paypal_standard')}}
                                                            </button>
                                                        </div>
                                                        <div class="col-md-8 col-xs-12">
                                                            <div class="left_choose gateway-row">
                                                                <div class="input-group ActiveButton">
                                                                    <input type="radio" name="paypal_active" {{ \App\PaymentSetup::where(['gateway' => 'paypal', 'org_id' => Auth::user()->org_id])->value('active') ==1  ? 'checked' : ''}} value="1"> {{__('strings.active')}}
                                                                </div>
                                                                <div class="input-group InActiveButton">
                                                                    <input type="radio" name="paypal_active" {{ \App\PaymentSetup::where(['gateway' => 'paypal', 'org_id' => Auth::user()->org_id])->value('active') ==0  ? 'checked' : ''}} value="0"> {{__('strings.inactive')}}
                                                                </div>
                                                                <div class="input-group Default">
                                                                    <input type="radio" name="default" {{ \App\PaymentSetup::where(['gateway' => 'paypal', 'org_id' => Auth::user()->org_id])->value('default') ==1  ? 'checked' : ''}} value="paypal"> {{__('strings.default')}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="collapse3" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4 col-xs-12">
                                                                <div class="right_img">
                                                                    <img src="http://pngimg.com/uploads/paypal/paypal_PNG2.png" class="paypal">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 col-xs-12">

                                                                <div class="input-group">
                                                                    <label>{{__('strings.user_name')}}</label>
                                                                    <input type="text"  name="paypal_user_name" value="{{\App\PaymentSetup::where(['gateway' => 'paypal', 'org_id' => Auth::user()->org_id])->value('acc_name')}}">
                                                                </div>
                                                                <div class="input-group">
                                                                    <label>{{__('strings.signature')}}</label>
                                                                    <input type="password" name="paypal_signature"  value="{{\App\PaymentSetup::where(['gateway' => 'paypal', 'org_id' => Auth::user()->org_id])->value('acc_signature')}}">
                                                                </div>
                                                                <div class="input-group">
                                                                    <label>{{__('strings.password')}}</label>
                                                                    <input type="password" name="paypal_password" value="{{\App\PaymentSetup::where(['gateway' => 'paypal', 'org_id' => Auth::user()->org_id])->value('acc_password')}}">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- stripe --->
                                            <div class="card card_payment">
                                                <div class="card-header" id="headingTwo">
                                                    <div class="row">
                                                        <div class="col-md-4 col-xs-12">
                                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                                <i class="fa fa-plus" aria-hidden="true"></i>{{__('strings.stripe')}}
                                                            </button>
                                                        </div>
                                                        <div class="col-md-8 col-xs-12">
                                                            <div class="left_choose gateway-row">
                                                                <div class="input-group ActiveButton">
                                                                    <input type="radio" name="stripe_active" {{ \App\PaymentSetup::where(['gateway' => 'stripe', 'org_id' => Auth::user()->org_id])->value('active') ==1  ? 'checked' : ''}} value="1"> {{__('strings.active')}}
                                                                </div>
                                                                <div class="input-group InActiveButton">
                                                                    <input type="radio" name="stripe_active" {{ \App\PaymentSetup::where(['gateway' => 'stripe', 'org_id' => Auth::user()->org_id])->value('active') ==0  ? 'checked' : ''}} value="0"> {{__('strings.inactive')}}
                                                                </div>
                                                                <div class="input-group Default">
                                                                    <input type="radio" name="default" {{ \App\PaymentSetup::where(['gateway' => 'stripe', 'org_id' => Auth::user()->org_id])->value('default') ==1  ? 'checked' : ''}} value="stripe"> {{__('strings.default')}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="collapse4" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4 col-xs-12">
                                                                <div class="right_img">
                                                                    <img src="https://europeansting.files.wordpress.com/2016/02/stripe-logo.png" class="paypal">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 col-xs-12">

                                                                <div class="input-group">
                                                                    {{-- <button class="btn btn-connect">{{('strings.connect')}}</button> --}}
                                                                </div>
                                                                <div class="input-group">
                                                                    <label>{{__('strings.user_name')}}</label>
                                                                    <input type="text"  name="stripe_user_name" value="{{\App\PaymentSetup::where(['gateway' => 'stripe', 'org_id' => Auth::user()->org_id])->value('acc_name')}}">
                                                                </div>
                                                                <div class="input-group">
                                                                    <label>{{__('strings.password')}}</label>
                                                                    <input type="password" name="stripe_password" value="{{\App\PaymentSetup::where(['gateway' => 'stripe', 'org_id' => Auth::user()->org_id])->value('acc_password')}}">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- authorize --->
                                            <div class="card card_payment">
                                                <div class="card-header" id="headingTwo">
                                                    <div class="row">
                                                        <div class="col-md-4 col-xs-12">
                                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                                                <i class="fa fa-plus" aria-hidden="true"></i> {{__('strings.authorize')}}
                                                            </button>
                                                        </div>
                                                        <div class="col-md-8 col-xs-12">
                                                            <div class="left_choose gateway-row">
                                                                <div class="input-group ActiveButton">
                                                                    <input type="radio" name="authorize_active" {{ \App\PaymentSetup::where(['gateway' => 'authorize', 'org_id' => Auth::user()->org_id])->value('active') ==1  ? 'checked' : ''}} value="1"> {{__('strings.active')}}
                                                                </div>
                                                                <div class="input-group InActiveButton">
                                                                    <input type="radio" name="authorize_active" {{ \App\PaymentSetup::where(['gateway' => 'authorize', 'org_id' => Auth::user()->org_id])->value('active') ==0  ? 'checked' : ''}} value="0"> {{__('strings.inactive')}}
                                                                </div>
                                                                <div class="input-group Default">
                                                                    <input type="radio" name="default" {{ \App\PaymentSetup::where(['gateway' => 'authorize', 'org_id' => Auth::user()->org_id])->value('default') ==1  ? 'checked' : ''}}  value="authorize"> {{__('strings.default')}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="collapse5" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4 col-xs-12">
                                                                <div class="right_img">
                                                                    <img src="https://lifterlms.com/wp-content/uploads/2019/06/LifterLMS-Authorize.Net-Payment-Gateway.png" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 col-xs-12">

                                                                <div class="input-group">
                                                                    <label>{{__('strings.user_name')}}</label>
                                                                    <input type="text" name="authorize_user_name" value="{{\App\PaymentSetup::where(['gateway' => 'stripe', 'org_id' => Auth::user()->org_id])->value('acc_name')}}">
                                                                </div>
                                                                <div class="input-group">
                                                                    <label>{{__('strings.login_id')}}</label>
                                                                    <input type="password" name="authorize_login_id" name="{{\App\PaymentSetup::where(['gateway' => 'stripe', 'org_id' => Auth::user()->org_id])->value('acc_signature')}}">
                                                                </div>
                                                                <div class="input-group">
                                                                    <label>{{__('strings.transaction_key')}}</label>
                                                                    <input type="password" name="authorize_transaction_key" value="{{\App\PaymentSetup::where(['gateway' => 'stripe', 'org_id' => Auth::user()->org_id])->value('acc_password')}}">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- google pay --->
                                            <div class="card card_payment">
                                                <div class="card-header" id="headingTwo">
                                                    <div class="row">
                                                        <div class="col-md-4 col-xs-12">
                                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse7" aria-expanded="false" aria-controls="collapse7">
                                                                <i class="fa fa-plus" aria-hidden="true"></i> {{__('strings.google_pay')}}
                                                            </button>
                                                        </div>
                                                        <div class="col-md-8 col-xs-12">
                                                            <div class="left_choose gateway-row">
                                                                <div class="input-group ActiveButton">
                                                                    <input type="radio" name="google_active" {{ \App\PaymentSetup::where(['gateway' => 'google', 'org_id' => Auth::user()->org_id])->value('active') ==1  ? 'checked' : ''}} value="1"> {{__('strings.active')}}
                                                                </div>
                                                                <div class="input-group InActiveButton">
                                                                    <input type="radio" name="google_active" {{ \App\PaymentSetup::where(['gateway' => 'google', 'org_id' => Auth::user()->org_id])->value('active') ==0  ? 'checked' : ''}}  value="0"> {{__('strings.inactive')}}
                                                                </div>
                                                                <div class="input-group Default">
                                                                    <input type="radio" name="default" {{ \App\PaymentSetup::where(['gateway' => 'google', 'org_id' => Auth::user()->org_id])->value('default') ==1  ? 'checked' : ''}}  value="google"> {{__('strings.default')}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="collapse7" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4 col-xs-12">
                                                                <div class="right_img">
                                                                    <img src="http://factjo.com/AllNewImages/large/2018_07_12_12_20_21.jpg" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8 col-xs-12">

                                                                <div class="input-group">
                                                                    <label>{{__('strings.user_name')}}</label>
                                                                    <input type="text" name="google_user_name" value="{{\App\PaymentSetup::where(['gateway' => 'google', 'org_id' => Auth::user()->org_id])->value('acc_name')}}">
                                                                </div>
                                                                <div class="input-group">
                                                                    <label>{{__('strings.login_id')}}</label>
                                                                    <input type="password" name="google_password" value="{{\App\PaymentSetup::where(['gateway' => 'google', 'org_id' => Auth::user()->org_id])->value('acc_password')}}">
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="btn btn-primary" type="submit" style="margin: 20px 0 0 0;"> <i class="fa fa-save"></i>{{__('strings.save')}} </button>
                                        </div>
                                    </div>
                                    </form>
                                </div>

                                <div role="tabpanel"
                                     class="tab-pane @if(Request::is('admin/settings/backupset')) active @endif fade in"
                                     id="backupset">

                                    <h3 class="title-tap">النسخ الإحتياطي</h3>

                                </div>

                                @if(permissions('tax_view') == 1)
                                    <div role="tabpanel"
                                         class="tab-pane @if(Request::is('admin/settings/tax')) active @endif fade in"
                                         id="tax">

                                        <h3 class="title-tap"> @lang('strings.update_tax_settings')</h3>

                                        <ul class="nav nav-tabs navinside">
                                            <li class="active"><a data-toggle="tab" href="#tax0">@lang('strings.add_tax')</a></li>
                                            <li><a data-toggle="tab" href="#tax1">@lang('strings.tax_lists') </a></li>
                                        </ul>

                                        <div class="tab-content tab-contentinside">
                                            @if(permissions('tax_add') == 1)
                                                <div id="tax0" class="tab-pane fade in active">
                                                    @include('alerts.index')
                                                    <form method="post" action="{{ url('admin/settings/tax')}}" id="taxs">

                                                        {{csrf_field()}}
                                                        <input name="id" type="hidden" value="" id="tax-id">
                                                        <div class="col-md-6 col-sm-6 col-xs-12 required form-group{{$errors->has('name') ? ' has-error' : ''}}">
                                                            <label>@lang('strings.Arabic_name')</label>
                                                            <input class="form-control" type="text" name="name"
                                                                   value="{{ old('name') }}"
                                                                   id="tax-name" required>
                                                            @if ($errors->has('name'))
                                                                <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                                    </span>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-6 col-sm-6 col-xs-12 required form-group{{$errors->has('name_en') ? ' has-error' : ''}}">
                                                            <label><strong>@lang('strings.English_name')</strong></label>
                                                            <input class="form-control" type="text" name="name_en"
                                                                   value="{{ old('name_en') }}"
                                                                   id="tax-name-en" required>
                                                            @if ($errors->has('name_en'))
                                                                <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                                                    </span>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-6 col-sm-6 col-xs-12 required form-group{{$errors->has('tax_type') ? ' has-error' : ''}}">
                                                            <label><strong>@lang('strings.Tax_type')</strong></label>
                                                            <select class="form-control js-select" name="tax_type" id="tax_type" required>
                                                                <option value="0">@lang('strings.Select_tax_type')</option>
                                                                <option {{ old('tax_type') == 1 ? 'selected' : '' }}  value="1">@lang('strings.Value')</option>
                                                                <option {{ old('tax_type') == 2 ? 'selected' : '' }} value="2">@lang('strings.Percentage')</option>
                                                            </select>
                                                            @if ($errors->has('tax_type'))
                                                                <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('tax_type') }}</strong>
                                                    </span>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-6 col-sm-6 col-xs-12 required form-group{{$errors->has('active') ? ' has-error' : ''}}">
                                                            <label class="control-label"
                                                                   for="active">@lang('strings.Status')</label>
                                                            <select class="form-control js-select" name="active" id="tax-active" required>
                                                                <option value="1">@lang('strings.Active')</option>
                                                                <option value="0">@lang('strings.Deactivate')</option>
                                                            </select>
                                                            @if ($errors->has('active'))
                                                                <span class="help-block">
                                                                <strong class="text-danger">{{ $errors->first('active') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>

                                                        <div class="percent required col-md-6 col-sm-6 col-xs-12 form-group"
                                                             @if($errors->has('percent')) @else style="display: none" @endif>
                                                            <label><strong>@lang('strings.Percentage')</strong></label>
                                                            <input class="form-control" type="number" name="percent" required
                                                                   value="{{ old('percent') }}" id="tax-percent" max="100"
                                                                   min="1">
                                                            @if ($errors->has('percent'))
                                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('percent') }}</strong>
                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="value col-md-6 required col-sm-6 col-xs-12 form-group"
                                                             @if($errors->has('value')) @else style="display: none" @endif>
                                                            <label><strong>@lang('strings.Tax_value')</strong></label>
                                                            <input class="form-control" type="number" name="value"
                                                                   value="{{ old('value') }}" id="tax-value" required>
                                                            @if ($errors->has('value'))
                                                                <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('value') }}</strong>
                                                    </span>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 col-xs-12  form-group{{$errors->has('description') ? ' has-error' : ''}}">
                                                            <label class="control-label full-width-label"
                                                                   for="description">@lang('strings.Description')</label>
                                                            <textarea name="description" class="form-control full-width-area" id="tax-description">
                                                            {{ old('description') }}
                                                        </textarea>
                                                            @if ($errors->has('description'))
                                                                <span class="help-block">
                                                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>

                                                        <button id="add-aa" type="submit" class="btn btn-primary btn-lg btn-save">
                                                            <i class="icon-check"></i>&nbsp;&nbsp;@lang('strings.save')
                                                        </button>
                                                        <button id="edit-aa" type="submit"
                                                                class="btn btn-primary btn-lg btn-save" style="display: none">
                                                            <i class="icon-check"></i>&nbsp;&nbsp;@lang('strings.edit')
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                            @if(permissions('tax_view') == 1)
                                                <div id="tax1" class="tab-pane fade">
                                                    <table id="xtreme-table" class="display table"
                                                           style="width: 100%; cellspacing: 0;">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>@lang('strings.Arabic_name')</th>
                                                            <th>@lang('strings.English_name')</th>

                                                            <th>@lang('strings.Percentage')</th>
                                                            <th>@lang('strings.Value')</th>
                                                            <th>@lang('strings.Status')</th>
                                                            <th>@lang('strings.Settings')</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($taxs as $value)
                                                            <tr>
                                                                <td>{{ $value->id }}</td>
                                                                <td>{{ $value->name }}</td>
                                                                <td>{{ $value->name_en }}</td>

                                                                <td>{{ $value->percent }} {{ $value->percent != null ? '%' : ''  }}</td>
                                                                <td>{{ $value->value }}</td>
                                                                <td>
                                                                    @if($value->active)
                                                                        <span class="label label-success"
                                                                              style="font-size:12px;">@lang('strings.Active')</span>
                                                                    @else
                                                                        <span class="label label-danger"
                                                                              style="font-size:12px;">@lang('strings.Deactivate')</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <a href="#" onclick="_edit({{ $value->id }})"
                                                                       class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                                       data-placement="bottom" title=""
                                                                       data-original-title="تعديل"><i class="fa fa-pencil"></i></a>
                                                                {{--<a class="btn btn-danger btn-xs" data-toggle="modal"--}}
                                                                {{--data-target="#{{ $value->id }}"><i class="fa fa-trash-o"></i></a>--}}
                                                                <!-- Package Delete Modal -->
                                                                    <div id="{{ $value->id }}" class="modal fade" role="dialog"
                                                                         data-keyboard="false" data-backdrop="static">
                                                                        <div class="modal-dialog">
                                                                            <!-- Modal content-->
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close"
                                                                                            data-dismiss="modal">&times;
                                                                                    </button>
                                                                                    <h4 class="modal-title">تاكيد الحذف</h4>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <p>{{ __('backend.delete_package_message') }}</p>
                                                                                </div>
                                                                                <form method="post"
                                                                                      action="{{ route('yearly_vacations.destroy', $value->id) }}">
                                                                                    <div class="modal-footer">
                                                                                        {{csrf_field()}}
                                                                                        {{ method_field('DELETE') }}
                                                                                        <button type="submit"
                                                                                                class="btn btn-danger">
                                                                                            حذف
                                                                                        </button>
                                                                                        <button type="button"
                                                                                                class="btn btn-primary"
                                                                                                data-dismiss="modal">الغاء
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                    {{ $taxs->links() }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if(permissions('banks_view') == 1)
                                    <div role="tabpanel"
                                         class="tab-pane @if(Request::is('admin/settings/banking')) active @endif fade in"
                                         id="banking">

                                        <h3 class="title-tap">@lang('strings.update_banks_settings')</h3>

                                        <ul class="nav nav-tabs navinside">
                                            <li><a data-toggle="tab" href="#banking0">@lang('strings.add_bank')</a></li>
                                            <li class="active"><a data-toggle="tab" href="#banking1">@lang('strings.banks_lists')</a></li>
                                        </ul>

                                        <div class="tab-content tab-contentinside">

                                            @if(permissions('banks_add') == 1)
                                                <div id="banking0" class="tab-pane fade">
                                                    @include('alerts.index')
                                                    <form method="post" action="{{ url('admin/settings/banking')}}"
                                                          enctype="multipart/form-data" id="banking">

                                                        {{csrf_field()}}
                                                        <input name="id" type="hidden" value="" id="bank-id">
                                                        <div class="col-md-6 required col-sm-6 col-xs-12 form-group{{$errors->has('b_name') ? ' has-error' : ''}}">
                                                            <label><strong>@lang('strings.Arabic_name')</strong></label>
                                                            <input class="form-control" type="text" name="b_name"
                                                                   value="{{ old('b_name') }}"
                                                                   id="bank-name">
                                                            @if ($errors->has('b_name'))
                                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('b_name') }}</strong>
                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-6 required col-sm-6 col-xs-12 form-group{{$errors->has('b_name_en') ? ' has-error' : ''}}">
                                                            <label><strong>@lang('strings.English_name')</strong></label>
                                                            <input class="form-control" type="text" name="b_name_en"
                                                                   value="{{ old('b_name_en') }}" id="bank-name_en">
                                                            @if ($errors->has('b_name_en'))
                                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('b_name_en') }}</strong>
                                                </span>
                                                            @endif
                                                        </div>


                                                        <div class="col-md-6 required col-sm-6 col-xs-12 form-group{{$errors->has('bank_type') ? ' has-error' : ''}}">
                                                            <label><strong>@lang('strings.Type')</strong></label>
                                                            <select class="form-control js-select" name="bank_type" id="bank_type">
                                                                <option value="1">@lang('strings.treasury')</option>
                                                                <option value="2">@lang('strings.Banks')</option>
                                                            </select>
                                                            @if ($errors->has('bank_type'))
                                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('bank_type') }}</strong>
                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                                            <label><strong>@lang('strings.Account_code')</strong></label>
                                                            <input class="form-control" type="text" name="code"
                                                                   value="{{ old('code') }}"
                                                                   id="bank-code" max="100" min="1">
                                                        </div>


                                                        <div class="account col-md-6 col-sm-6 col-xs-12 form-group"
                                                             style="display: none">
                                                            <label><strong>@lang('strings.Account_id')</strong></label>
                                                            <input class="form-control" type="text" name="account"
                                                                   value="{{ old('account') }}" id="bank-account">
                                                            @if ($errors->has('account'))
                                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('account') }}</strong>
                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-6 col-sm-6 col-xs-12 form-group{{$errors->has('active') ? ' has-error' : ''}}">
                                                            <label class="control-label"
                                                                   for="active">@lang('strings.Status')</label>
                                                            <select class="form-control js-select" name="active">
                                                                <option value="1">@lang('strings.Active')</option>
                                                                <option value="0">@lang('strings.Deactivate')</option>
                                                            </select>
                                                            @if ($errors->has('active'))
                                                                <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('active') }}</strong>
                                        </span>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group{{$errors->has('b_description') ? ' has-error' : ''}}">
                                                            <label class="control-label full-width-label"
                                                                   for="description">@lang('strings.Description')</label>
                                                            <textarea name="b_description" class="form-control full-width-area"
                                                                      id="bank-description">{{ old('b_description') }}</textarea>
                                                            @if ($errors->has('b_description'))
                                                                <span class="help-block">
                                            <strong class="text-danger">{{ $errors->first('b_description') }}</strong>
                                        </span>
                                                            @endif
                                                        </div>

                                                        <a href="#" id="bank-add"
                                                           onclick="document.forms['banking'].submit(); return false;"
                                                           class="btn btn-primary btn-lg btn-save">
                                                            <i class="icon-check"></i>&nbsp;&nbsp;@lang('strings.save')
                                                        </a>
                                                        <a href="#" id="bank-edit"
                                                           onclick="document.forms['banking'].submit(); return false;"
                                                           class="btn btn-primary btn-lg btn-save" style="display: none">
                                                            <i class="icon-check"></i>&nbsp;&nbsp;@lang('strings.edit') </a>
                                                    </form>
                                                </div>
                                            @endif

                                            @if(permissions('banks_view') == 1)
                                                <div id="banking1" class="tab-pane fade in active">
                                                    <table id="xtreme-table" class="display table"
                                                           style="width: 100%; cellspacing: 0;">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>@lang('strings.Arabic_name')</th>
                                                            <th>@lang('strings.English_name')</th>

                                                            <th>@lang('strings.Account_code')</th>
                                                            <th>@lang('strings.Account_id')</th>
                                                            <th>@lang('strings.Main')</th>
                                                            <th>@lang('strings.Status')</th>
                                                            <th>@lang('strings.Settings')</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($banks as $value)
                                                            <tr>
                                                                <td>{{ $value->id }}</td>
                                                                <td>{{ $value->name }}</td>
                                                                <td>{{ $value->name_en }}</td>
                                                                <td>{{ $value->code }}</td>
                                                                <td>{{ $value->account }}</td>
                                                                <td>
                                                                    @if($value->default == 1)
                                                                        <span class="label label-success"
                                                                              style="font-size:12px;">@lang('strings.Main')</span>
                                                                    @else
                                                                        <a href="{{ url('admin/settings/banking/default/'. $value->id. '/true') }}"
                                                                           class="label label-danger"
                                                                           style="font-size:12px;">@lang('strings.Normal')</a>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($value->active == 1)
                                                                        <span class="label label-success"
                                                                              style="font-size:12px;">@lang('strings.Active')</span>
                                                                    @else
                                                                        <span class="label label-danger"
                                                                              style="font-size:12px;">@lang('strings.Deactivate')</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($value->default != 1)
                                                                        <a href="#" onclick="bank_edit({{ $value->id }})"
                                                                           class="btn btn-primary btn-xs"><i
                                                                                    class="fa fa-pencil"></i></a>
                                                                    @endif
                                                                {{--<a class="btn btn-danger btn-xs" data-toggle="modal"--}}
                                                                {{--data-target="#bank-{{ $value->id }}"><i--}}
                                                                {{--class="fa fa-trash-o"></i></a>--}}
                                                                <!-- Package Delete Modal -->
                                                                    <div id="bank-{{ $value->id }}" class="modal fade"
                                                                         role="dialog"
                                                                         data-keyboard="false" data-backdrop="static">
                                                                        <div class="modal-dialog">
                                                                            <!-- Modal content-->
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close"
                                                                                            data-dismiss="modal">&times;
                                                                                    </button>
                                                                                    <h4 class="modal-title">تاكيد الحذف</h4>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <p>{{ __('backend.delete_package_message') }}</p>
                                                                                </div>
                                                                                <form method="post"
                                                                                      action="{{ url('admin/settings/banking/delete', $value->id) }}">
                                                                                    <div class="modal-footer">
                                                                                        {{csrf_field()}}
                                                                                        {{ method_field('DELETE') }}
                                                                                        <button type="submit"
                                                                                                class="btn btn-danger">
                                                                                            حذف
                                                                                        </button>
                                                                                        <button type="button"
                                                                                                class="btn btn-primary"
                                                                                                data-dismiss="modal">الغاء
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                    {{ $banks->links() }}
                                                </div>
                                            @endif
                                        </div>


                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            

            $("#session").on('change', function() {
                if ($(this).is(':checked')) {
                    $('.timeformat').show();
                }else {
                    $('.timeformat').hide();
                }
            });
            $("#bank_type").change(function () {
                if (this.value == 1) {
                    $('.account').hide();
                } else if (this.value == 2) {
                    $('.account').show();
                }
            });
            $('#invoice_setup_type').change(function () {
                if(this.value != ''){
                    if(this.value != 0){
                        $('.invoice_setup').show();
                    }else{
                        $('.invoice_setup').hide();
                    }

                    if(this.value == 4){
                        $('.invoice_setup_type_3').show();
                    }else{
                        $('.invoice_setup_type_3').hide();
                    }

                    $.get( "{{ url('admin/settings/invoice-setup-type-value') }}/" + this.value, function( data ) {
                        $('#type_value').val('');
                        $('#type_description').code('');
                        if(data != ''){
                            $('#type_value').val(data.value);
                            if(data.type == 4){
                                $('#type_value').prop("disabled", true);
                            }else{
                                $('#type_value').prop("disabled", false);
                            }
                            $("#type_description").code(data.description);
                        }else{
                            $('#type_value').val('');
                            $('#type_description').code('');

                            if(this.value == 4){
                                $('#type_value').prop("disabled", true);
                            }else{
                                $('#type_value').prop("disabled", false);
                            }
                        }
                    });
                }
            });
            
            var checkbox = document.querySelector('input[name=mode]');
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    trans()
                    document.documentElement.setAttribute('data-theme', 'dark')
                } else {
                    trans()
                    document.documentElement.setAttribute('data-theme', 'light')
                }
            })
            let trans = () => {
                document.documentElement.classList.add('transition');
                window.setTimeout(() => {
                    document.documentElement.classList.remove('transition');
                }, 1000)
            }
            
            $('#show_suggest').click(function() {
                $('#suggest_box').toggle('500');
                return false;
            });
            $('.gateway-row .ActiveButton').on('click', function(e) {
                accordion_switch = $(this).parents('.gateway-row').find('a.accordion-switch');
                accordion_switch.removeClass('Collapse');
                accordion_switch.addClass('Expand');
                accordion_switch.html('&#8211;');

                $(this).parents('.gateways-list').find('.DetailsBlock').show();
                e.stopPropagation();
            });
            $('.gateway-row .Default').on('click', function(e) {
                $(this).parents('.gateway-row').find('.ActiveButton').click();
                $(this).parents('.gateway-row').find('.ActiveButton input').prop('checked', true);

                e.stopPropagation();
            });
            $('.gateway-row .InActiveButton').on('click', function(e) {
                if ($(this).parents('.gateway-row').find('.Default input').is(":checked")) {
                    return false;
                }
                accordion_switch = $(this).parents('.gateway-row').find('a.accordion-switch');
                accordion_switch.removeClass('Expand');
                accordion_switch.addClass('Collapse');
                accordion_switch.html('+');

                $(this).parents('.gateways-list').find('.DetailsBlock').hide();
                e.stopPropagation();
            });
            $('.rounded-item').on('click', function() {
                $(this).find('a.accordion-switch').click();
            });
            $('.gateway-row a.accordion-switch').on('click', function() {
                if ($(this).hasClass('Expand')) {
                    $(this).removeClass('Expand');
                    $(this).addClass('Collapse');
                    $(this).html('+');
                    $(this).parents('.gateways-list').find('.DetailsBlock').hide();
                } else if ($(this).hasClass('Collapse')) {
                    $(this).removeClass('Collapse');
                    $(this).addClass('Expand');
                    $(this).html('&#8211;');
                    $(this).parents('.gateways-list').find('.DetailsBlock').show();
                }
                return false;
            });
            $('.is-default').change(function() {
                if (this.checked) {
                    var id = this.id;
                    $('.is-default:not(#' + id + ')').attr('checked', false);
                }
            });
            $('.pcheck').change(function() {
                if ($(this).prop('checked')) {
                    $('#instructions_'+$(this).attr('gateway')).hide();
                }else{
                    $('#instructions_'+$(this).attr('gateway')).show();
                }
            });
            $('input[type=text],textarea').bind('keypress keyup change', function() {
                var parent = $(this).parents('.gateways-list');
                parent.find('input[type=text],textarea').each(function() {
                    var val = $(this).val();
                    if (val) {
                        $('.inactive-button', parent).prop('checked', false);
                        $('.active-button', parent).prop('checked', true);
                    }
                });
            });
            $('.circle-nicelabel').nicelabel();
            $('.calculate_fees').change(function () {
                if (this.checked)
                    $(this).closest('.calculate_fees_parent').find('.calculate_fees_div').show();
                else
                    $(this).closest('.calculate_fees_parent').find('.calculate_fees_div').hide();
            }).change();
        </script>
@endsection

@section('scripts')

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
    function _edit(id, that) {
        $('#tax0').addClass('active in');
        $('#tax1').removeClass('active in');
        $.ajax({
            url: '{{ url('admin/settings/tax/') }}/' + id,
            success: function (response) {
                $('#edit-aa').show();
                $('#add-aa').hide();
                if (response.percent != null) {
                    $('.value').hide();
                    $('.percent').show();
                    $('#tax_type option[value=2]').attr('selected', 'selected');
                } else if (response.value != null) {
                    $('.value').show();
                    $('.percent').hide();
                    $('#tax_type option[value=1]').attr('selected', 'selected');
                }
                if (response.active == 1) {
                    $('#tax-active option[value=1]').attr('selected', 'selected');
                } else {
                    $('#tax-active option[value=0]').attr('selected', 'selected');
                }
                $('#tax-id').val(response.id);
                $('#tax-name').val(response.name);
                $('#tax-name-en').val(response.name_en);
                $('#tax-percent').val(response.percent);
                $('#tax-value').val(response.value);
                $('#tax-description').val(response.description);

            }
        });
    }
    
    function bank_edit(id, that) {
        $.ajax({
            url: '{{ url('admin/settings/banking/') }}/' + id,
            success: function (response) {
                $('#bank-edit').show();
                $('#bank-add').hide();
                if (response.type == 1) {
                    $('.account').hide();
                    $('#bank_type option[value=1]').attr('selected', 'selected');
                } else if (response.type == 2) {
                    $('.account').show();
                    $('#bank_type option[value=2]').attr('selected', 'selected');
                }
                $('#bank-id').val(response.id);
                $('#bank-name').val(response.name);
                $('#bank-name_en').val(response.name_en);
                $('#bank-code').val(response.code);
                $('#bank-account').val(response.account);
                $('#bank-description').val(response.description);
            }
        });
    }
</script>
@endsection

