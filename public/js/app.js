var siteUrl = $('meta[name="base_url"]').attr('content');
var lang = $('meta[name="lang"]').attr('content');

if (lang == 'ar') {
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
        /*  $check = validateDate();
        if ($check === false) {
            $('#times2').empty();
            if ($('span.help-block.date-error').css('display') == 'none') {
                $('span.help-block.date-error').css({"display": "block"});
                $('span.help-block.date-error2').css({"display": "none"});
                $('.panel .panel-white').css({"display": "none"});
            }
            return;
        } else {

            $('span.help-block.date-error').css({"display": "none"});
            $('span.date-captain-error').css({"display": "none"});
            var captainElement = document.getElementById('captain');
            var captainID = captainElement.options[captainElement.selectedIndex].value;
            $.get("/admin/reservations/captains/reserved/" + captainID + "/" + $('#date').val() + "/" + $('input[name="reservation_id"]').val(), function (data) {
                $("#time2").empty();


                timeSlotsHtml = '';

                if (!Object.keys(data.times).length >= 1) {
                    $('#times2').empty();
                    if ($('span.help-block.date-error2').css('display') == 'none') {
                        $('span.help-block.date-error2').css({"display": "block"});
                        $('.panel .panel-white').css({"display": "none"});
                    }
                    return;

                } else {
                    $('span.help-block.date-error2').css({"display": "none"});
                    $('span.date-captain-error2').css({"display": "none"});

                    $.each(data.times, function (key, value) {

                        if (data.reserved == key) {
                            timeSlotsHtml += `<li class="staff-time">
                           <input   class='start-time' type="radio" name="time" value="${key}" checked> <span>${value}</span>
                     </li>`;
                        } else {
                            timeSlotsHtml += `<li class="staff-time">
                           <input   class='start-time' type="radio" name="time" value="${key}" > <span>${value}</span>
                     </li>`;
                        }

                        $('#times2').html(timeSlotsHtml);

                    });
                }

            });
        }*/

        $('.js-example-basic-multiple').select2();
        $(".menu-two").hover(function () {
            $('.menu-two').css("width", "200px ");
            $('.menutwo-open').css("display", "none");
            $('.menutwo-close').css("display", "inline-block");
            $('.page-inner').css("paddingRight", "200px");
            $('.menu-two').removeClass('before_open');
            $('.menu-two').css("overflow", "auto");
            localStorage.setItem('Menu', 'openmenu');
        }, function () {
            $('.menu-two').css("width", "45px");
            $('.page-inner').css("paddingRight", "45px");
            $('.menu-two').addClass('before_open');
            $('.menutwo-open').css("display", "inline-block");
            $('.menutwo-close').css("display", "none");
            localStorage.setItem('Menu', 'closedmenu');
            $('.menu-two').css("overflow", "hidden");
        });
    });

    function menuTwo_open() {
        $('.menu-two').css("width", "200px ");
        $('.menutwo-open').css("display", "none");
        $('.menutwo-close').css("display", "inline-block");
        $('.page-inner').css("paddingRight", "200px");
        $('.menu-two').removeClass('before_open');
        localStorage.setItem('Menu', 'openmenu');
        $('.menu-two').css("overflow", "auto");

        $(".menu-two").hover(function () {
            $('.menu-two').css("width", "200px ");
            $('.menutwo-open').css("display", "none");
            $('.menutwo-close').css("display", "inline-block");
            $('.page-inner').css("paddingRight", "200px");
            $('.menu-two').removeClass('before_open');
            localStorage.setItem('Menu', 'openmenu');
        }, function () {
            $('.menu-two').css("width", "200px ");
            $('.menutwo-open').css("display", "none");
            $('.menutwo-close').css("display", "inline-block");
            $('.page-inner').css("paddingRight", "200px");
            $('.menu-two').removeClass('before_open');
            localStorage.setItem('Menu', 'openmenu');
        });

    };

    function menuTwo_close() {
        $('.menu-two').css("width", "45px");
        $('.page-inner').css("paddingRight", "45px");
        $('.menu-two').addClass('before_open');
        $('.menutwo-open').css("display", "inline-block");
        $('.menutwo-close').css("display", "none");
        localStorage.setItem('Menu', 'closedmenu');
        $('.menu-two').css("overflow", "hidden");

        $(".menu-two").hover(function () {
            $('.menu-two').css("width", "200px ");
            $('.menutwo-open').css("display", "none");
            $('.menutwo-close').css("display", "inline-block");
            $('.page-inner').css("paddingRight", "200px");
            $('.menu-two').removeClass('before_open');
            localStorage.setItem('Menu', 'openmenu');
        }, function () {
            $('.menu-two').css("width", "45px");
            $('.page-inner').css("paddingRight", "45px");
            $('.menu-two').addClass('before_open');
            $('.menutwo-open').css("display", "inline-block");
            $('.menutwo-close').css("display", "none");
            localStorage.setItem('Menu', 'closedmenu');
        });
    };
    $('#menu_check').change(function () {
        if ($(this).is(":checked")) {
            $('#navdesk').addClass('nav-top-desk');
            $('.menu-two').addClass('nav-top-desk2');
            $('.page-inner').css('paddingTop', '80px');
            $('.menutwo-open').addClass('nav-top-desk2');
        } else {
            $('#navdesk').removeClass('nav-top-desk');
            $('.menu-two').removeClass('nav-top-desk2');
            $('.page-inner').css('paddingTop', '45px');
            $('.menutwo-open').removeClass('nav-top-desk2');
        }
    });
    $(document).ready(function () {

        if (localStorage.Menu === 'openmenu') {
            $('.menu-two').css("width", "200px");
            $('.menutwo-open').css("display", "none");
            $('.menutwo-close').css("display", "inline-block");
            $('.page-inner').css("paddingRight", "200px");
            $('.menu-two').removeClass('before_open');

        } else {
            $('.menu-two').css("width", "45px");
            $('.menutwo-open').css("display", "inline-block");
            $('.menutwo-close').css("display", "none");
            $('.page-inner').css("paddingRight", "50px");
            $('.menu-two').addClass('before_open');
        }
    });

    function fullWidth() {
        document.getElementById("pageSide").style.width = "250px";
        document.getElementById("topSide").style.left = "250px";
        $('.page-inner').css("paddingLeft", "250px");

        var element = document.getElementById("pageSide");
        element.classList.add("dropClass");

        document.getElementById("whenopenR").style.display = "none";
        document.getElementById("whencloseR").style.display = "block";
    };

    function closeFull() {
        document.getElementById("pageSide").style.width = "48px";
        document.getElementById("topSide").style.left = "48px";
        $('.page-inner').css("paddingLeft", "48px");

        var element = document.getElementById("pageSide");
        element.classList.remove("dropClass");

        document.getElementById("whenopenR").style.display = "block";
        document.getElementById("whencloseR").style.display = "none";
    };

    function closenf() {
        document.getElementById("nfnav").style.left = "-400px";
        document.getElementById("whenopen").style.display = "block";
        document.getElementById("whenclose").style.display = "none";
    };

    function opennf() {
        document.getElementById("nfnav").style.left = "0";
        document.getElementById("whenopen").style.display = "none";
        document.getElementById("whenclose").style.display = "block";
    };

    function closenfMM() {
        document.getElementById("nfnav").style.left = "-100%";
        document.getElementById("whenopenM").style.display = "block";
        document.getElementById("whencloseM").style.display = "none";
    };

    function opennfMM() {
        document.getElementById("nfnav").style.left = "0";
        document.getElementById("whenopenM").style.display = "none";
        document.getElementById("whencloseM").style.display = "block";
    };

    $('.close-width').click(function () {
        $("#pageSide").toggleClass("dropClass");
    });

    function opennav() {
        $('.page-inner').css("right", "220px");
        $('.menu-two').css("width", "220px");
        $('.menu-two').removeClass("before_open");
        document.getElementById("whenopenmobileR").style.display = "none";
        document.getElementById("whenclosemobileR").style.display = "block";
        $('.menu-two').css("right", "0");
        $('.overflow_inner').css("display", "block");
    };

    function closenav() {
        $('.menu-two').css("width", "0");
        $('.page-inner').css("right", "0");
        document.getElementById("whenopenmobileR").style.display = "block";
        document.getElementById("whenclosemobileR").style.display = "none";
        $('.menu-two').css("right", "-60px");
        $('.overflow_inner').css("display", "none");
    };

    function opennavright() {
        document.getElementById("myNavRight").style.width = "230px";
        $('.page-content').css("right", "-230px");
    };

    function closenavright() {
        document.getElementById("myNavRight").style.width = "0%";
        $('.page-content').css("right", "0");
    };

    function youSee() {
        document.getElementById("afterSee").style.background = "#d6d6d6";
        document.getElementById("iconseeDone").style.display = "block";
    };

    function showSend() {
        $('.sendMS').css("display", "inline-block");
        $('.hideMS').css("display", "none");
    };

    function showSearch() {
        document.getElementById("messagesSearch").style.display = "block";
        document.getElementById("hidemessage").style.display = "none";
        document.getElementById("whenSS").style.display = "none";
        document.getElementById("whenHS").style.display = "block";
    };

    function hideSearch() {
        document.getElementById("messagesSearch").style.display = "none";
        document.getElementById("hidemessage").style.display = "block";
        document.getElementById("whenSS").style.display = "block";
        document.getElementById("whenHS").style.display = "none";
    };

    function gothisMessage() {
        document.getElementById("chatuser").style.display = "block";
        document.getElementById("chatclient").style.display = "none";
    };

    function backallM() {
        document.getElementById("chatuser").style.display = "none";
        document.getElementById("chatclient").style.display = "block";
    };
} else {
    function menuTwo_open() {
        $('.menu-two').css("width", "200px ");
        $('.menutwo-open').css("display", "none");
        $('.menutwo-close').css("display", "inline-block");
        $('.page-inner').css("paddingLeft", "200px");
        $('.menu-two').removeClass('before_open');
        localStorage.setItem('Menu', 'openmenu');

    };

    function menuTwo_close() {
        $('.menu-two').css("width", "45px");
        $('.page-inner').css("paddingLeft", "45px");
        $('.menu-two').addClass('before_open');
        $('.menutwo-open').css("display", "inline-block");
        $('.menutwo-close').css("display", "none");
        localStorage.setItem('Menu', 'closedmenu');
    };

    $('#menu_check').change(function () {

        if ($(this).is(":checked")) {
            $('#navdesk').addClass('nav-top-desk');
            $('.menu-two').addClass('nav-top-desk2');
            $('.page-inner').css('paddingTop', '80px');
            $('.menutwo-open').addClass('nav-top-desk2');
        } else {
            $('#navdesk').removeClass('nav-top-desk');
            $('.menu-two').removeClass('nav-top-desk2');
            $('.page-inner').css('paddingTop', '45px');
            $('.menutwo-open').removeClass('nav-top-desk2');
        }
    });
    $(document).ready(function () {

        if (localStorage.Menu === 'openmenu') {
            $('.menu-two').css("width", "200px");
            $('.menutwo-open').css("display", "none");
            $('.menutwo-close').css("display", "inline-block");
            $('.page-inner').css("paddingLeft", "200px");
            $('.menu-two').removeClass('before_open');

        } else {
            $('.menu-two').css("width", "45px");
            $('.menutwo-open').css("display", "inline-block");
            $('.menutwo-close').css("display", "none");
            $('.page-inner').css("paddingLeft", "50px");
            $('.menu-two').addClass('before_open');
        }
    });

    function fullWidth() {
        document.getElementById("pageSide").style.width = "250px";
        document.getElementById("topSide").style.left = "250px";
        $('.page-inner').css("paddingLeft", "250px");

        var element = document.getElementById("pageSide");
        element.classList.add("dropClass");

        document.getElementById("whenopenR").style.display = "none";
        document.getElementById("whencloseR").style.display = "block";
    };

    function closeFull() {
        document.getElementById("pageSide").style.width = "48px";
        document.getElementById("topSide").style.left = "48px";
        $('.page-inner').css("paddingLeft", "48px");

        var element = document.getElementById("pageSide");
        element.classList.remove("dropClass");

        document.getElementById("whenopenR").style.display = "block";
        document.getElementById("whencloseR").style.display = "none";
    };

    function closenf() {
        document.getElementById("nfnav").style.right = "-400px";
        document.getElementById("whenopen").style.display = "block";
        document.getElementById("whenclose").style.display = "none";
    };

    function opennf() {
        document.getElementById("nfnav").style.right = "0";
        document.getElementById("whenopen").style.display = "none";
        document.getElementById("whenclose").style.display = "block";
    };

    function closenfMM() {
        document.getElementById("nfnav").style.right = "-100%";
        document.getElementById("whenopenM").style.display = "block";
        document.getElementById("whencloseM").style.display = "none";
    };

    function opennfMM() {
        document.getElementById("nfnav").style.right = "0";
        document.getElementById("whenopenM").style.display = "none";
        document.getElementById("whencloseM").style.display = "block";
    };

    $('.close-width').click(function () {
        $("#pageSide").toggleClass("dropClass");
    });

    function opennav() {
        $('.page-inner').css("left", "220px");
        $('.menu-two').css("width", "220px");
        $('.menu-two').removeClass("before_open");
        document.getElementById("whenopenmobileR").style.display = "none";
        document.getElementById("whenclosemobileR").style.display = "block";
        $('.menu-two').css("left", "0");
        $('.overflow_inner').css("display", "block");
    };

    function closenav() {
        $('.menu-two').css("width", "0");
        $('.page-inner').css("left", "0");
        document.getElementById("whenopenmobileR").style.display = "block";
        document.getElementById("whenclosemobileR").style.display = "none";
        $('.menu-two').css("right", "-60px");
        $('.overflow_inner').css("display", "none");
    };

    function opennavright() {
        document.getElementById("myNavRight").style.width = "230px";
        $('.page-content').css("right", "-230px");
    };

    function closenavright() {
        document.getElementById("myNavRight").style.width = "0%";
        $('.page-content').css("right", "0");
    };

    function youSee() {
        document.getElementById("afterSee").style.background = "#d6d6d6";
        document.getElementById("iconseeDone").style.display = "block";
    };

    function showSend() {
        $('.sendMS').css("display", "inline-block");
        $('.hideMS').css("display", "none");
    };

    function showSearch() {
        document.getElementById("messagesSearch").style.display = "block";
        document.getElementById("hidemessage").style.display = "none";
        document.getElementById("whenSS").style.display = "none";
        document.getElementById("whenHS").style.display = "block";
    };

    function hideSearch() {
        document.getElementById("messagesSearch").style.display = "none";
        document.getElementById("hidemessage").style.display = "block";
        document.getElementById("whenSS").style.display = "block";
        document.getElementById("whenHS").style.display = "none";
    };

    function gothisMessage() {
        document.getElementById("chatuser").style.display = "block";
        document.getElementById("chatclient").style.display = "none";
    };

    function backallM() {
        document.getElementById("chatuser").style.display = "none";
        document.getElementById("chatclient").style.display = "block";
    };
}

