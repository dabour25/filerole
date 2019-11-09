@extends('layouts.admin', ['title' => 'edit menu' ])
@section('styles')
    <style media="screen">
        .btnMenuStyle {
            padding: 5px;
            margin 0;
        }

        @if (app()->getLocale() == 'ar')
        .changeMenuStyle {
            float: left !important;
        }

        .editmenuDataForm {
            text-align: right;
        }

        .menu_edit_footer {
            padding-right: 40px;
        }

        .btn-group.pull-right {
            float: left !important;
        }

        .HintAlertBox {
            background: #fff;
            position: relative;
            /* padding:20px; */
            border: 2px solid #34a0d5;
        }

        .HintAlertBox .alertIcon {
            font-size: 50px;
            color: #34a0d5;
        }

        .divAlert {
            padding: 20px 0;
        }
        .HintAlertBox .exsitBtn {
            background: #34a0d5;
            border: none;
            position: absolute;
            left: 0;
            top: 0;
            z-index: 999;
        }

        @else
        .btn-group.pull-right {
            float: right !important;
        }
        .HintAlertBox {
            background: #fff;
            position: relative;
            /* padding:20px; */
            border: 2px solid #34a0d5;
        }
        .HintAlertBox .alertIcon {
            font-size: 50px;
            color: #34a0d5;
        }
        .divAlert {
            padding: 20px 0;
        }
        .HintAlertBox .exsitBtn {
            background: #34a0d5;
            border: none;
            position: absolute;
            right: 0;
            top: 0;
            z-index: 999;
        }

        @endif
        .menuLabel {
            padding: 15px;
        }
        .content-dash .panel .panel-body {
            background: transparent;
        }
        .clickable {
            padding: 5px !important;
            margin: 0 !important;
        }
        .btnEdit {
            height: 35px;
            padding-top: 7px !important;
        }
        .editmenuHeader {
            padding-right: 50px;
        }
        .sortableListsClosed {
            padding-right: 50px;
        }
    </style>
