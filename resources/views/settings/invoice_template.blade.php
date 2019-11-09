<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Customize template</title>
    <meta name="base_url" content="{{ URL::to('/') }}">
    <meta name="lang" content="{{ app()->getLocale() }}">

    <!-- CSS FILES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_invoice/vendor/bootstrap.datepicker/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_invoice/vendor/toastrjs/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_invoice/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_invoice/css/mainmenu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets_invoice/css/responsive.css') }}">
    @if(app()->getLocale() == 'ar')
        <link rel="stylesheet" type="text/css" href="{{ asset('assets_invoice/css/rtl.css') }}">
    @endif
    <!-- CSS FILES END -->
    <!-- JAVASCRIPT FILES -->
    <script type="text/javascript" src="{{ asset('assets_invoice/js/libs/jquery.min.js') }}"></script>
    
    <!-- JAVASCRIPT FILES END -->
    <style type="text/css">
    .input_color_in {
    font-size: 0;
    min-height: 32px;
}
        .cbalink {
            display: none;
        }

        body {
            padding-top: 0;
        }

        .main {
            padding-bottom: 0;
            transition-duration: 0.25s, 0.25s, 0.25s, 0.25s;
            transition-property: padding-left, padding-right, margin-left, margin-right;
        }
    </style>
</head>
<body @if(app()->getLocale() == 'ar') dir="rtl" @else dir="ltr" @endif>
<div style="clear:both;"></div>
<!-- Main content -->
<main class="main">
    <!-- CSS FILES -->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets_invoice/vendor/bootstrap.colorpickersliders/bootstrap.colorpickersliders.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets_invoice/vendor/fileuploader/jquery.fileuploader.css') }}">

    <!-- CSS FILES END -->
    @if(Request::is('admin/settings/customize_template/*'))
    <form action="{{ url('admin/settings/customize_update') }}" class="customize_template" style=" margin: 0;" method="post" accept-charset="utf-8" id="customize_template">
        @else
    <form action="{{ url('admin/settings/customize_template') }}" class="customize_template" style=" margin: 0;" method="post" accept-charset="utf-8" id="customize_template">
    @endif
        {{csrf_field()}}
        <input type="hidden" name="image_blob" value="" id="image_blob">
        <div class="invoice_config card m-a-0">
            <div class="card-toggled pull-left flip p-x-1 p-y-h" style="width: 360px; min-height: 600px;">

                @if(Request::is('admin/settings/customize_template/*'))

                    <!-- TITLE BAR -->
                    <div class="titlebar">
                        <div class="row">
                            <h4 class="title col-md-5">@lang('strings.customize_template')</h4>
                            <div class=" col-md-3 text-xs-right right-side">
                                <button onclick="document.forms['customize_template'].submit(); return false;" class="btn btn-secondary btn-submit"><i class="icon-check"></i> @lang('strings.update') </button>
                            </div>
                            <div class=" col-md-3 text-xs-right right-side">
                                <a href="{{ url('admin/settings/invoiceset') }}" class="btn btn-secondary btn-submit">@lang('strings.go_back') </a>
                            </div>
                            <div class="col-md-12">
                                <input name="template_id" type="hidden" value="{{ $template_id }}">
                                <input type="text" name="name" value="{{ $data->name }}" required class="form-control" id="name"/>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <!-- TITLE BAR END -->

                    <!-- CONFIGURATION -->
                    <div class="card card-default m-a-0">
                        <div class="card-header p-y-q small font-weight-bold">
                             @lang('strings.template_configuration')
                            <div class="pull-right flip"><i class="icon-arrow-down"></i></div>
                        </div>
                        <div class="card-block" style="display: none;">
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label required" for="invoice_default_layout">
                                    @lang('strings.default_layout')
                                </label>
                                <div class="col-md-8">
                                    <select name="template[invoice_default_layout]" class="form-control"
                                            id="invoice_default_layout">
                                        <option {{ $data->value['invoice_default_layout'] == 'portrait' ? 'selected' : '' }} value="portrait">@lang('strings.portrait')</option>
                                        <option {{ $data->value['invoice_default_layout'] == 'landscape' ? 'selected' : '' }} value="landscape">@lang('strings.landscape')</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-md-4 form-control-label required" for="invoice_default_size">
                                    @lang('strings.default_size')
                                </label>
                                <div class="col-md-8">
                                    <select name="template[invoice_default_size]" class="form-control"
                                            id="invoice_default_size">

                                        <option {{ $data->value['invoice_default_size'] == 'A4' ? 'selected' : '' }}  value="A4" >A4 [210mm × 297mm]</option>
                                        <option {{ $data->value['invoice_default_size'] == 'A5' ? 'selected' : '' }}  value="A5">A5 [148mm × 210mm]</option>
                                        <option {{ $data->value['invoice_default_size'] == 'Letter' ? 'selected' : '' }}  value="Letter">US Letter [216mm × 279mm]</option>
                                        <option {{ $data->value['invoice_default_size'] == 'Legal' ? 'selected' : '' }}  value="Legal">US Legal [216mm × 356mm]</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- CONFIGURATION END -->

                    <!-- STYLE -->
                    <div class="card card-default m-a-0" style="margin-top: -2px !important;">
                        <div class="card-header p-y-q small font-weight-bold">
                             @lang('strings.template_style')
                            <div class="pull-right flip"><i class="icon-arrow-down"></i></div>
                        </div>
                        <div class="card-block" style="display: none;">
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label" for="invoice_font">@lang('strings.font')</label>
                                <div class="col-md-8">
                                    <select name="template[invoice_font]" id="invoice_font" class="form-control">
                                        <optgroup label="Serif Fonts">
                                            <option {{ $data->value['invoice_font'] == 'Georgia, serif' ? 'selected' : '' }} value="Georgia, serif">Georgia, serif</option>
                                            <option {{ $data->value['invoice_font'] == 'Georgia, serif' ? 'selected' : '' }} value="&#039;Palatino Linotype&#039;, &#039;Book Antiqua&#039;, Palatino, serif">
                                                'Palatino Linotype', 'Book Antiqua', Palatino, serif
                                            </option>
                                            <option {{ $data->value['invoice_font'] == '&#039;Times New Roman&#039;, Times, serif' ? 'selected' : '' }} value="&#039;Times New Roman&#039;, Times, serif">'Times New Roman',
                                                Times, serif
                                            </option>
                                        </optgroup>
                                        <optgroup label="Sans-Serif Fonts">
                                            <option {{ $data->value['invoice_font'] == 'Arial, Helvetica, sans-serif' ? 'selected' : '' }} value="Arial, Helvetica, sans-serif">Arial,
                                                Helvetica, sans-serif
                                            </option>
                                            <option {{ $data->value['invoice_font'] == '&#039;Arial Black&#039;, Gadget, sans-serif' ? 'selected' : '' }} value="&#039;Arial Black&#039;, Gadget, sans-serif">'Arial Black',
                                                Gadget, sans-serif
                                            </option>
                                            <option {{ $data->value['invoice_font'] == '&#039;Comic Sans MS&#039;, cursive, sans-serif' ? 'selected' : '' }} value="&#039;Comic Sans MS&#039;, cursive, sans-serif">'Comic Sans MS',
                                                cursive, sans-serif
                                            </option>
                                            <option {{ $data->value['invoice_font'] == 'Impact, Charcoal, sans-serif' ? 'selected' : '' }} value="Impact, Charcoal, sans-serif">Impact, Charcoal, sans-serif
                                            </option>
                                            <option {{ $data->value['invoice_font'] == '&#039;Lucida Sans Unicode&#039;, &#039;Lucida Grande&#039;, sans-serif' ? 'selected' : '' }} value="&#039;Lucida Sans Unicode&#039;, &#039;Lucida Grande&#039;, sans-serif">
                                                'Lucida Sans Unicode', 'Lucida Grande', sans-serif
                                            </option>
                                            <option {{ $data->value['invoice_font'] == 'Tahoma, Geneva, sans-serif' ? 'selected' : '' }} value="Tahoma, Geneva, sans-serif">Tahoma, Geneva, sans-serif</option>
                                            <option {{ $data->value['invoice_font'] == '&#039;Trebuchet MS&#039;, Helvetica, sans-serif' ? 'selected' : '' }} value="&#039;Trebuchet MS&#039;, Helvetica, sans-serif">'Trebuchet MS',
                                                Helvetica, sans-serif
                                            </option>
                                            <option {{ $data->value['invoice_font'] == 'Verdana, Geneva, sans-serif' ? 'selected' : '' }} value="Verdana, Geneva, sans-serif">Verdana, Geneva, sans-serif</option>
                                            <option {{ $data->value['invoice_font'] == '&#039;Telex&#039;, sans-serif' ? 'selected' : '' }} value="&#039;Telex&#039;, sans-serif">'Telex', sans-serif</option>
                                        </optgroup>
                                        <optgroup label="Monospace Fonts">
                                            <option {{ $data->value['invoice_font'] == '&#039;Courier New&#039;, Courier, monospace' ? 'selected' : '' }} value="&#039;Courier New&#039;, Courier, monospace">'Courier New',
                                                Courier, monospace
                                            </option>
                                            <option {{ $data->value['invoice_font'] == '&#039;Lucida Console&#039;, Monaco, monospace' ? 'selected' : '' }} value="&#039;Lucida Console&#039;, Monaco, monospace">'Lucida Console',
                                                Monaco, monospace
                                            </option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label" for="font_size">@lang('strings.font_size')</label>
                                <div class="col-md-8">
                                    <select name="template[font_size]" id="font_size" class="form-control">
                                        <option {{ $data->value['font_size'] == '08px' ? 'selected' : '' }} value="08px">08 px</option>
                                        <option {{ $data->value['font_size'] == '09px' ? 'selected' : '' }} value="09px">09 px</option>
                                        <option {{ $data->value['font_size'] == '10px' ? 'selected' : '' }} value="10px">10 px</option>
                                        <option {{ $data->value['font_size'] == '11px' ? 'selected' : '' }} value="11px">11 px</option>
                                        <option {{ $data->value['font_size'] == '12px' ? 'selected' : '' }} value="12px">12 px</option>
                                        <option {{ $data->value['font_size'] == '14px' ? 'selected' : '' }} value="14px">14 px</option>
                                        <option {{ $data->value['font_size'] == '16px' ? 'selected' : '' }} value="16px">16 px</option>
                                        <option {{ $data->value['font_size'] == '18px' ? 'selected' : '' }} value="18px">18 px</option>
                                        <option {{ $data->value['font_size'] == '24px' ? 'selected' : '' }} value="24px">24 px</option>
                                        <option {{ $data->value['font_size'] == '36px' ? 'selected' : '' }} value="36px">36 px</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label" for="margin">@lang('strings.margin')</label>
                                <div class="col-md-8">
                                    <div class="row">
                                        <input type="hidden" name="template[margin]" value="{{ $data->value['margin'] }}"
                                               id="margin">
                                        @php
                                            $split = explode('cm', $data->value['margin']);
                                        @endphp


                                        <div class="col-md-6 col-md-offset-3">
                                            <input type="number" value="{{ $split[0] }}" id="marginTop" class="form-control" step="0.1"
                                                   min="0" max="5">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" value="{{ $split[1] }}" id="marginLeft" class="form-control" step="0.1"
                                                   min="0" max="5">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" value="{{ $split[2] }}" id="marginRight" class="form-control"
                                                   step="0.1" min="0" max="5">
                                        </div>
                                        <div class="col-md-6 col-md-offset-3">
                                            <input type="number" value="{{ $split[3] }}" id="marginBottom" class="form-control"
                                                   step="0.1" min="0" max="5">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-md-4 form-control-label" for="text_color">@lang('strings.text_color')</label>
                                <div class="col-md-8">
                                    <input type="text" name="template[text_color]" value="{{ $data->value['text_color'] }}"
                                           class="color form-control input_color_in" autocomplete="off" title="Select color"
                                           id="text_color"/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label" for="primary_color">@lang('strings.primary_color')</label>
                                <div class="col-md-8">
                                    <input type="text" name="template[primary_color]" value="{{ $data->value['primary_color'] }}"
                                           class="color form-control input_color_in" autocomplete="off" title="Select color"
                                           id="primary_color"/>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- STYLE END -->

                    <!-- TABLES -->
                    <div class="card card-default m-a-0" style="margin-top: -2px !important;">
                        <div class="card-header p-y-q small font-weight-bold">
                             @lang('strings.tables')
                            <div class="pull-right flip"><i class="icon-arrow-down"></i></div>
                        </div>
                        <div class="card-block" style="display: none;">
                            <div class="row form-group" style="margin-bottom: 10px;">
                                <div class="col-md-8 col-md-offset-4">
                                    <label for="table_border_check" style="line-height:30px;">
                                        <input type="checkbox" {{ $data->value['table_border'] == 1 ? 'checked' : '' }} id="table_border_check">@lang('strings.bordered')  <input
                                                type="hidden" name="template[table_border]" value="1" id="table_border">
                                    </label>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <label for="table_strip_check" style="line-height:30px;">
                                        <input type="checkbox" {{ $data->value['table_strip'] == 1 ? 'checked' : '' }} id="table_strip_check"> @lang('strings.striped') <input
                                                type="hidden" name="template[table_strip]" value="1" id="table_strip">
                                    </label>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label" for="table_line_th_height">@lang('strings.heading_height')</label>
                                <div class="col-md-8">
                                    <input type="number" name="template[table_line_th_height]" value="{{ $data->value['table_line_th_height'] }}"
                                           id="table_line_th_height" class="form-control" step="1" min="0" max="65">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label" for="table_line_td_height">@lang('strings.rows_height')</label>
                                <div class="col-md-8">
                                    <input type="number" name="template[table_line_td_height]" value="{{ $data->value['table_line_td_height'] }}"
                                           id="table_line_td_height" class="form-control" step="1" min="0" max="65">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label" for="table_line_th_bg">@lang('strings.heading_background')</label>
                                <div class="col-md-8">
                                    <input type="text" name="template[table_line_th_bg]" value="{{ $data->value['table_line_th_bg'] }}"
                                           class="color form-control" autocomplete="off" title="Select color"
                                           id="table_line_th_bg"/>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label" for="table_line_th_color"> @lang('strings.heading_text')
                                    </label>
                                <div class="col-md-8">
                                    <input type="text" name="template[table_line_th_color]" value="{{ $data->value['table_line_th_color'] }}" class="color form-control input_color_in " autocomplete="off" title="Select color" id="table_line_th_color"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- TABLES END -->

                    <!-- LOGO -->
                    <div class="card card-default m-a-0" style="margin-top: -2px !important;">
                        <div class="card-header p-y-q small font-weight-bold">
                            @lang('strings.logo')
                            <div class="pull-right flip"><i class="icon-arrow-down"></i></div>
                        </div>
                        <div class="card-block" style="display: none;">
                            <h4>@lang('strings.logo')</h4>
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label" for="logo_size">@lang('strings.size')</label>
                                <div class="col-md-8">
                                    <select name="template[logo_size]" id="logo_size" class="form-control">
                                        <option {{ $data->value['logo_size'] == '30%' ? 'selected' : '' }} value="30%">30 %</option>
                                        <option {{ $data->value['logo_size'] == '40%' ? 'selected' : '' }} value="40%">40 %</option>
                                        <option {{ $data->value['logo_size'] == '50%' ? 'selected' : '' }} value="50%">50 %</option>
                                        <option {{ $data->value['logo_size'] == '60%' ? 'selected' : '' }} value="60%">60 %</option>
                                        <option {{ $data->value['logo_size'] == '70%' ? 'selected' : '' }} value="70%">70 %</option>
                                        <option {{ $data->value['logo_size'] == '80%' ? 'selected' : '' }} value="80%">80 %</option>
                                        <option {{ $data->value['logo_size'] == '90%' ? 'selected' : '' }} value="90%">90 %</option>
                                        <option {{ $data->value['logo_size'] == '100%' ? 'selected' : '' }} selected="selected">100 %</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group" style="margin-bottom: 10px;">
                                <div class="col-md-8 col-md-offset-4">
                                    <label for="logo_monocolor_check" style="line-height:30px;">
                                        <input type="checkbox" {{ $data->value['logo_monocolor'] == 1 ? 'checked' : '' }} id="logo_monocolor_check"> @lang('strings.mono-color')  <input type="hidden"
                                                                                                                                  name="template[logo_monocolor]"
                                                                                                                                  value="{{ $data->value['logo_monocolor'] }}"
                                                                                                                                  id="logo_monocolor">
                                    </label>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <label for="logo_greyscale_check" style="line-height:30px;">
                                        <input type="checkbox" {{ $data->value['logo_greyscale'] == 1 ? 'checked' : '' }}  id="logo_greyscale_check"> @lang('strings.grayscale') <input type="hidden"
                                                                                                                                 name="template[logo_greyscale]"
                                                                                                                                 value="{{ $data->value['logo_greyscale'] }}"
                                                                                                                                 id="logo_greyscale">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- LOGO END -->

                    <!-- BACKGROUND -->
                    <div class="card card-default m-a-0" style="margin-top: -2px !important;">
                        <div class="card-header p-y-q small font-weight-bold">
                            @lang('strings.background')
                            <div class="pull-right flip"><i class="icon-arrow-down"></i></div>
                        </div>
                        <div class="card-block" style="display: none;">
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label" for="background_color">@lang('strings.color')</label>
                                <div class="col-md-8">
                                    <input type="text" name="template[background_color]" value="{{ $data->value['background_color'] }}"
                                           class="color form-control" :"form-control hover_tip" autocomplete="off"
                                    title="Select color" id="background_color" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- BACKGROUND END -->

                    <!-- HEADER -->
                    <div class="card card-default m-a-0" style="margin-top: -2px !important;">
                        <div class="card-header p-y-q small font-weight-bold">
                            @lang('strings.header')
                            <div class="pull-right flip"><i class="icon-arrow-down"></i></div>
                        </div>
                        <div class="card-block" style="display: none;">
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label"></label>
                                <div class="col-md-8">
                                    <label for="show_header_check" style="line-height:30px;">
                                        <input type="checkbox" {{ $data->value['show_header'] == 1  ? 'checked' : ''}} id="show_header_check"> @lang('strings.show_hide') <input
                                                type="hidden" name="template[show_header]" value="{{ $data->value['show_header'] }}"
                                                id="show_header_hidden">
                                    </label>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label">@lang('strings.background_color')</label>
                                <div class="col-md-8">
                                    <input type="text" name="template[header_bg_color]" value="{{ $data->value['header_bg_color'] }}"
                                           class="color form-control col-md-10" :"form-control col-md-4 hover_tip"
                                    title="Header background color" autocomplete="off" id="header_bg_color" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label">@lang('strings.text_color')</label>
                                <div class="col-md-8">
                                    <input type="text" name="template[header_txt_color]" value="{{ $data->value['header_txt_color'] }}"
                                           class="color form-control col-md-10" :"form-control col-md-4 hover_tip"
                                    title="Header text color" autocomplete="off" id="header_txt_color" />
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- HEADER END -->

                    <!-- FOOTER -->
                    <div class="card card-default m-a-0" style="margin-top: -2px !important;">
                        <div class="card-header p-y-q small font-weight-bold">
                            @lang('strings.footer')
                            <div class="pull-right flip"><i class="icon-arrow-down"></i></div>
                        </div>
                        <div class="card-block" style="display: none;">
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label required" for="show_footer_check"></label>
                                <div class="col-md-8">
                                    <label for="show_footer_check" style="line-height:30px;">
                                        <input type="checkbox" {{ $data->value['show_footer'] == 1  ? 'checked' : ''}} id="show_footer_check"> @lang('strings.show_hide') <input
                                                type="hidden" name="template[show_footer]" value="{{ $data->value['show_footer'] }}" id="show_footer">
                                    </label>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label required" for="footer_bg_color">@lang('strings.background_color')
                                    </label>
                                <div class="col-md-8">
                                    <input type="text" name="template[footer_bg_color]" value="{{ $data->value['footer_bg_color'] }}"
                                           class="color form-control col-md-10" :"form-control col-md-4 hover_tip"
                                    title="Footer background color" autocomplete="off" id="footer_bg_color" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label required" for="footer_txt_color"> @lang('strings.color_text')</label>
                                <div class="col-md-8">
                                    <input type="text" name="template[footer_txt_color]" value="{{ $data->value['footer_txt_color'] }}"
                                           class="color form-control col-md-10" :"form-control col-md-4 hover_tip"
                                    title="Footer text color" autocomplete="off" id="footer_txt_color" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label" for="editor_footer_text">@lang('strings.footer_text')</label>
                                <div class="col-md-12">
                                    <textarea name="template[footer_text]" id="editor_footer_text">{{ $data->value['footer_text'] }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FOOTER END -->

                    <!-- SIGNATURE -->
                    <div class="card card-default m-a-0" style="margin-top: -2px !important;">
                        <div class="card-header p-y-q small font-weight-bold">
                             @lang('strings.signature')
                            <div class="pull-right flip"><i class="icon-arrow-down"></i></div>
                        </div>
                        <div class="card-block" style="display: none;">
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label required" for="show_signature_check"></label>
                                <div class="col-md-8">
                                    <label for="show_signature_check" style="line-height:30px;">
                                        <input type="checkbox" {{ $data->value['show_signature'] == 1  ? 'checked' : ''}} id="show_signature_check"> @lang('strings.show_hide')
                                        <input type="hidden" name="template[show_signature]" value="1" id="show_signature">
                                    </label>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-md-4 form-control-label required" for="signature_txt">@lang('strings.signature_text')</label>
                                <div class="col-md-8">
                                    <input type="text" name="template[signature_txt]" value="{{ $data->value['signature_txt'] }}"
                                           class="form-control col-md-10" :"form-control col-md-4 hover_tip"
                                    title="Signature text" autocomplete="off" id="signature_txt" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- SIGNATURE END -->
                @else
                <!-- TITLE BAR -->
                <div class="titlebar">
                    <div class="row">
                        <h4 class="title col-md-5">@lang('strings.customize_template')</h4>
                        <div class=" col-md-3 text-xs-right right-side">
                            <button onclick="document.forms['customize_template'].submit(); return false;" class="btn btn-secondary btn-submit"><i class="icon-check"></i> @lang('strings.update') </button>
                        </div>
                        <div class=" col-md-3 text-xs-right right-side">
                            <a href="javascript:history.go(-1)" class="btn btn-secondary btn-submit">@lang('strings.go_back') </a>
                        </div>
                        <div class="col-md-12">
                            <input type="text" name="name" value="" required class="form-control" id="name"/>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <!-- TITLE BAR END -->

                <!-- CONFIGURATION -->
                <div class="card card-default m-a-0">
                    <div class="card-header p-y-q small font-weight-bold">
                        @lang('strings.template_configuration')
                        <div class="pull-right flip"><i class="icon-arrow-down"></i></div>
                    </div>
                    <div class="card-block" style="display: none;">
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label required" for="invoice_default_layout">@lang('strings.default_layout')
                                </label>
                            <div class="col-md-8">
                                <select name="template[invoice_default_layout]" class="form-control"
                                        id="invoice_default_layout">
                                    <option value="portrait" selected="selected">@lang('strings.portrait')</option>
                                    <option value="landscape">@lang('strings.landscape')</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label required" for="invoice_default_size">@lang('strings.default_size')
                                </label>
                            <div class="col-md-8">
                                <select name="template[invoice_default_size]" class="form-control"
                                        id="invoice_default_size">
                                    <option value="A4" selected="selected">A4 [210mm × 297mm]</option>
                                    <option value="A5">A5 [148mm × 210mm]</option>
                                    <option value="Letter">US Letter [216mm × 279mm]</option>
                                    <option value="Legal">US Legal [216mm × 356mm]</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- CONFIGURATION END -->

                <!-- STYLE -->
                <div class="card card-default m-a-0" style="margin-top: -2px !important;">
                    <div class="card-header p-y-q small font-weight-bold">
                        @lang('strings.template_style')
                        <div class="pull-right flip"><i class="icon-arrow-down"></i></div>
                    </div>
                    <div class="card-block" style="display: none;">
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label" for="invoice_font">@lang('strings.font')</label>
                            <div class="col-md-8">
                                <select name="template[invoice_font]" id="invoice_font" class="form-control">
                                    <optgroup label="Serif Fonts">
                                        <option value="Georgia, serif">Georgia, serif</option>
                                        <option value="&#039;Palatino Linotype&#039;, &#039;Book Antiqua&#039;, Palatino, serif">
                                            'Palatino Linotype', 'Book Antiqua', Palatino, serif
                                        </option>
                                        <option value="&#039;Times New Roman&#039;, Times, serif">'Times New Roman',
                                            Times, serif
                                        </option>
                                    </optgroup>
                                    <optgroup label="Sans-Serif Fonts">
                                        <option value="Arial, Helvetica, sans-serif" selected="selected">Arial,
                                            Helvetica, sans-serif
                                        </option>
                                        <option value="&#039;Arial Black&#039;, Gadget, sans-serif">'Arial Black',
                                            Gadget, sans-serif
                                        </option>
                                        <option value="&#039;Comic Sans MS&#039;, cursive, sans-serif">'Comic Sans MS',
                                            cursive, sans-serif
                                        </option>
                                        <option value="Impact, Charcoal, sans-serif">Impact, Charcoal, sans-serif
                                        </option>
                                        <option value="&#039;Lucida Sans Unicode&#039;, &#039;Lucida Grande&#039;, sans-serif">
                                            'Lucida Sans Unicode', 'Lucida Grande', sans-serif
                                        </option>
                                        <option value="Tahoma, Geneva, sans-serif">Tahoma, Geneva, sans-serif</option>
                                        <option value="&#039;Trebuchet MS&#039;, Helvetica, sans-serif">'Trebuchet MS',
                                            Helvetica, sans-serif
                                        </option>
                                        <option value="Verdana, Geneva, sans-serif">Verdana, Geneva, sans-serif</option>
                                        <option value="&#039;Telex&#039;, sans-serif">'Telex', sans-serif</option>
                                    </optgroup>
                                    <optgroup label="Monospace Fonts">
                                        <option value="&#039;Courier New&#039;, Courier, monospace">'Courier New',
                                            Courier, monospace
                                        </option>
                                        <option value="&#039;Lucida Console&#039;, Monaco, monospace">'Lucida Console',
                                            Monaco, monospace
                                        </option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label" for="font_size">@lang('strings.font_size')</label>
                            <div class="col-md-8">
                                <select name="template[font_size]" id="font_size" class="form-control">
                                    <option value="08px">08 px</option>
                                    <option value="09px">09 px</option>
                                    <option value="10px">10 px</option>
                                    <option value="11px">11 px</option>
                                    <option value="12px" selected="selected">12 px</option>
                                    <option value="14px">14 px</option>
                                    <option value="16px">16 px</option>
                                    <option value="18px">18 px</option>
                                    <option value="24px">24 px</option>
                                    <option value="36px">36 px</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label" for="margin">@lang('strings.margin')</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <input type="hidden" name="template[margin]" value="0.5cm 0.5cm 0.5cm 0.5cm"
                                           id="margin">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="number" value="0.5" id="marginTop" class="form-control" step="0.1"
                                               min="0" max="5">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" value="0.5" id="marginLeft" class="form-control" step="0.1"
                                               min="0" max="5">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" value="0.5" id="marginRight" class="form-control"
                                               step="0.1" min="0" max="5">
                                    </div>
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="number" value="0.5" id="marginBottom" class="form-control"
                                               step="0.1" min="0" max="5">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <label class="col-md-4 form-control-label" for="text_color">@lang('strings.text_color')</label>
                            <div class="col-md-8">
                                <input type="text" name="template[text_color]" value="#2e2e2e"
                                       class="color form-control input_color_in" autocomplete="off" title="Select color"
                                       id="text_color"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label" for="primary_color">@lang('strings.primary_color')</label>
                            <div class="col-md-8">
                                <input type="text" name="template[primary_color]" value="#009be1"
                                       class="color form-control input_color_in" autocomplete="off" title="Select color"
                                       id="primary_color"/>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- STYLE END -->

                <!-- TABLES -->
                <div class="card card-default m-a-0" style="margin-top: -2px !important;">
                    <div class="card-header p-y-q small font-weight-bold">
                        @lang('strings.tables')
                        <div class="pull-right flip"><i class="icon-arrow-down"></i></div>
                    </div>
                    <div class="card-block" style="display: none;">
                        <div class="row form-group" style="margin-bottom: 10px;">
                            <div class="col-md-8 col-md-offset-4">
                                <label for="table_border_check" style="line-height:30px;">
                                    <input type="checkbox" checked="checked" id="table_border_check"> @lang('strings.border') <input
                                            type="hidden" name="template[table_border]" value="1" id="table_border">
                                </label>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <label for="table_strip_check" style="line-height:30px;">
                                    <input type="checkbox" checked="checked" id="table_strip_check"> @lang('strings.strip') <input
                                            type="hidden" name="template[table_strip]" value="1" id="table_strip">
                                </label>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label" for="table_line_th_height">@lang('strings.heading_height')</label>
                            <div class="col-md-8">
                                <input type="number" name="template[table_line_th_height]" value="24"
                                       id="table_line_th_height" class="form-control" step="1" min="0" max="65">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label" for="table_line_td_height">@lang('strings.rows_height')</label>
                            <div class="col-md-8">
                                <input type="number" name="template[table_line_td_height]" value="23"
                                       id="table_line_td_height" class="form-control" step="1" min="0" max="65">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label" for="table_line_th_bg">@lang('strings.heading_background')</label>
                            <div class="col-md-8">
                                <input type="text" name="template[table_line_th_bg]" value="#009be1"
                                       class="color form-control input_color_in  " autocomplete="off" title="Select color"
                                       id="table_line_th_bg"/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label" for="table_line_th_color"> @lang('strings.heading_text')
                                </label>
                            <div class="col-md-8">
                                <input type="text" name="template[table_line_th_color]" value="#ffffff"
                                       class="color form-control input_color_in " autocomplete="off" title="Select color"
                                       id="table_line_th_color"/>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- TABLES END -->

                <!-- LOGO -->
                <div class="card card-default m-a-0" style="margin-top: -2px !important;">
                    <div class="card-header p-y-q small font-weight-bold">
                        @lang('strings.logo')
                        <div class="pull-right flip"><i class="icon-arrow-down"></i></div>
                    </div>
                    <div class="card-block" style="display: none;">
                        <h4>@lang('strings.logo')</h4>
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label" for="logo_size">@lang('strings.size')</label>
                            <div class="col-md-8">
                                <select name="template[logo_size]" id="logo_size" class="form-control">
                                    <option value="30%">30 %</option>
                                    <option value="40%">40 %</option>
                                    <option value="50%">50 %</option>
                                    <option value="60%">60 %</option>
                                    <option value="70%">70 %</option>
                                    <option value="80%">80 %</option>
                                    <option value="90%">90 %</option>
                                    <option value="100%" selected="selected">100 %</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group" style="margin-bottom: 10px;">
                            <div class="col-md-8 col-md-offset-4">
                                <label for="logo_monocolor_check" style="line-height:30px;">
                                    <input type="checkbox" id="logo_monocolor_check"> @lang('strings.mono-color') <input type="hidden"
                                                                                                        name="template[logo_monocolor]"
                                                                                                        value="0"
                                                                                                        id="logo_monocolor">
                                </label>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <label for="logo_greyscale_check" style="line-height:30px;">
                                    <input type="checkbox" id="logo_greyscale_check"> @lang('strings.grayscale') <input type="hidden"
                                                                                                       name="template[logo_greyscale]"
                                                                                                       value="0"
                                                                                                       id="logo_greyscale">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- LOGO END -->

                <!-- BACKGROUND -->
                <div class="card card-default m-a-0" style="margin-top: -2px !important;">
                    <div class="card-header p-y-q small font-weight-bold">
                        @lang('strings.background')
                        <div class="pull-right flip"><i class="icon-arrow-down"></i></div>
                    </div>
                    <div class="card-block" style="display: none;">
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label" for="background_color">@lang('strings.color')</label>
                            <div class="col-md-8">
                                <input type="text" name="template[background_color]" value="#ffffff"
                                       class="color form-control" :"form-control hover_tip" autocomplete="off"
                                title="Select color" id="background_color" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- BACKGROUND END -->

                <!-- HEADER -->
                <div class="card card-default m-a-0" style="margin-top: -2px !important;">
                    <div class="card-header p-y-q small font-weight-bold">
                         @lang('strings.header')
                        <div class="pull-right flip"><i class="icon-arrow-down"></i></div>
                    </div>
                    <div class="card-block" style="display: none;">
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label"></label>
                            <div class="col-md-8">
                                <label for="show_header_check" style="line-height:30px;">
                                    <input type="checkbox" checked="checked" id="show_header_check"> @lang('strings.show_hide') <input
                                            type="hidden" name="template[show_header]" value="1"
                                            id="show_header_hidden">
                                </label>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label">@lang('strings.background_color')</label>
                            <div class="col-md-8">
                                <input type="text" name="template[header_bg_color]" value="#ffffff"
                                       class="color form-control col-md-10" :"form-control col-md-4 hover_tip"
                                title="Header background color" autocomplete="off" id="header_bg_color" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label">@lang('strings.text_color')</label>
                            <div class="col-md-8">
                                <input type="text" name="template[header_txt_color]" value="#000000"
                                       class="color form-control col-md-10" :"form-control col-md-4 hover_tip"
                                title="Header text color" autocomplete="off" id="header_txt_color" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- HEADER END -->

                <!-- FOOTER -->
                    <div class="card card-default m-a-0" @if(App\org::where(['id' => Auth::user()->org_id])->value('plan_id') !== 1) style="style="display: none"" @else style="margin-top: -2px !important;" @endif >                    <div class="card-header p-y-q small font-weight-bold">
                        @lang('strings.footer')
                        <div class="pull-right flip"><i class="icon-arrow-down"></i></div>
                    </div>
                    <div class="card-block" style="display: none;">
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label required" for="show_footer_check"></label>
                            <div class="col-md-8">
                                <label for="show_footer_check" style="line-height:30px;">
                                    <input type="checkbox" checked="checked" id="show_footer_check"> @lang('strings.show_hide') <input
                                            type="hidden" name="template[show_footer]" value="1" id="show_footer">
                                </label>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label required" for="footer_bg_color">@lang('strings.background_color')</label>
                            <div class="col-md-8">
                                <input type="text" name="template[footer_bg_color]" value="#ffffff"
                                       class="color form-control col-md-10" :"form-control col-md-4 hover_tip"
                                title="Footer background color" autocomplete="off" id="footer_bg_color" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label required" for="footer_txt_color">@lang('strings.text_color')</label>
                            <div class="col-md-8">
                                <input type="text" name="template[footer_txt_color]" value="#2e2e2e"
                                       class="color form-control col-md-10" :"form-control col-md-4 hover_tip"
                                title="Footer text color" autocomplete="off" id="footer_txt_color" />
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label" for="editor_footer_text"> @lang('strings.footer_text')</label>
                            <div class="col-md-12">
                                <textarea name="template[footer_text]" id="editor_footer_text">Filerole &copy; 2019</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FOOTER END -->
                <!-- SIGNATURE -->
                <div class="card card-default m-a-0" style="margin-top: -2px !important;">
                    <div class="card-header p-y-q small font-weight-bold">
                         @lang('strings.signature')
                        <div class="pull-right flip"><i class="icon-arrow-down"></i></div>
                    </div>
                    <div class="card-block" style="display: none;">
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label required" for="show_signature_check"></label>
                            <div class="col-md-8">
                                <label for="show_signature_check" style="line-height:30px;">
                                    <input type="checkbox" checked="checked" id="show_signature_check"> @lang('strings.show_hide')
                                    <input type="hidden" name="template[show_signature]" value="1" id="show_signature">
                                </label>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-4 form-control-label required" for="signature_txt">@lang('strings.signature_text')</label>
                            <div class="col-md-8">
                                <input type="text" name="template[signature_txt]" value="signature &amp; stamp"
                                       class="form-control col-md-10" :"form-control col-md-4 hover_tip"
                                title="Signature text" autocomplete="off" id="signature_txt" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- SIGNATURE END -->
                @endif
            </div>
            <div class="well m-a-0 pull-left flip p-a-0">
                <div class="preview">

                    <div class="zoom">
                        <input type="text" id="zoom" value="">
                    </div>
                    <div class="invoice_preview">
                        <div id="css_script">
                            <style type="text/css" id="pageInit">@page {
                                    size: 21cm 29.7cm
                                }</style>
                            <link href="{{ url('assets_invoice/css/print.css') }}" rel="stylesheet">
                            <style type="text/css">
                                #wrap_invoice.page {
                                    font-family: Arial, Helvetica, sans-serif;
                                    background-color: #ffffff;
                                    padding: 0.5cm 0.5cm 0.5cm 0.5cm;
                                    z-index: 1;
                                }

                                #wrap_invoice h3 {
                                    color: #009be1;
                                }

                                #wrap_invoice h4 {
                                    color: #009be1;
                                }

                                .invoice_header .invoice-logo img {
                                    height: 100% !important;
                                    width: auto !important;
                                    max-width: 100%;
                                }

                                #wrap_invoice,
                                #wrap_invoice p,
                                #wrap_invoice .text-color,
                                #wrap_invoice .inv.col b,
                                #wrap_invoice .table_invoice {
                                    font-size: 12px;
                                    color: #2e2e2e;
                                }

                                #wrap_invoice .table_invoice thead th {
                                    background: #009be1;
                                    color: #ffffff;
                                    line-height: 24px;
                                    height: 24px;
                                }

                                #wrap_invoice .table_invoice td {
                                    line-height: 23px;
                                    height: 23px;
                                }

                                #wrap_invoice .page-title {
                                    color: #009be1;
                                    text-align: center;
                                }

                                #wrap_invoice .invoice_header {
                                    background: #ffffff;
                                    color: #000000 !important;
                                    margin: -0.5cm -0.5cm 0 -0.5cm;
                                    padding: 0.5cm 0.5cm 0 0.5cm;
                                }

                                #wrap_invoice .invoice_header * {
                                    color: #000000 !important;
                                    margin: 0;
                                }

                                #wrap_invoice .invoice_footer,
                                #wrap_invoice .invoice_footer p,
                                #wrap_invoice .invoice_footer .pagging {
                                    background: #ffffff;
                                    color: #2e2e2e;
                                }
                            </style>
                        </div>
                        <div class="wrapper" style="width: 1101px; height: 851px; overflow: hidden;">
                            <div id="wrap_invoice" class="page A4 portrait"
                                 style="transform: scale(1); transform-origin: 0px 0px 0px;">
                                <header class="invoice_header etat_header">
                                    <div class="row model1">
                                        <div class="col-xs-4 invoice-logo">
                                            <img src="{{ asset('trust.png') }}" alt="SIS"
                                                 style="vertical-align:middle; width: 100%;">
                                        </div>
                                        <div class="col-xs-8 invoice-header-info"><h4>Filerole</h4>
                                            <p>Cairo, egypt., Cairo, 11311 EG, Egypt <br><strong>Phone:</strong>
                                                00201101000607 <strong><br>Email: </strong>khaled.asal8@gmail.com</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="clearfix"></div>
                                </header>
                                <center><h3 class="page-title">Invoice</h3></center>
                                <div class="etat_content">
                                    <div class="row text-md-center">
                                        <div class="col-sm-3">
                                            <h3 class="inv col"><b>Invoice N°</b><br>0010</h3>
                                        </div>
                                        <div class="col-sm-3">
                                            <h3 class="inv col"><b>Reference</b><br>INV-170010</h3>
                                        </div>
                                        <div class="col-sm-3">
                                            <h3 class="inv col"><b>Date</b><br>09/07/2017</h3>
                                        </div>
                                        <div class="col-sm-3">
                                            <h3 class="inv col"><b>Due Date</b><br>31/07/2017</h3>
                                        </div>
                                    </div>
                                    <hr>
                                    <br>
                                    <div class="row inv">
                                        <div class="col-sm-12">
                                            <h4>Bill to</h4>
                                        </div>
                                        <div class="col-sm-6">
                                            <h3 class="inv"> bessem zitouni</h3>
                                            <b>Address:</b> 08 Rue Kahlalache Lakhdar Ain Lahdjar - Setif 19018 Algerie,<br>
                                        </div>
                                        <div class="col-sm-6">
                                            <b>Phone:</b> +20123456789<br><b>Email:</b> custmer@gmail.com
                                        </div>
                                        <div style="clear: both;"></div>
                                    </div>
                                    <br>
                                    <h3 class="inv">invoice items</h3>
                                    <table class="table_invoice table_invoice-condensed table_invoice-bordered table_invoice-striped"
                                           style="margin-bottom: 5px;">
                                        <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Description (Code)</th>
                                            <th>Quantity</th>
                                            <th>Unit price</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-md-center">1</td>
                                            <td class="text-md-left">Sony vaio (Pc Portable)</td>
                                            <td class="text-md-center">2.00</td>
                                            <td class="text-md-center">500,00 $</td>
                                            <td class="text-md-center">1 000,00 $</td>
                                        </tr>
                                        <tr>
                                            <td class="text-md-center">2</td>
                                            <td class="text-md-left">Wireless Alfa + Decoder</td>
                                            <td class="text-md-center">1.00</td>
                                            <td class="text-md-center">320,00 $</td>
                                            <td class="text-md-center">320,00 $</td>
                                        </tr>
                                        <tr>
                                            <td class="text-md-center">3</td>
                                            <td class="text-md-left">Flash disk</td>
                                            <td class="text-md-center">5.00</td>
                                            <td class="text-md-center">1,20 $</td>
                                            <td class="text-md-center">6,00 $</td>
                                        </tr>
                                        <tr>
                                            <td class="text-md-center">4</td>
                                            <td class="text-md-left">SkyWifi</td>
                                            <td class="text-md-center">1.00</td>
                                            <td class="text-md-center">35,00 $</td>
                                            <td class="text-md-center">35,00 $</td>
                                        </tr>
                                        <tr>
                                            <td class="text-md-center">5</td>
                                            <td class="text-md-left">Aduino</td>
                                            <td class="text-md-center">10.00</td>
                                            <td class="text-md-center">5,00 $</td>
                                            <td class="text-md-center">50,00 $</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-md-right font-weight-bold">Subtotal</td>
                                            <td class="text-md-right font-weight-bold">1 411,00 $</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-md-right font-weight-bold">Global tax</td>
                                            <td class="text-md-right font-weight-bold">(17%) 239,87 $</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-md-right font-weight-bold">Total</td>
                                            <td class="text-md-right font-weight-bold">1 650,87 $</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="col-sm-12">
                                        <p></p>
                                        <p>Note: this is preview invoice</p>
                                    </div>
                                </div>
                                <div style="clear: both;"></div>
                                <div class="etat_footer">
                                    <div class="row">
                                        <div class="col-xs-4 col-xs-offset-8"><p>&nbsp;</p>
                                            <p style="border-bottom: 1px solid #666;">&nbsp;</p>
                                            <p class="text-md-center">signature &amp; stamp</p>
                                        </div>
                                    </div>
                                    <p>&nbsp;</p>
                                    <div style="clear: both;"></div>
                                </div>
                                <footer class="invoice_footer">
                                    <hr>
                                    <p>Filerole © 2017</p></footer>
                                <div style="clear: both;"></div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            function setPrinterConfig() {
                                resolution = $('#resolution').val() != undefined ? $('#resolution').val() : "A4";
                                rotate = $('#rotate').val() != undefined ? $('#rotate').val() : "portrait";

                                $('.page').removeClass('A4 A5 Letter Legal');
                                $('.page').addClass(resolution);
                                $('.page').removeClass('portrait landscape');
                                $('.page').addClass(rotate);

                                w = "21cm";
                                h = "29.7cm";
                                if (resolution == "A4") {
                                    w = "21cm";
                                    h = "29.7cm";
                                } else if (resolution == "A5") {
                                    w = "14.8cm";
                                    h = "21cm";
                                } else if (resolution == "Letter") {
                                    w = "21.6cm";
                                    h = "27.9cm";
                                } else if (resolution == "Legal") {
                                    w = "21.6cm";
                                    h = "35.6cm";
                                }
                                if (rotate == "landscape") {
                                    $('#pageInit').html("@page{size: " + h + " " + w + "}");
                                } else {
                                    $('#pageInit').html("@page{size: " + w + " " + h + "}");
                                }
                                scaleTemplate();
                            };

                            function getPageHeight() {
                                resolution = $('#resolution').val() != undefined ? $('#resolution').val() : "A4";
                                rotate = $('#rotate').val() != undefined ? $('#rotate').val() : "portrait";

                                w = 21;
                                h = 29.7;
                                if (resolution == "A4") {
                                    w = 21;
                                    h = 29.7;
                                } else if (resolution == "A5") {
                                    w = 14.8;
                                    h = 21;
                                } else if (resolution == "Letter") {
                                    w = 21.6;
                                    h = 27.9;
                                } else if (resolution == "Legal") {
                                    w = 21.6;
                                    h = 35.6;
                                }
                                if (rotate == "landscape") {
                                    return w;
                                } else {
                                    return h;
                                }
                            };

                            function getPageWidth() {
                                resolution = $('#resolution').val() != undefined ? $('#resolution').val() : "A4";
                                rotate = $('#rotate').val() != undefined ? $('#rotate').val() : "portrait";

                                w = 21;
                                h = 29.7;
                                if (resolution == "A4") {
                                    w = 21;
                                    h = 29.7;
                                } else if (resolution == "A5") {
                                    w = 14.8;
                                    h = 21;
                                } else if (resolution == "Letter") {
                                    w = 21.6;
                                    h = 27.9;
                                } else if (resolution == "Legal") {
                                    w = 21.6;
                                    h = 35.6;
                                }
                                if (rotate == "landscape") {
                                    return h;
                                } else {
                                    return w;
                                }
                            };

                            function scaleTemplate() {
                                $.each($('[id=wrap_invoice]'), function (i, wrap_invoice) {
                                    var scale = 1;
                                    if ($(wrap_invoice).parent().is(".wrapper")) {
                                        $(wrap_invoice).unwrap();
                                    }
                                    var parent = $(wrap_invoice).parent();
                                    var padding = $(parent).outerWidth() - $(parent).width();
                                    var outer_height = $(parent).height();
                                    var inner_height = $(wrap_invoice).outerHeight();
                                    var outer_width = $(parent).width();
                                    var inner_width = $(wrap_invoice).outerWidth();
                                    if (outer_width < inner_width) {
                                        if (padding == 0) {
                                            scale = parseFloat(outer_width / (inner_width + 20));
                                            padding = 20;
                                        } else {
                                            scale = parseFloat(outer_width / inner_width);
                                            padding = 0;
                                        }
                                        var x = padding / 2;
                                        var origin = x.toFixed(2) + "px 0px 0px";
                                        $(wrap_invoice).css({
                                            '-webkit-transform': 'scale(' + (scale.toFixed(2)) + ')',
                                            '-webkit-transform-origin': origin
                                        });
                                        var wrapper = $("<div class='wrapper'></div>");
                                        $(wrapper).css({
                                            'width': inner_width * scale,
                                            'height': inner_height * scale,
                                            "overflow": "hidden"
                                        });
                                        $(wrap_invoice).wrap(wrapper);
                                    } else {
                                        $(wrap_invoice).css({'-webkit-transform': '', '-webkit-transform-origin': ""});
                                    }
                                });
                            };

                            document.table_border = false;
                            document.table_strip = false;
                            document.table_border = true;
                            document.table_strip = true;

                            $(document).ready(function () {
                                $('#wrap_invoice table').removeClass();
                                $('#wrap_invoice table').addClass('table_invoice table_invoice-condensed');

                                $('#wrap_invoice table').addClass('table_invoice-bordered');

                                $('#wrap_invoice table').addClass('table_invoice-striped');


                                setPrinterConfig();
                                $('body').on('keyup', function (ev) {
                                    if (ev.keyCode == 27) {
                                        $('#close_page').click();
                                    }
                                });

                                $('#close_page').click(function () {
                                    window.close();
                                    window.parent.window.close();
                                    return false;
                                });
                            });
                            setTimeout(function () {
                                $(window).trigger("resize");
                            }, 100);
                        </script>
                    </div>
                    <div id="loading_preview" style="display: none;">
                        <div class="black_background"></div>
                        <div class="loader_img"></div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </form>
    

    <!-- DEFAULT CONTENT -->
    <div id="default_content" style="display:none;">
        <div class="row text-md-center">
            <div class="col-sm-3">
                <h3 class="inv col"><b>Invoice N°</b><br>0010</h3>
            </div>
            <div class="col-sm-3">
                <h3 class="inv col"><b>Reference</b><br>INV-170010</h3>
            </div>
            <div class="col-sm-3">
                <h3 class="inv col"><b>Date</b><br>09/07/2017</h3>
            </div>
            <div class="col-sm-3">
                <h3 class="inv col"><b>Due Date</b><br>31/07/2017</h3>
            </div>
        </div>
        <hr>
        <br>
        <div class="row inv">
            <div class="col-sm-12">
                <h4>Bill to</h4>
            </div>
            <div class="col-sm-6">
                <h3 class="inv"> Customer name</h3>
                <b>Address:</b> Customer address,<br></div>
            <div class="col-sm-6">
                <b>Phone:</b> +2123456789<br><b>Email:</b> customer@email.com
            </div>
            <div style="clear: both;"></div>
        </div>
        <br>
        <h3 class="inv">invoice items</h3>
        <table class="table_invoice table_invoice-condensed table_invoice-striped" style="margin-bottom: 5px;">
            <thead>
            <tr>
                <th>N°</th>
                <th>Description (Code)</th>
                <th>Quantity</th>
                <th>Unit price</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-md-center">1</td>
                <td class="text-md-left">Sony vaio (Pc Portable)</td>
                <td class="text-md-center">2.00</td>
                <td class="text-md-center">500,00 $</td>
                <td class="text-md-center">1 000,00 $</td>
            </tr>
            <tr>
                <td class="text-md-center">2</td>
                <td class="text-md-left">Wireless Alfa + Decoder</td>
                <td class="text-md-center">1.00</td>
                <td class="text-md-center">320,00 $</td>
                <td class="text-md-center">320,00 $</td>
            </tr>
            <tr>
                <td class="text-md-center">3</td>
                <td class="text-md-left">Flash disk</td>
                <td class="text-md-center">5.00</td>
                <td class="text-md-center">1,20 $</td>
                <td class="text-md-center">6,00 $</td>
            </tr>
            <tr>
                <td class="text-md-center">4</td>
                <td class="text-md-left">SkyWifi</td>
                <td class="text-md-center">1.00</td>
                <td class="text-md-center">35,00 $</td>
                <td class="text-md-center">35,00 $</td>
            </tr>
            <tr>
                <td class="text-md-center">5</td>
                <td class="text-md-left">Aduino</td>
                <td class="text-md-center">10.00</td>
                <td class="text-md-center">5,00 $</td>
                <td class="text-md-center">50,00 $</td>
            </tr>
            <tr>
                <td colspan="4" class="text-md-right font-weight-bold">Subtotal</td>
                <td class="text-md-right font-weight-bold">1 411,00 $</td>
            </tr>
            <tr>
                <td colspan="4" class="text-md-right font-weight-bold">Global tax</td>
                <td class="text-md-right font-weight-bold">(17%) 239,87 $</td>
            </tr>
            <tr>
                <td colspan="4" class="text-md-right font-weight-bold">Total</td>
                <td class="text-md-right font-weight-bold">1 650,87 $</td>
            </tr>
            </tbody>
        </table>
        <div class="col-sm-12">
            <p></p>
            <p>Note: this is preview invoice</p>
        </div>
    </div>

    <!-- /.conainer-fluid -->