$(function () {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);
    $("#viewport").click(function () {
        $("head").append("<meta name='viewport' content='width=960px, initial-scale=0.3333333333333333' data-rs='width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1'>");
    });
    $.extend($.fn.dataTable.defaults, {
        searching: true,
        ordering: false
    });
    $('[data-toggle="tooltip"]').tooltip();

    $(".loading-overlay .all-spi").fadeOut(1000, function () {
        // Show The Scroll
        $("body").css("overflow-y", "auto");
        $(this).parent().fadeOut(1000, function () {
            $(this).remove();
            document.getElementById("myNavTwo").style.opacity = "1";
        });
    });
    $('.alert').delay(5000).fadeOut('slow');

    var setCookie = function (n, val) {
        var exdays = 30;
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = n + "=" + val + "; " + expires;
    };

    var getCookie = function (n) {
        var name = n + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    };

    /* document.onclick = function (e) {
         if (e.target.className == 'btncolor') {
             var favColor = e.target.style.background;
             setCookie('color', favColor);
             document.getElementById("allbg").style.background = favColor;
             console.log(favColor);
         }
     };

     window.onload = function () {
         var favColor = document.body.style.background;
         var color = getCookie('color');
         if (color === '') {
             document.getElementById("allbg").style.background = favColor;
         } else {
             document.getElementById("allbg").style.background = color;
         }
     };*/

    $("#myBtn").click(function () {
        $("#myButtons").modal({backdrop: true});
    });
    $("#myopenbg").click(function () {
        $("#mybgs").modal({backdrop: true});
    });
    $("#checkbox4").change(function () {
        $("#myNav").toggleClass("navbar-mainmenu-fixed-top", this.checked)
        $(".page-title").toggleClass("title-mar", this.checked)
        $(".navis-fixed").toggleClass("navis-fixed-none", this.checked)
        $(".navis-relative").toggleClass("navis-relative-block", this.checked)
    }).change();

    $("#loadingcheck").change(function () {
        $("#loadingg").toggleClass("loadingnone", this.checked)
        $(".navis-fixed2").toggleClass("navis-fixed-none", this.checked)
        $(".navis-relative2").toggleClass("navis-relative-block", this.checked)
    }).change();

    $("#helplinks_check").change(function () {
        if ($('#helplinks_check').is(':checked')) {
            $('.abs_button').css("display", "block");
        } else {
            $('.abs_button').css("display", "none");
        }
        $(".navis-fixed3").toggleClass("navis-fixed-none", this.checked)
        $(".navis-relative3").toggleClass("navis-relative-block", this.checked)
    }).change();

    function clock() {// We create a new Date object and assign it to a variable called "time".
        var time = new Date(),
            // Access the "getHours" method on the Date object with the dot accessor.
            hours = time.getHours(),
            // Access the "getMinutes" method with the dot accessor.
            minutes = time.getMinutes(), seconds = time.getSeconds();
        document.querySelectorAll('.clock')[0].innerHTML = harold(hours) + ":" + harold(minutes) + ":" + harold(seconds);

        function harold(standIn) {
            if (standIn < 10) {
                standIn = '0' + standIn
            }
            return standIn;
        }
    }

    setInterval(clock, 0);
    document.addEventListener('DOMContentLoaded', function () {
        var input = document.getElementById("showpassword");
        input.addEventListener("keyup", function (event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                document.getElementById("butEnter").click();
            }
        });
    });
    $('.js-select').select2({width: 300, required: true});
    $('.products, .companies').select2({width: 300, required: true});
    $(".datepicker").datepicker({defaultDate: null, rtl: true});
    

    var input = document.querySelector("#phone"),
        errorMsg = document.querySelector("#error-msg"),
        validMsg = document.querySelector("#valid-msg");
    if ($('#phone').length) {
        var errorMap = ["☓ رقم غير صالح", "☓ رمز البلد غير صالح", "☓ قصير جدا", "☓ طويل جدا", "☓ رقم غير صالح"];

        var iti = window.intlTelInput(input, {
            initialCountry: "auto",
            geoIpLookup: function (callback) {
                $.get('https://ipinfo.io', function () {
                }, "jsonp").always(function (resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/utils.js"
        });

        var reset = function () {
            input.classList.remove("error");
            errorMsg.innerHTML = "";
            errorMsg.classList.add("hide");
            validMsg.classList.add("hide");
        };

        input.addEventListener('blur', function () {
            reset();
            if (input.value.trim()) {
                if (iti.isValidNumber()) {
                    validMsg.classList.remove("hide");
                } else {
                    input.classList.add("error");
                    var errorCode = iti.getValidationError();
                    errorMsg.innerHTML = errorMap[errorCode];
                    errorMsg.classList.remove("hide");
                }
            }
        });

        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);
    }

});