@endsection
@section('content')
    <div id="main-wrapper" class="main-wrapper-index">
        <div class="content-dash">
            <div class="alert_new">
                <span class="alertIcon">
                    <i class="fas fa-exclamation-circle"></i>
                </span>
                <p>
                    @if (app()->getLocale() == 'ar')
                        {{ DB::table('function_new')->where('id',102)->value('description') }}
                    @else
                        {{ DB::table('function_new')->where('id',102)->value('description_en') }}
                    @endif
                </p>
                <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i> </a>
            </div>
            <div class="editmenuDataForm">
                <form id="frmEdit" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="text"
                                       class="menuLabel control-label">{{ __('strings.editMenu_placeholderName_ar') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control item-menu" name="text" id="text"
                                           placeholder="  {{ __('strings.editMenu_placeholderName_ar') }}  ">
                                    <input type="hidden" class="form-control item-menu" name="id" id="menu_id"
                                           placeholder="Text">
                                    <input type="hidden" class="form-control item-menu" id="user_id" name="user_id"
                                           placeholder="Text">
                                    <input type="hidden" class="form-control item-menu" id="org_id" name="org_id"
                                           placeholder="Text">

                                    <div class="input-group-btn">
                                        <button type="button" id="myEditor_icon" class="btn btn-default"
                                                data-iconset="fontawesome">
                                            <i class="fa fa-address-book"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" name="icon" class="item-menu" id="icon_menu">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="href"
                                       class="menuLabel control-label">{{ __('strings.editMenu_placeholderName_en') }}</label>
                                <input type="text" class="form-control item-menu" id="name_eng" name="name_eng"
                                       placeholder=" {{ __('strings.editMenu_placeholderName_en') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-left">
                        <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i
                                    class="fa fa-refresh"></i> {{ __('strings.editMenu_edit') }} </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-12">

            <div class="panel-body panel-body-edit" id="cont">

                <div class="edit_menu_adv">
                    <div class="editmenuHeader">
                        <h5>{{ __('strings.editMenu_orderMenu') }}  </h5>
                    </div>
                    <ul id="myEditor" class="sortableLists list-group">
                    </ul>
                </div>

                <div class="menu_edit_footer">
                    <button type="button" id="btnOutput" class="btn btn-primary"><i
                                class="fas fa-save"></i> {{ __('strings.editMenu_saveChanges') }}</button>
                    <button type="button" id="default_menu" class="btn btn-primary"><i
                                class="fas fa-undo-alt"></i> {{ __('strings.editMenu_default') }}</button>
                </div>

                <div class="alert-infto ">
                    <span class="menu_msg"></span>
                    <span class="menu_icon"></span>
                </div>

            </div>

        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#loadingg').hide();
            var iconPickerOptions = {
                searchText: 'Buscar...',
                labelHeader: '{0} de {1} Pags.'
            };
            var sortableListOptions = {
                placeholderCss: {
                    'background-color': 'cyan'
                }
            };

            var editor = new MenuEditor('myEditor', {
                listOptions: sortableListOptions,
                iconPicker: iconPickerOptions,
                labelEdit: 'Edit'
            });
            editor.setForm($('#frmEdit'));
            editor.setUpdateButton($('#btnUpdate'));
            $("#myEditor").load("{{ url('admin/all_menus_list') }}", function (data) {
                editor.setData(data);
            });

            $('.HintAlertBox .exsitBtn').click(function () {
                $('.HintAlertBox').fadeOut(600);
            });

            $("#default_menu").click(function () {
                var url = "{{ Route('default_menu') }}";
                var btn = $(this);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    dataType: 'json',
                    data: {
                        menu: 'default_menu',
                    },
                    type: 'POST',

                    beforeSend: function () {

                        $('.menu_msg').text('جار التحميل');
                        $('.menu_icon').html('<i class="fas fa-spinner fa-spin"></i>');

                    },
                    success: function (msg) {
                        if (msg.data == 'successDefault') {
                            $('.menu_msg').text('تم التعديل بنجاح');
                            $('.menu_icon').fadeOut();
                            $("#myEditor").load("{{ url('admin/all_menus_list') }}", function (data) {
                                editor.setData(data);
                            });
                        }
                    }
                });
                return false;
            });


            $('#btnUpdate').click(function () {
                var url = "{{ Route('editMenu') }}";
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    dataType: 'json',
                    data: {
                        name: $('#text').val(),
                        icon: $('#icon_menu').val(),
                        name_en: $('#name_eng').val(),
                        menu_id: $('#menu_id').val(),
                        name: $('#text').val(),
                        icon: $('#icon_menu').val(),
                        name_en: $('#name_eng').val(),
                        menu_id: $('#menu_id').val(),
                        user_id: $('#user_id').val(),
                        org_id: $('#org_id').val(),
                    },
                    type: 'POST',

                    beforeSend: function () {

                    },
                    success: function (msg) {
                        if (msg.data == 'successEdit') {
                            $("#myEditor").load("{{ url('admin/all_menus_list') }}", function (data) {
                                editor.setData(data);
                            });
                        }
                    }
                });
                return false;

            });

            $("#btnOutput").click(function () {
                var data = editor.getString();
                var url = "{{ Route('editAllMenus') }}";
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    dataType: 'json',
                    data: {
                        menu: data,
                    },
                    type: 'POST',
                    beforeSend: function () {
                    },
                    success: function (msg) {
                        if (msg.data == 'successAllEdit') {
                            $("#myEditor").load("{{ url('admin/all_menus_list') }}", function (data) {
                                editor.setData(data);
                            });
                        }
                    }
                });
                return false;
            });

            $('.menuCheckBox').change(function () {
                $(this).parents('p');
                $(this).addClass('UnCheck');
                $(this).removeClass('menuCheckBox');
                $('#unactive_links').append($(this).parents('p'));
            });
            $('#unactive_links').on('change', '.UnCheck', function () {
                $(this).parents('p');
                $(this).addClass('menuCheckBox');
                $(this).removeClass('UnCheck');
                $('#active_links').append($(this).parents('p'));
            });
        });
        $(document).ready(function () {
            $(".dropdown").click(function () {
                $('.dropdown-menu').slideUp();
                $(this).find('.dropdown-menu').slideToggle();
            });
        });
        function allowDrop(ev) {
            ev.preventDefault();
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        function drop(ev) {
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");
            ev.target.appendChild(document.getElementById(data));
        }
    </script>
@endsection