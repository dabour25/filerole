/* slider js */
$('#sliderHome').owlCarousel({
    loop:true,
    navText: [
    "<span class='thin-arrows ta__prev'></span>",
    "<span class='thin-arrows ta__next'></span>"
    ],
    animateOut: 'slideOutLeft',
    animateIn: 'slideInRight',
    autoplay:true,
    autoplayTimeout:10000,
    nav:true,
    loop: false,
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

$('#sliderSeller').owlCarousel({
    loop:true,
    margin:30,
    navText: [
    "<span class='thin-arrows ta__prev'></span>",
    "<span class='thin-arrows ta__next'></span>"
    ],
    animateOut: 'slideOutLeft',
    animateIn: 'slideInRight',
    autoplay:true,
    autoplayTimeout:8000,
    nav:true,
    loop: false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:4
        }
    }
});

$('#slider_News').owlCarousel({
    loop:true,
    margin:30,
    navText: [
    "<span class='thin-arrows ta__prev'></span>",
    "<span class='thin-arrows ta__next'></span>"
    ],
    animateOut: 'slideOutLeft',
    animateIn: 'slideInRight',
    autoplay:true,
    autoplayTimeout:8000,
    nav:true,
    loop: false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:4
        }
    }
});

/* dropdown */
$('ul li.dropdown').hover(function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(30).fadeIn(150);
}, function() {
  $(this).find('.dropdown-menu').stop(true, true).delay(30).fadeOut(200);
});


/* search */
function showsearch() {
    document.getElementById("search_container").style.display = "block";
    document.getElementById("close_search").style.display = "block";
    document.getElementById("open_search").style.display = "none";
};

function closesearch() {
    document.getElementById("search_container").style.display = "none";
    document.getElementById("open_search").style.display = "block";
    document.getElementById("close_search").style.display = "none";
};

/* login */
function showLogin() {
    document.getElementById("login").style.display = "block";
    $('body').css("overflow","hidden");
};
function closeLogin() {
    document.getElementById("login").style.display = "none";
    $('body').css("overflow","auto");
};

/* register */
function showReg() {
    document.getElementById("register").style.display = "block";
    $('body').css("overflow","hidden");
};
function closeReg() {
    document.getElementById("register").style.display = "none";
    $('body').css("overflow","auto");
};
function showfromreg() {
    document.getElementById("register").style.display = "none";
    document.getElementById("login").style.display = "block";
    $('body').css("overflow","hidden");
};

/* forgot password */
function showforgot() {
    document.getElementById("login").style.display = "none";
    document.getElementById("forgot").style.display = "block";
    $('body').css("overflow","hidden");
};
function closeforgot() {
    document.getElementById("forgot").style.display = "none";
    $('body').css("overflow","auto");
};
function showfromgot() {
    document.getElementById("forgot").style.display = "none";
    document.getElementById("login").style.display = "block";
    $('body').css("overflow","hidden");
};

/* navbar */
function openNav() {
    $('.nav-bar').css("width","238px");
    $('.for_menu').css("marginRight","238px");
    $('.for_menu_over').css("display","block");
    $('body').css("overflow","hidden");
    
};
function closeNav() {
    $('.nav-bar').css("width","0");
    $('.for_menu').css("marginRight","0");
     $('.for_menu_over').css("display","none");
     $('body').css("overflow","auto");
};

$(document).on('click','.for_menu_over',function(){
    $('.nav-bar').css("width","0");
    $('.for_menu').css("marginRight","0");
     $('.for_menu_over').css("display","none");
     $('body').css("overflow","auto");
});

/* cart */
function addCart() {
    document.getElementById("success_cart").style.display = "block";
};
function closeCart() {
    document.getElementById("success_cart").style.display = "none";
};

/* more news */
function showNews() {
    document.getElementById("news_desk").style.display = "block";
};
function closeNews() {
    document.getElementById("news_desk").style.display = "none";
};