function changeFont(font) {
    document.getElementById("output-text").style.fontFamily = font.value;
}

function show_abs() {
    $('.buttons_abs_show').css("left", "30px");
    $('.buttons_abs_show').css("opacity", "1");
    $('.buttons_abs_show').css("display", "block");
    $('.hidden_aps').css("display", "block");
    $('.show_aps').css("display", "none");
};

function close_abs() {
    $('.buttons_abs_show').css("left", "0");
    $('.buttons_abs_show').css("opacity", "0");
    $('.hidden_aps').css("display", "none");
    $('.show_aps').css("display", "block");
    $('.buttons_abs_show').css("display", "none");
};

function closemodal2() {
    document.getElementById("myModal2").style.display = "none";
};

function closemodal() {
    document.getElementById("myModal").style.display = "none";
};

function selectAll() {
    var items = document.getElementsByName('acs');
    for (var i = 0; i < items.length; i++) {
        if (items[i].type == 'checkbox')
            items[i].checked = true;
    }
}

function UnSelectAll() {
    var items = document.getElementsByName('acs');
    for (var i = 0; i < items.length; i++) {
        if (items[i].type == 'checkbox')
            items[i].checked = false;
    }
}

function myFunction(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}

function close_alert() {
    $('.alert_new').css("display", "none");
};

