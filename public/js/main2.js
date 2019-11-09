/* slider js */
    $('#sliderHome').owlCarousel({
        loop:true,
        animateOut: 'fadeOutDown',
        animateIn: 'flipInX',
        margin:10,
        autoplay:true,
        autoplayTimeout:5000,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });
    /* slider about */
    $('#sliderNews').owlCarousel({
        loop:true,
        margin:10,
        autoplay:true,
        autoplayTimeout:5000,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });


    /* go to top js */
        window.onscroll = function() {myFunction()};

        var header = document.getElementById("myHeader");
        var sticky = header.offsetTop;

        function myFunction() {
          if (window.pageYOffset > sticky) {
            header.classList.add("sticky");
          } else {
            header.classList.remove("sticky");
          }
        };

    /*Scroll to top when arrow up clicked BEGIN*/
    $(window).scroll(function() {
        var height = $(window).scrollTop();
        if (height > 300) {
            $('#back2Top').fadeIn();
    } else {
            $('#back2Top').fadeOut();
        }
    });
    $(document).ready(function() {
        $("#back2Top").click(function(event) {
            event.preventDefault();
            $("html, body").animate({ scrollTop: 0 }, "");
            return false;
        });

    });
    /*Scroll to top when arrow up clicked END*/


    /* loading screen  js */
      $(window).on('load', function(){

            "use strict";

            // Loading Elements

            $(".loading-overlay .all-spi").fadeOut(1000, function () {

                            // Show The Scroll

                $("body").css("overflow-y", "auto");

                $(this).parent().fadeOut(1000, function () {

                    $(this).remove();
                });
            });
        });

        /* navbar js */

        function openSet() {
            document.getElementById("navSet").style.width = "100%";
            document.getElementById("navSet").style.borderRadius = "0";
            document.getElementById("navSet").style.height = "100%";
            document.getElementById("navSet").style.opacity = "1";
            document.getElementById("navSet").style.zIndex = "9999999";
            document.getElementById("whenO").style.display = "none";
            document.getElementById("whenC").style.display = "block";
            document.getElementById("navMenu").style.opacity = "0";
            document.getElementById("whenOnav").style.display = "block";
            document.getElementById("whenCnav").style.display = "none";
        };

        function CloseSet() {
            document.getElementById("navSet").style.width = "70%";
            document.getElementById("navSet").style.borderRadius = "50%";
            document.getElementById("navSet").style.height = "70%";
            document.getElementById("navSet").style.opacity = "0";
            document.getElementById("navSet").style.zIndex = "-1";
            document.getElementById("whenO").style.display = "block";
            document.getElementById("whenC").style.display = "none";
        };

        function openNav() {
            document.getElementById("navMenu").style.width = "100%";
            document.getElementById("navMenu").style.borderRadius = "0";
            document.getElementById("navMenu").style.height = "100%";
            document.getElementById("navMenu").style.opacity = "1";
            document.getElementById("navMenu").style.zIndex = "9999999";
            document.getElementById("whenOnav").style.display = "none";
            document.getElementById("whenCnav").style.display = "block";
            document.getElementById("navSet").style.opacity = "0";
            document.getElementById("whenO").style.display = "block";
            document.getElementById("whenC").style.display = "none";
        };

        function CloseNav() {
            document.getElementById("navMenu").style.width = "70%";
            document.getElementById("navMenu").style.borderRadius = "50%";
            document.getElementById("navMenu").style.height = "70%";
            document.getElementById("navMenu").style.opacity = "0";
            document.getElementById("navMenu").style.zIndex = "-1";
            document.getElementById("whenOnav").style.display = "block";
            document.getElementById("whenCnav").style.display = "none";
        };
        function closeMessage() {
            document.getElementById("messageWelcome").style.opacity = "0";
            document.getElementById("messageWelcome").style.zIndex = "-1";
            document.getElementById("itemMessage").style.width = "5%";
        };
        /* js for select work type */
          