</main>
<div class="chat" style="display: none;">
    <div class="chat-header clearfix">
        <div class="chat-about">
            <span class="chat-status"><i class="fa fa-circle"></i></span>
            <div class="chat-with"></div>
        </div>
        <span class="label label-danger label-pill" style="display: none;">0</span>
        <button type="button" class="pull-right btn btn-transparent btn-sm close-chat" title="Close">
            <i class="fa fa-close"></i>
        </button>
        <button type="button" class="pull-right btn btn-transparent btn-sm delete-conversation"
                title="Delete conversation">
            <i class="fa fa-trash"></i>
        </button>
    </div> <!-- end chat-header -->
    <div class="chat-content">
        <div class="chat-history">
            <ul></ul>
        </div> <!-- end chat-history -->
        <div class="chat-message clearfix">
            <textarea placeholder="type your message ..." rows="1"></textarea>
            <button class="btn btn-default" id="send-btn"><i class="icon-paper-plane"></i></button>
        </div> <!-- end chat-message -->
    </div>
</div> <!-- end chat -->

<aside class="aside-menu">
    <div class="people-list" id="people-list">
        <div class="search" style="display: none;">
            <input type="text" placeholder="search"/>
            <i class="fa fa-search"></i>
        </div>
        <ul class="list"></ul>
    </div>
</aside>

<!-- JAVASCRIPT FILES -->
<script type="text/javascript" src="{{ asset('assets_invoice/vendor/bootstrap.colorpickersliders/bootstrap.colorpickersliders.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/vendor/bootstrap.colorpickersliders/tinycolor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/vendor/ion.rangeSlider/ion.rangeSlider.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/vendor/fileuploader/jquery.fileuploader.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/vendor/dom-to-image/dom-to-image.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/vendor/jquery-ui/jquery-ui.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/js/libs/tether.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/js/libs/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/js/libs/pace.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/vendor/chartjs/Chart.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/js/libs/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/vendor/toastrjs/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/vendor/bootbox/bootbox.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/js/libs/gauge.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/vendor/moment/moment.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/js/libs/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/vendor/bootstrap.datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/js/libs/jquery.maskedinput.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets_invoice/vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets_invoice/js/app.js') }}"></script>

<!-- JAVASCRIPT FILES END -->

<div class="loading-backdrop"></div>

<script type="text/javascript">
        
</script>
</body>
</html>