$(".checkall_check").on("click", function () {
    $('.checkall_check').css("display", "none");
    $('.checkall_uncheck').css("display", "block");
    $(".checkhour").prop("checked", true);
    $(".partext").css("color", "#41901a");
});

$(".checkall_uncheck").on("click", function () {
    $('.checkall_check').css("display", "block");
    $('.checkall_uncheck').css("display", "none");
    $(".checkhour").prop("checked", false);
    $('.partext').css("color", "#000");
});

function checkcolor(par_id){
    if($('.checkchild'+par_id+':checked').length ==$('.checkchild'+par_id).length){
        $('#partext'+par_id).css("color", "#41901a");
        if($('.checkchild'+par_id).length==0&&!$('#par'+par_id).is(':checked')){
            $('#partext'+par_id).css("color", "#000");
        }
    }else if($('.checkchild'+par_id+':checked').length >0){
        $('#partext'+par_id).css("color", "#776e2c");
    }else{
        $('#partext'+par_id).css("color", "#000");
    }
}

function checkselectedpar(par_id,child_id){
    if($('.checkchild'+par_id+':checked').length >0){
        $('#par'+par_id).prop("checked", true);
    }else{
        $('#par'+par_id).prop("checked", false);
    }
    checkcolor(par_id);
}

function checkselected(par_id,child_id){
    if($('.tinycheck'+child_id+':checked').length >0){
        $("#child"+child_id).prop("checked", true);
    }else{
        $("#child"+child_id).prop("checked", false);
    }
    checkselectedpar(par_id,child_id);
}

