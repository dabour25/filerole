

$(function () {
            var siteUrl = $('meta[name="base_url"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#align_table a').click(function () {
                hor = $(this).data('hor');
                vert = $(this).data('vert');
                position = hor + " " + vert;
                $(this).parents('table').find('a').removeClass("selected");
                $(this).addClass("selected");
                $(this).parents('table').prev('input').val(position).change();
            });

            $.each($('#align_table'), function (i, align_table) {
                position = $(align_table).prev('input');
                if (position != undefined) {
                    position = $(position).val();
                    if (position != undefined && position.length != 0 && position.indexOf(" ") != -1) {
                        position = position.split(" ");
                        hor = position[0];
                        vert = position[1];
                        $(align_table).find('a').removeClass("selected");
                        $(align_table).find('a[data-hor="' + hor + '"][data-vert="' + vert + '"]').addClass("selected");
                    }
                }
            });

            $('#background_fit_btns button').click(function () {
                value = $(this).data('value');
                $(this).parents('#background_fit_btns').prev('input').val(value).change();
            });

            $.each($('#background_fit_btns'), function (i, btn_group) {
                fit = $(btn_group).prev('input');
                if (fit != undefined) {
                    fit = $(fit).val();
                    if (fit != undefined && fit.length != 0) {
                        $(btn_group).find('button').removeClass("active");
                        $(btn_group).find('button[data-value="' + fit + '"]').addClass("active");
                    }
                }
            });

            $('#background_image_remove_btn').click(function () {
                $('#background_image').val(" ").change();
                $('#background_image_thumb').attr("src", "");
                $('#background_image_div').slideUp();
            });

            $('#signature_stamp_remove_btn').click(function () {
                $('#signature_stamp').val("").change();
                $('#signature_stamp_thumb').attr("src", "");
                $('#signature_stamp_preview').hide();
            });

            tinymce.remove("#editor_header_text, #editor_footer_text");
            tinymce.init(
                Object.assign({}, tinymce_init_mini, {
                    selector: '#editor_header_text, #editor_footer_text',
                    height: 100,
                    toolbar: tinymce_init_mini.toolbar + ' | company_btns template',
                    plugins: tinymce_init_mini.plugins + ' template',
                    setup: function (editor) {
                        editor.on("change", function () {
                            var content = editor.getContent();
                            $('#' + editor.id).val(content);
                            $('.preview .invoice_preview').refreshPreviewTemplate();
                        });
                        editor.addButton('company_btns', {
                            type: 'menubutton',
                            text: 'Company',
                            icon: false,
                            menu: [
                                {
                                    text: 'Name', onclick: function () {
                                        editor.insertContent('&nbsp;[company_name]&nbsp;');
                                    }
                                },
                                {
                                    text: 'Address', onclick: function () {
                                        editor.insertContent('&nbsp;[company_address]&nbsp;');
                                    }
                                },
                                {
                                    text: 'City', onclick: function () {
                                        editor.insertContent('&nbsp;[company_city]&nbsp;');
                                    }
                                },
                                {
                                    text: 'State', onclick: function () {
                                        editor.insertContent('&nbsp;[company_state]&nbsp;');
                                    }
                                },
                                {
                                    text: 'Zip code', onclick: function () {
                                        editor.insertContent('&nbsp;[company_postal_code]&nbsp;');
                                    }
                                },
                                {
                                    text: 'Country', onclick: function () {
                                        editor.insertContent('&nbsp;[company_country]&nbsp;');
                                    }
                                },
                                {
                                    text: 'Phone', onclick: function () {
                                        editor.insertContent('&nbsp;[company_phone]&nbsp;');
                                    }
                                },
                                {
                                    text: 'Email', onclick: function () {
                                        editor.insertContent('&nbsp;[company_email]&nbsp;');
                                    }
                                },
                            ]
                        });
                    },
                    templates: [
                        {
                            title: 'Header',
                            content: '<h4>[company_name]</h4><p>[company_address], [company_city], [company_postal_code] [company_state], [company_country] <br><b>Phone:</b> [company_phone] <b><br>Email: </b>[company_email]</p>'
                        },
                        {title: 'Footer', content: '[company_name] &copy; 2019'}
                    ],
                })
            );

            $('#header_model_carousel').carousel({
                interval: 0
            });
            $('#header_model_carousel').bind('slid', function () {
                $('.model-item [name="template[header_model]"]').prop('checked', false);
                $('.model-item.active  [name="template[header_model]"]').prop('checked', true);
                $('.preview .invoice_preview').refreshPreviewTemplate();
            });

            function htmlEntities(str) {
                return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
            }

            var waiting = 5000;
            var last_send_time = 0;
            var send_ajax_Timeout = undefined;
            $.fn.refreshPreviewTemplate = function () {
                var self = this;

                if (waiting == 0) {
                    $(self).refreshPreviewTemplateAjax();
                } else {
                    var time_now = new Date().getTime();
                    var waiting_time = (time_now - last_send_time);
                    if (waiting_time >= waiting) {
                        $(self).refreshPreviewTemplateAjax();
                        last_send_time = time_now;
                        clearInterval(send_ajax_Timeout);
                        send_ajax_Timeout = undefined;
                        return;
                    }
                    if (send_ajax_Timeout != undefined) {
                        return;
                    }
                    if (waiting_time < waiting) {
                        send_ajax_Timeout = setInterval(function () {
                            $(self).refreshPreviewTemplate();
                        }, waiting_time);
                    }
                }
            };

            var global_zoom = undefined;
            $.fn.refreshPreviewTemplateAjax = function () {
                self = this;

                adata = $('form.customize_template').serialize();
                adata += "&" + $.param({"template[content]": $('#default_content').html()});

                $.ajax({
                    url: siteUrl + '/admin/settings/invoice_template',
                    data: adata,
                    async: false,
                    type: 'POST',
                    beforeSend: function () {
                        $('.preview').addClass('loading');
                        $('.preview #loading_preview').fadeIn('fast');
                    },
                    success: function (data) {
                        self.html(data);
                        if (global_zoom == undefined) {
                            setTimeout(function () {
                                setPreviewSize();
                            }, 50);
                        } else {
                            scale_preview(global_zoom);
                        }
                    },
                    complete: function () {
                        $('.preview #loading_preview').fadeOut('fast', function () {
                            $('.preview').removeClass('loading')
                        });
                    }
                });

            }

            $('#show_header_check').change(function () {
                if (!this.checked) {
                    $('#show_header_hidden').val('2');
                } else {
                    $('#show_header_hidden').val('1');
                }
            });
            $('#show_footer_check').change(function () {
                if (!this.checked) {
                    $('#show_footer').val('2');
                } else {
                    $('#show_footer').val('1');
                }
            });
            $('#show_signature_check').change(function () {
                if (!this.checked) {
                    $('#show_signature').val('2');
                } else {
                    $('#show_signature').val('1');
                }
            });
            $('#table_border_check').change(function () {
                if (!this.checked) {
                    $('#table_border').val('2');
                } else {
                    $('#table_border').val('1');
                }
            });
            $('#table_strip_check').change(function () {
                if (!this.checked) {
                    $('#table_strip').val('2');
                } else {
                    $('#table_strip').val('1');
                }
            });
            $('#auto_print_check').change(function () {
                if (!this.checked) {
                    $('#auto_print').val('2');
                } else {
                    $('#auto_print').val('1');
                }
            });
            $('#logo_greyscale_check').change(function () {
                if (!this.checked) {
                    $('#logo_greyscale').val('0');
                } else {
                    $('#logo_greyscale').val('1');
                }
            });
            $('#logo_monocolor_check').change(function () {
                if (!this.checked) {
                    $('#logo_monocolor').val('0');
                } else {
                    $('#logo_monocolor').val('1');
                }
            });


            $('#marginTop, #marginBottom, #marginLeft, #marginRight').change(function () {
                $('#margin').val($("#marginTop").val() + "cm " + $("#marginRight").val() + "cm " + $("#marginBottom").val() + "cm " + $("#marginLeft").val() + "cm");
            });
            $('form.customize_template input:not(#zoom), form.customize_template select').change(function () {
                $('.preview .invoice_preview').refreshPreviewTemplate();
            });
            $(".color").ColorPickerSliders({
                size: 'sm',
                placement: 'right',
                swatches: false,
                previewformat: 'hex',
                flat: false,
                order: {
                    rgb: 1,
                    opacity: false
                },
                hsvpanel: true,
                sliders: false,
                onhide: function () {
                    $('.preview .invoice_preview').refreshPreviewTemplate();
                }
            });
            $('#invoice_template_tabs a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            });

            function scale_preview(zoom) {
                var preview = $('.preview .invoice_preview');
                var wrap_invoice = $(preview).find('#wrap_invoice');
                var scale = 1;
                if (zoom == undefined) {
                    var parent = $(wrap_invoice).parent();
                    var outer_height = $(parent).height();
                    var inner_height = $(wrap_invoice).outerHeight();
                    var outer_width = $(parent).width();
                    var inner_width = $(wrap_invoice).outerWidth();
                    scale = parseFloat(outer_width / inner_width);
                    scale = Math.min(1, scale);
                    var slider = $("#zoom").data("ionRangeSlider");
                    slider.update({
                        from: scale * 100
                    });
                } else {
                    scale = zoom / 100;
                }
                var inner_width = $(wrap_invoice).outerWidth();
                var inner_height = $(wrap_invoice).outerHeight();
                $(wrap_invoice).parents(".wrapper").css({
                    'width': inner_width * scale,
                    'height': inner_height * scale,
                    "overflow": "hidden"
                });
                if ($(wrap_invoice).parent().is(".wrapper")) {
                    var wrapper = $(wrap_invoice).parents(".wrapper");
                } else {
                    var wrapper = $("<div class='wrapper'></div>");
                    $(wrap_invoice).wrap(wrapper);
                }
                global_zoom = scale * 100;
                var x = 0;
                var origin = x.toFixed(2) + "0px 0px 0px";
                $(wrap_invoice).css({
                    '-webkit-transform': 'scale(' + (scale.toFixed(2)) + ')',
                    '-webkit-transform-origin': origin
                });
                $(wrapper).css({'width': inner_width * scale, 'height': inner_height * scale, "overflow": "hidden"});
                createScreenShot();
            };

            $("#zoom").ionRangeSlider({
                min: 1,
                max: 100,
                prefix: "%",
                onChange: function (x) {
                    scale_preview(x.from);
                }
            });

            var SCREENSHOT = "";
            var WAIT_SCREENSHOT = false;

            $('form.customize_template .btn-submit').click(function () {
                if (SCREENSHOT == "") {
                    WAIT_SCREENSHOT = true;
                    createScreenShot();
                }
                $('#image_blob').val(SCREENSHOT);
                return !WAIT_SCREENSHOT;
            });

            function createScreenShot() {
                var node = $('#wrap_invoice').parent('.wrapper').get(0);
                domtoimage.toJpeg(node)
                    .then(function (dataUrl) {
                        $('#image_blob').val(dataUrl);
                        SCREENSHOT = dataUrl;
                        if (WAIT_SCREENSHOT) {
                            WAIT_SCREENSHOT = false;
                            $('form.customize_template .btn-submit').click();
                        }
                    }).catch(function (e) {
                });
            }

            $('.preview .invoice_preview').bind("contextmenu", function (e) {
                return false;
            });
            $('.preview .invoice_preview').bind("selectstart", function (e) {
                return false;
            });
            $('.preview .invoice_preview').refreshPreviewTemplate();

            function setPreviewSize() {
                if ($('.invoice_config').innerWidth() <= 768) {
                    var w = $('.invoice_config').innerWidth();
                    $('.preview').parent(".well").css({'width': w});
                    $('.invoice_config .card-toggled').css({'width': w, "min-height": ""});
                } else {
                    var w = $('.invoice_config').innerWidth() - $('.invoice_config .card-toggled').innerWidth();
                    var h = $('.invoice_config .card-toggled').height();
                    var mh = $(window).height() - 90;
                    $('.invoice_config .card-toggled').css({'min-height': mh});
                    $('.preview').parent(".well").css({'width': w, 'height': h, 'min-height': mh});
                }
                scale_preview(global_zoom);
            }

            window.onresize = function () {
                setPreviewSize();
            }

            $('.card-toggled .card-header').on("click", function () {
                $(this).find("i").toggleClass("icon-arrow-up");
                $(this).parent().find('.card-block').slideToggle(function () {
                    setPreviewSize();
                });
            });
        });
        var langsssss = $('meta[name="lang"]').attr('content');
        var tinymce_init = {
            language: 'ar',
            directionality: 'rtl',
            plugins: [
                'advlist autolink link image lists charmap preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking',
                'save table contextmenu directionality paste textcolor'
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview code fullscreen',
        };
        var tinymce_init_mini = {
            language: 'ar',
            directionality: 'rtl',
            plugins: [
                'advlist autolink link image lists charmap preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking',
                'save table contextmenu directionality paste textcolor'
            ],
            menubar: false,
            toolbar: 'bold italic | alignleft aligncenter alignright',
        };