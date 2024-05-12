
$(document).ready(function () {

    $('#navbtn').click(function () {
        $('#mySidenav').addClass('over_mob');
        $('.over_click').addClass('on');
        $('body').addClass('scroll_mob');
    });

    $('.closebtn').click(function () {
        $('#mySidenav').removeClass('over_mob');
        $('.over_click').removeClass('on');
        $('body').removeClass('scroll_mob');
    });

    $('.over_click').click(function () {
        $('.closebtn').trigger('click');
    });

    $('.sidenav .direct').on('click', function () {
        $(this).parent().toggleClass('open').children('.mob_menu').collapse('toggle');
        $(this).parent().siblings().removeClass('open').children('.mob_menu.in').collapse('hide');
    });

    $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});


    $(".mainslider").owlCarousel({
        items: 1,
        autoplay: true,
        rtl: true,
        loop: true,
        nav: true,
        navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"]
    });


    $(".menu").click(function () {
        $(".latest_bans").addClass("listview");
        $(this).addClass("active");
        $(this).siblings().removeClass("active");
    });

    $(".network").click(function () {
        $(".latest_bans").removeClass("listview");
        $(this).addClass("active");
        $(this).siblings().removeClass("active");
    });

    $('#po_slider').owlCarousel({
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        items: 1,
        autoplay: true,
        rtl: true,
        loop: true,
    });

    // 1) ASSIGN EACH 'DOT' A NUMBER
    dotcount = 1;

    $('#po_slider .owl-dot').each(function () {
        $(this).addClass('dotnumber' + dotcount);
        $(this).attr('data-info', dotcount);
        dotcount = dotcount + 1;
    });

    // 2) ASSIGN EACH 'SLIDE' A NUMBER
    slidecount = 1;

    $('#po_slider .owl-item').not('.cloned').each(function () {
        $(this).addClass('slidenumber' + slidecount);
        slidecount = slidecount + 1;
    });

    // SYNC THE SLIDE NUMBER IMG TO ITS DOT COUNTERPART (E.G SLIDE 1 IMG TO DOT 1 BACKGROUND-IMAGE)
    $('#po_slider .owl-dot').each(function () {

        grab = $(this).data('info');

        slidegrab = $('.slidenumber' + grab + ' img').attr('src');
        console.log(slidegrab);

        $(this).css("background-image", "url(" + slidegrab + ")");

    });

    amount = $('#po_slider .owl-dot').length;
    gotowidth = 100 / amount;

    $('#po_slider .owl-dot').css("width", gotowidth + "%");
    newwidth = jQuery('#po_slider .owl-dot').width();
    $('#po_slider .owl-dot').css("height", newwidth + "px");


    setTimeout(function () {
        $('.owl-dots').niceScroll();
    }, 0);

});