function checkallin(par_id) {
    if ($('#par'+par_id).is(':checked')){
        $(".checkchild"+par_id).prop("checked", true);
    }else{
        $(".checkchild"+par_id).prop("checked", false);
    }
    checkcolor(par_id);
}

function checktiny(par_id,child_id) {
    if ($('#child'+child_id).is(':checked')){
        $(".tinycheck"+child_id).prop("checked", true);
    }else{
        $(".tinycheck"+child_id).prop("checked", false);
    }
    checkselectedpar(par_id,child_id);
}

function addsuppliersbtn() {
    $('.products').select2("destroy");

    var row = $("#tab_items tr").last().clone().find('input').val('').end();
    var oldId = Number(row.attr('id').slice(-1));
    var id = 1 + oldId;
    row.attr('id', 'row-' + id);
    row.find('#products-' + oldId).attr('id', 'products-' + id);
    $('.products').select2({width: 500});
    $('#tab_items').append(row);
}


function add_company() {
    $('.companies').select2("destroy");

    var row = $("#tab_companies tr").last().clone().find('input').val('').end();
    var oldId = Number(row.attr('id').slice(-1));
    var id = 1 + oldId;
    row.attr('id', 'row-' + id);
    row.find('#companies-' + oldId).attr('id', 'companies-' + id);
    $('.companies').select2({width: 500});

    $('#tab_companies').append(row);
}

$(document).on('click', '.overflow_inner', function () {
    document.getElementById("myNavTwo").style.width = "0";
    document.getElementById("myNavTwo").style.opacity = "0";
    document.getElementById("myNavTwo").style.right = "0";
    $('.page-inner').css("right", "0");
    document.getElementById("whenopenmobileR").style.display = "block";
    document.getElementById("whenclosemobileR").style.display = "none";
    $('body').css("overflow", "auto");
    $('.menu-two').css("right", "-60px");
    $('.overflow_inner').css("display", "none");
});

$(document).on('click', '.overflow_inner_desktop', function () {
    $('body').css("overflow-y", "auto");
    $('.overflow_inner_desktop').css("display", "none");
    document.getElementById("nfnav").style.left = "-400px";
    document.getElementById("whenopen").style.display = "block";
    document.getElementById("whenclose").style.display = "none";
});

function show_time() {
    document.getElementById("tabel_time").style.display = "block";
};

function close_first() {
    $.ajax({
        url: siteUrl + "/welcome_message", success: function (result) {
            if (result == 1) {
                $('.fisrt_message').css("display", "none");
            }
        }
    });
};

$('li.dropdown.mega-dropdown a').on('click', function (event) {
    $(this).parent().toggleClass('open');
});

$('body').on('click', function (e) {
    if (!$('li.dropdown.mega-dropdown').is(e.target)
        && $('li.dropdown.mega-dropdown').has(e.target).length === 0
        && $('.open').has(e.target).length === 0
    ) {
        $('li.dropdown.mega-dropdown').removeClass('open');
    }
});

$(document).on('click', '.open-modal', function () {
    jQuery('#open-modal').modal('show', {backdrop: 'true'});
    $.ajax({
        url: siteUrl + '/admin/ajax/categories_modal/1',
        success: function (response) {
            jQuery('#open-modal .modal-body').html(response);
        }
    });
    return false;
});


$(document).on('click', '.open-modal-2', function () {
    jQuery('#open-modal').modal('show', {backdrop: 'true'});
    $.ajax({
        url: siteUrl + '/admin/ajax/categories_modal/2',
        success: function (response) {
            jQuery('#open-modal .modal-body').html(response);
        }
    });
    return false;
});

$(document).on('click', '.open-modal-3', function () {
    jQuery('#open-modal').modal('show', {backdrop: 'true'});
    $.ajax({
        url: siteUrl + '/admin/ajax/price_modal',
        success: function (response) {
            jQuery('#open-modal .modal-body').html(response);
        }
    });
    return false;
});

$('#add_customer_submit').click(function () {
    $("#add_customer_store").ajaxForm({
        url: siteUrl + '/admin/ajax/add_customer', type: 'post',
        beforeSubmit: function (response) {
            /*if (iti.isValidNumber() == false) {
                alert("Please check your phone again");
                return false;
            }*/
        },
        success: function (response) {
            $('#addclient').modal('toggle');
            if (lang == 'ar') {
                $("#customers").append("<option value='" + response.data.id + "'>" + response.data.name + "</option>");
            } else {
                $("#customers").append("<option value='" + response.data.id + "'>" + response.data.name_en + "</option>");
            }
        },
        error: function (response) {
            alert("Please check your entry date again");
        }
    })
});
$('#add_section_submit').click(function () {
    $("#add_section_store").ajaxForm({
        url: siteUrl + '/admin/ajax/add_section', type: 'post',
        success: function (response) {
            $('#add_section').modal('toggle');
            if (lang == 'ar') {
                $("#sections").append("<option value='" + response.data.id + "'>" + response.data.name + "</option>");
            } else {
                $("#sections").append("<option value='" + response.data.id + "'>" + response.data.name_en + "</option>");
            }
        },
        error: function (response) {
            alert("Please check your entry date again");
        }
    })
});

$("#customers").change(function () {
    if (this.value == 0) {
        $('.btn-sizes').attr('disabled', 'disabled');
    } else {
        $('#customer_id').val(this.value);
        $.get(siteUrl + "/admin/ajax/measure_list/" + this.value, function (response) {
            if (response.status == 200) {
                $('#measures-table > tbody').empty();
                $.each(response.data, function (index, value) {
                    var markup = "<tr> <input name='ids[]' type='hidden' value='" + value.id + "'> <td>" + value.name + "</td> <td><input type='number' name='values[]' step='any'  value='" + value.measure_val + "'></td> <td>" + value.description + "</td> </tr>";
                    $('#measures-table').append(markup);
                });

            } else {
                alert("Please check your entry date again");
            }
        });
        $('.btn-sizes').removeAttr('disabled');
    }
});

$("#categories_types_select").change(function () {
    $.get(siteUrl + "/admin/price_list/get-categories/" + this.value, function (data) {
        $("#categories").empty();
        if (lang == 'ar') {
            $("#categories").append("<option value='0'>اختر</option>");
        } else {
            $("#categories").append("<option value='0'>Select</option>");
        }
        $.each(data, function (key, value) {
            if (lang == 'ar') {
                $("#categories").append("<option value='" + value.id + "'>" + value.name + "</option>");
            } else {
                $("#categories").append("<option value='" + value.id + "'>" + value.name_en + "</option>");
            }
        });
    });
});
$("#tax_type").change(function () {
    if (this.value == 1) {
        $('.value').show();
        $('#tax-value').attr("required");
        $('#tax-percent').removeAttr("required");
        $('.percent').hide();
    } else if (this.value == 2) {
        $('.percent').show();
        $('#tax-percent').attr("required");
        $('#tax-value').removeAttr("required");
        $('.value').hide();
    } else {
        $('.value').hide();
        $('.percent').hide();
        $('#tax-percent').removeAttr("required");
        $('#tax-value').removeAttr("required");

    }
});
$("#type_cloths").change(function () {
    $.get(siteUrl + "/admin/price_list/get-categories/" + this.value, function (data) {
        $("#cloth_id").empty();
        if (lang == 'ar') {
            $("#cloth_id").append("<option value='0'>اختر</option>");
        } else {
            $("#cloth_id").append("<option value='0'>Select</option>");
        }
        $.each(data, function (key, value) {
            if (lang == 'ar') {
                $("#cloth_id").append("<option value='" + value.id + "'>" + value.name + "</option>");
            } else {
                $("#cloth_id").append("<option value='" + value.id + "'>" + value.name_en + "</option>");
            }
        });
    });
});
$("#categories").change(function () {
    if (this.value != 0) {
        $.get(siteUrl + "/admin/offers/get-price/" + this.value, function (data) {
            if (data.price == null) {
                if (lang == 'ar') {
                    alert("هذا البند ليس له سعر لا يمكن اضافته فى الطلب");
                } else {
                    alert("This item has no price that cannot be added to the request')");
                }
                $('.deal_price').val('0');
                $('.tax_val').val('0');
                $('.final_price').val('0');
            }
            $('.deal_price').val(data.price);
            if (data.tax_value <= 100) {
                var tax = parseFloat(data.tax_value) / 100 * data.price;
            } else {
                var tax = data.tax_value;
            }
            $('.tax_val').val(tax);
            $('.final_price').val(data.price + tax);

            $("#cloth_id").val(data.cloth_id);
        });
    }
});
$('#add_categories_types_submit').click(function () {
    $("#add_categories_types_store").ajaxForm({
        url: siteUrl + '/admin/ajax/categories_type', type: 'post',
        success: function (response) {
            $('#add_categories_types').modal('toggle');
            if (lang == 'ar') {
                $("#categories_types_select").append("<option value='" + response.data.id + "'>" + response.data.name + "</option>");
            } else {
                $("#categories_types_select").append("<option value='" + response.data.id + "'>" + response.data.name_en + "</option>");
            }
        },
        error: function (response) {
            alert("Please check your entry date again");
        }
    })
});

$('#add_categories_types_submit_2').click(function () {
    $("#add_categories_types_store_2").ajaxForm({
        url: siteUrl + '/admin/ajax/categories_type', type: 'post',
        success: function (response) {
            $('#add_categories_types_2').modal('toggle');
            if (lang == 'ar') {
                $("#type_cloths").append("<option value='" + response.data.id + "'>" + response.data.name + "</option>");
            } else {
                $("#type_cloths").append("<option value='" + response.data.id + "'>" + response.data.name_en + "</option>");
            }
        },
        error: function (response) {
            alert("Please check your entry date again");
        }
    })
});

$('#add_categories_submit').click(function () {
    $("#add_categories_store").ajaxForm({
        url: siteUrl + '/admin/ajax/add_categories', type: 'post',
        success: function (response) {
            $('#add_categories').modal('toggle');
            if (lang == 'ar') {
                $("#categories").append("<option value='" + response.data.id + "'>" + response.data.name + "</option>");
            } else {
                $("#categories").append("<option value='" + response.data.id + "'>" + response.data.name_en + "</option>");
            }
        },
        error: function (response) {
            alert("Please check your entry date again");
        }
    })
});

$('#add_categories_submit_2').click(function () {
    $("#add_categories_store_2").ajaxForm({
        url: siteUrl + '/admin/ajax/add_categories', type: 'post',
        success: function (response) {
            $('#add_categories_2').modal('toggle');
            if (lang == 'ar') {
                $("#cloth_id").append("<option value='" + response.data.id + "'>" + response.data.name + "</option>");
            } else {
                $("#cloth_id").append("<option value='" + response.data.id + "'>" + response.data.name_en + "</option>");
            }
        },
        error: function (response) {
            alert("Please check your entry date again");
        }
    })
});


$('#add-measure-submit').click(function () {
    $("#add-measure").ajaxForm({
        url: siteUrl + '/admin/ajax/add_measure/', type: 'post',
        success: function (response) {
            if (response.status == 400) {
                alert(response[0].date)
            }
            if (response.status == 200) {
                $('.measure-name').val('');
                $('.measure-name-en').val('');
                $('.measure-description').val('');

                var markup = "<tr> <input name='ids[]' type='hidden' value='" + response.data.id + "'> <td>" + response.data.name + "</td> <td><input type='number' name='values[]' step='any'  value=''></td> <td>" + response.data.description + "</td> </tr>";
                $('#measures-table').append(markup);
                $('#addsizes').modal('toggle');
                $('#sizes').modal('show');
            }
        },
        error: function (response) {
            alert("Please check your entry date again");
        }
    })
});

$('#measures-submit').click(function () {
    $("#measures").ajaxForm({
        url: siteUrl + '/admin/ajax/update_measures', type: 'post',
        success: function (response) {
            if (response.status == 200) {
                alert('تم الحفظ بنجاح')
            }
        },
        error: function (response) {
            alert("Please check your entry date again");
        }
    })
});
$("#categories").change(function () {
    $.get(siteUrl + "/admin/offers/get-price/" + this.value, function (data) {
        //$.each(data, function (key, value) {
        $("#org-price").val(data.price);
        if (data.tax_value == null) {
            $("#org-tax").val(0);
            if (lang == 'ar') {
                $("#tax").html("<li>قيمه الضريبة  : " + 0 + "</li>");
            } else {
                $("#tax").html("<li>Tax value  : " + 0 + "</li>");
            }

        } else {
            $("#org-tax").val(data.tax_value);
            if (lang == 'ar') {
                $("#tax").html("<li>قيمه الضريبة  :" + data.tax_value + "</li>");
            } else {
                $("#tax").html("<li>Tax value  :" + data.tax_value + "</li>");
            }

        }
        //});
        if (data == '') {
            if (lang == 'ar') {
                alert("البند ليس له سعر")
            } else {
                alert("Item has no price")
            }
        }
    });

});

$.get(siteUrl + "/admin/offers/get-categories/" + $('#select_categories_types').val(), function (data) {
    $("#categories").empty();
    if (lang == 'ar') {
        $("#categories").append("<option value='0'>اختر</option>");
    } else {
        $("#categories").append("<option value='0'>Select</option>");
    }
    $.each(data, function (key, value) {
        if (lang == 'ar') {
            $("#categories").append("<option value='" + value.id + "'>" + value.name + "</option>");
        } else {
            $("#categories").append("<option value='" + value.id + "'>" + value.name_en + "</option>");
        }
    });
    $("#categories").val($("#select_categories").val());
});


$("#categories_types").change(function () {
    $("#select_categories_types").val(this.value);
});

$("#categories").change(function () {
    $("#select_categories").val(this.value);
});

$("#categories_types_offers").change(function () {
    $.get(siteUrl + "/admin/offers/get-categories/" + this.value, function (data) {
        $("#categories").empty();
        if (lang == 'ar') {
            $("#categories").append("<option value='0'>اختر</option>");
        } else {
            $("#categories").append("<option value='0'>Select</option>");
        }
        $.each(data, function (key, value) {
            if (lang == 'ar') {
                $("#categories").append("<option value='" + value.id + "'>" + value.name + "</option>");
            } else {
                $("#categories").append("<option value='" + value.id + "'>" + value.name_en + "</option>");
            }
        });
        if (lang == 'ar') {
            alert("فى حالة عدم اختيار بند يتم اضافة العرض على جميع بنود هذه الفئة");
        } else {
            alert("فى حالة عدم اختيار بند يتم اضافة العرض على جميع بنود هذه الفئة");
        }
    });
});

/*$("#discount_value").change(function () {
    if(parseFloat($('#org-tax').val()) <= 100){
        var tax = parseFloat($('#org-tax').val()) / 100 * (parseFloat($('#org-price').val()) - parseFloat($('#discount_value').val()) / 100 * parseFloat($('#org-price').val()));
    }else{
        var tax = parseFloat($('#org-tax').val());
    }
    if($("#discount_type").val() == 1){
        $("#discount").html("<li>@lang('strings.Discount')  : % " +  parseFloat($('#discount_value').val()) + "</li>");
        $("#discount-price").html("<li>@lang('strings.Discount_price')  :" +  (parseFloat($('#org-price').val()) - parseFloat($('#discount_value').val()) / 100 * parseFloat($('#org-price').val())).toFixed(2)  + "</li>");
        $("#offer-price").html("<li>@lang('strings.Offer_price')  :" +  ((parseFloat($('#org-price').val()) - parseFloat($('#discount_value').val()) / 100 * parseFloat($('#org-price').val()))  +  tax).toFixed(2) + "</li>");
    }else{
        $("#discount").html("<li>@lang('strings.Discount')  :" +  parseFloat($('#discount_value').val()) + "</li>");
        $("#discount-price").html("<li>@lang('strings.Discount_price')  :" +  (parseFloat($('#org-price').val()) - parseFloat($('#discount_value').val())).toFixed(2)  + "</li>");
        $("#offer-price").html("<li>@lang('strings.Offer_price')  :" +  ((parseFloat($('#org-price').val()) - parseFloat($('#discount_value').val())) +  tax).toFixed(2) + "</li>");
    }
});*/

$("#discount_type").change(function () {
    if (this.value == 1 || this.value == 2) {
        $("#discountsss").show();
    } else {
        $("#discountsss").hide();
    }
});
$("#paid").change(function () {
    if (this.value == 1) {
        $('.cloth_qty').show();
    } else {
        $('.cloth_qty').hide();
    }
});

$('#pay_method').change(function () {
    if (this.value == 1) {
        $('#treasure').show();
        $('#banks').hide();
    } else if (this.value == 2) {
        $('#treasure').hide();
        $('#banks').show();
    } else {
        $('#banks').hide();
        $('#treasure').hide();
    }
});
/*$(document).on('change', '#tab_logic tbody tr input', function () {
    var id = this.id.split('-')[1];
    if($('#products-' + id + ' :selected').val() != 0) {
        $.get(siteUrl + "/admin/transactions/store-quantity/" + $('#products-' + id + ' :selected').val() + '/' + parseFloat($('#qty-' + id).val()), function (data) {
            if (data != 'false') {
                if(lang == 'ar'){
                    alert("لاتوجد هذه الكمية فى المخزن");
                }else{
                    alert("This quantity is not in stock");
                }
            }
        });
    }
});*/

$(document).on('click', '.delete_row', function () {
    if ($('#tab_logic tbody tr').length != 1 && $(this).closest('tr').attr('id') != 'row-1') {
        $(this).closest('tr').remove();
        return false;
    }
});

/*
function invoices(id) {
    if($('#products-'+ id + ' :selected').val() != 0) {
        if ($('.type').val() == 1) {
            var dataString = 'product_id=' + $('#products-' + id + ' :selected').val() + '&transaction_id=' + $('#head_id').val();

            $.ajax({
                type: "POST",
                url: siteUrl + "/admin/transactions/transactions-item-price",
                data: dataString,
                cache: false,
                success: function (data) {
                    if (data.price == null) {
                        if(lang == 'ar'){
                            alert("هذا البند ليس موجود فى الطلب");
                        }else{
                            alert("This item is not in the request");
                        }
                    }
                    $('.price_item-' + id).val(data.price);
                    $('.total_tax_' + id).val(data.tax_value);
                    $('.tax_id_' + id).val(data.tax_id);
                    calculation();
                }
            });

        } else {
            var dataString = 'product_id=' + $('#products-' + id + ' :selected').val();

            $.ajax({
                type: "POST",
                url: siteUrl + '/admin/transactions/item-details',
                data: dataString,
                cache: false,
                success: function (data) {
                    if (data.length == 0) {
                        if(lang == 'ar'){
                            alert("هذا البند ليس له سعر لا يمكن اضافته فى الطلب");
                        }else{
                            alert("This item has no price that cannot be added to the request");
                        }
                    } else if (data[0].price == null) {
                        if(lang == 'ar'){
                            alert("هذا البند ليس له سعر لا يمكن اضافته فى الطلب");
                        }else{
                            alert("This item has no price that cannot be added to the request");
                        }
                    } else {
                        $('.price_item-' + id).val(data[0].price);
                        $('.total_tax_' + id).val(data[0].tax_value);
                        $('.tax_id_' + id).val(data[0].tax_id);
                        calculation();
                    }
                }
            });
        }

    }
}*/

function _open_assign(id, that) {
    $td_edit = $(that);
    jQuery('#modal_view_password').modal('show', {backdrop: 'true'});
    $.ajax({
        url: siteUrl + '/admin/measures/assign/' + id + '/list',
        success: function (response) {
            jQuery('#modal_view_password .modal-body').html(response);
        }
    });
}

function _openss(id, that) {
    $td_edit = $(that);
    jQuery('#modal_view_password').modal('show', {backdrop: 'true'});
    $.ajax({
        url: siteUrl + '/admin/measures/assign/' + id + '/list',
        success: function (response) {
            jQuery('#modal_view_password .modal-body').html(response);
        }
    });
}

$(function () {
    enable_shift_row = function ($this) {

        if ($this.prop("checked") == true) {

            $this.parents('.shift-row').find('.timepicker').prop('disabled', false);
            $this.parents('.shift-row').find('.timepicker').prop('required', true);
        } else {

            $this.parents('.shift-row').find('.timepicker').prop('disabled', true);
            $this.parents('.shift-row').find('.timepicker').prop('required', false);
        }
    }
    $('.shift-day').each(function () {
        enable_shift_row($(this));
    })

    $('.shift-day').on('click', function () {
        enable_shift_row($(this));
    });


})


$("#date").change(function () {
    $check = validateDate();
    if ($check === false) {
        $('#times').empty();

        if ($('span.help-block.date-error').css('display') == 'none') {
            $('span.help-block.date-error').css({"display": "block"});
            $('span.help-block.date-error2').css({"display": "none"});
            $('.panel .panel-white').css({"display": "none"});
        }
        return;
    } else {

        $('span.help-block.date-error').css({"display": "none"});
        $('span.date-captain-error').css({"display": "none"});
        var captainElement = document.getElementById('captain');
        var captainID = captainElement.options[captainElement.selectedIndex].value;

        var dateElement = document.getElementById('date').value;
        $.get("/admin/reservations/captains/" + captainID + "/" + this.value, function (data) {
            $("#time").empty();


            timeSlotsHtml = '';
            console.log(data);
            if (!Object.keys(data).length >= 1) {
                $('#times2').empty();
                if ($('span.help-block.date-error2').css('display') == 'none') {
                    $('span.help-block.date-error2').css({"display": "block"});
                    $('.panel .panel-white').css({"display": "none"});
                }
                return;

            } else {
                $('span.help-block.date-error2').css({"display": "none"});
                $('span.date-captain-error2').css({"display": "none"});
                var j = 0;
                $.each(data, function (key, value) {
                    if (j == 0) {
                        timeSlotsHtml += `<li class="staff-time">
                                               <input   class='start-time' type="radio" name="time" value="${key}" checked> <span>${value}</span>
                                         </li>`;
                    } else {
                        timeSlotsHtml += `<li class="staff-time">
                                               <input   class='start-time' type="radio" name="time" value="${key}" > <span>${value}</span>
                                         </li>`;
                    }

                    $('#times2').html(timeSlotsHtml);
                    j++;
                });
            }

        });
    }

});
    
  
     