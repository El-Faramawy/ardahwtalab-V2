window.onload = function () {
    // Animate loader off screen


    $(".loader").fadeOut(500, function () {
        $(this).parent().hide();
        $('body, html').css("overflow", "auto");
        $('html, body').animate({
            scrollTop: 0
        }, 1);
    });

    // function fix_slider_img_height() {
    //     var x = $(".main-slider").height()
    //     $("#mappy").height(x);
    // }
    // $('.main-slider').on("initialized.owl.carousel", fix_slider_img_height);
    // $('.main-slider').on("resized.owl.carousel", fix_slider_img_height);
    $('.selectpicker').selectpicker({
        dropupAuto: false
    });
}
$(document).ready(function () {
    $(".navbar-sec").remove();
    $('.selectpicker').selectpicker({
        dropupAuto: false
    });
    // $('.megaxs-link').click(function () {
    //     $(this).children('.level2').toggleClass('enter1')
    // });
    // $('.back').click(function () {
    //     $('.level2').removeClass('enter1')
    // });

    var attdata = 1;

    $('.megaxs-link').click(function () {
        $(this).children('.level2').toggleClass('enter1')
        attdata += 1;
        $('.back').attr("data-remove", attdata);
        // console.log(456)
    });


    $('.back').click(function () {
        var y = $('.back').attr("data-remove");
        if (y == attdata) {
            // console.log("[data-id='" + attdata + "']");

            //$('#' + attdata).removeClass('enter1');
            $("[data-id='" + attdata + "']").removeClass('enter1');

        }
        attdata -= 1;
        $('.back').attr("data-remove", attdata);
    });

    $('.seemore').click(function () {
        var x = $(this).attr('id');
        $("ul." + x).css("max-height", "none");
        $(this).hide();

    });
    $('.mega-menu-btn').click(function () {
        $('.mega-menu-btn').removeClass('link-active')
        $(this).addClass('link-active')
        $('.megamenu-cont').removeClass('megafade')
        $(this).children('.megamenu-cont').addClass('megafade')
        $('.overlay').toggle();
        if ($(".megamenu-cont").hasClass("megafade")) {
            $('.overlay').show();
        }

    });
    $('.overlay').click(function () {
        $('.mega-menu-btn').removeClass('link-active')
        $('.megamenu-cont').removeClass('megafade')
        $('.overlay').toggle();
    });
    if ($(window).width() <= 767) {
        $('.search-ico').addClass("after-none");
    }
    $('.search-ico').click(function () {
        $('.sec-bar-sec').stop().slideToggle(500);
        $('.search-ico').toggleClass("after-none");
    });
    $('.add-report').click(function () {
        $('.report-form').stop().slideToggle(500);
        $('.add-report').toggleClass("report-open");
    });

    $('.menu-ico').click(function () {
        $('.xs-nav').show();
        $('.main-xs-nav').addClass('inscreen');
        $('.main-xs-nav').removeClass('outscreen');
        $('body').toggleClass('overfolow')
        $('html').toggleClass('overfolow')
    });
    $('.xs-nav').click(function () {
        $('.xs-nav').fadeOut(500);
        $('.main-xs-nav').addClass('outscreen');
        $('.main-xs-nav').removeClass('inscreen');
        $('body').toggleClass('overfolow')
        $('html').toggleClass('overfolow')
        $('.level2').removeClass('enter1')
    });
    $(".main-xs-nav").click(function (e) {
        e.stopPropagation();
    });
    $('.closebtn').click(function () {
        $('.xs-nav').fadeOut(500);
        $('.main-xs-nav').addClass('outscreen');
        $('.main-xs-nav').removeClass('inscreen');
        $('body').toggleClass('overfolow')
        $('html').toggleClass('overfolow')
    });

    $('.filters-btn').click(function () {
        $('.filters-cont').toggleClass('enter1')
        $(this).toggleClass('filter-btn-transform').css("z-index", "99999")
        $(".overlay").toggle().css("z-index", "9999")
        $('body').toggleClass('overfolow')
        $('html').toggleClass('overfolow')
    });
    $('.overlay').click(function () {
        if ($(window).width() <= 991) {
            $('.filters-cont').removeClass('enter1')
            $('.filters-btn').removeClass('filter-btn-transform')
            $('body').toggleClass('overfolow')
            $('html').toggleClass('overfolow')
        }

    });
    if ($(window).width() <= 767) {


        $(".cat-nav-links-header").addClass("mo-accordion");
        $(".cat-links").addClass("mo-panel");
    }
    if ($(window).width() <= 991) {
        $(".table-title").addClass("mo-accordion");
        $(".table-cont").addClass("mo-panel");
    }
    var acc = document.getElementsByClassName("mo-accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function () {
            this.classList.toggle("mo-active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        });
    }

    // function fix_slider_img_height() {
    //     var x = $(".main-slider").height()
    //     $("#mappy").height(x);
    // }
    // $('.main-slider').on("initialized.owl.carousel", fix_slider_img_height);
    // $('.main-slider').on("resized.owl.carousel", fix_slider_img_height);
    $('.main-slider').owlCarousel({
        items: 1,
        autoplay: false,
        margin: 10,
        rtl: true,
        loop: false,
        rewind: true,
        nav: true,
        dots: false,
        navText: ["<i class='fas fa-chevron-right'></i>", "<i class='fas fa-chevron-left'></i>"],
        responsive: {
            0: {
                dots: false,
                nav: false,
            },
            500: {
                dots: false,
                nav: false,

            },
            768: {
                dots: false,
                nav: true,
            },
        }
    });
    //map
    var adresse = "<img style='width:50px; text-align: left; display:inline-block; margin-right: 10px; vertical-align: sub;' src='img/logofooter.png'> <div style='display:inline-block;'>Blackstone<br>0540000000<br>info@blackstone.sa</div>";


    var location = [adresse[0], $("#mappy").attr("lat"), $("#mappy").attr("long")];
    var myLatLng = new google.maps.LatLng($("#mappy").attr("lat"), $("#mappy").attr("long"))
    var map = new google.maps.Map(document.getElementById('mappy'), {
        zoom: 11,
        center: myLatLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoomControl: false,
        fullscreenControl: false
    });

    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map
    });

    ////////////////////////////////////////////
    $('.checkmark').click(function () {
        var x = $(this).attr('id');
        $('input[name=radio]').removeAttr('checked');
        $('input' + '#' + x).attr("checked", "checked");
    });
});


$('.list').click(function () {
    $('.post-view').removeClass('col-sm-6');
    $('.post-view').removeClass('col-md-4');
    $('.post-cont').removeClass('post-linear');
    $('.post-cont').addClass('post-list');
    $('.grid').removeClass('view-active');
    $('.list').addClass('view-active');
    localStorage.setItem('listtype', 'list');

});
$('.grid').click(function () {
    $('.post-view').addClass('col-sm-6');
    if ($('.filter-cont').length == 0) {
        $('.post-view').addClass('col-md-4');
    }
    $('.post-cont').removeClass('post-list').removeClass('post-linear');
    $('.chooseBtns-grid i').removeClass('view-active');
    $('.grid').addClass('view-active');
    localStorage.setItem('listtype', 'grid');
});

$('.linear').click(function () {
    $('.post-view').removeClass('col-sm-6');
    // alert('cssfs');
    $('.post-cont').addClass('post-linear').removeClass('post-list');
    $('.chooseBtns-grid i').removeClass('view-active');
    $('.linear').addClass('view-active');
    localStorage.setItem('listtype', 'linear');
});
// console.log(455)
$('.mopanel .moaccordion').addClass("moaccordion1");
$('.mopanel .moaccordion1').removeClass("moaccordion")
$('.moaccordion').click(function () {
    var x = $(this).siblings().prop('scrollHeight') + "px";
    $(".moaccordion").not(this).removeClass("active");
    $(this).addClass("active");
    $(this).siblings().css('max-height', "100%");
    $(".moaccordion").not(this).siblings().css('max-height', '0');

    if (!($(this).siblings().css('max-height') == '0px')) {
        $(this).siblings().css('max-height', '0');
    }
    // console.log("acc")
})


$('.moaccordion1').click(function () {
    var x = $(this).siblings().prop('scrollHeight') + "px";
    $(".moaccordion1").not(this).removeClass("active");
    $(this).addClass("active");
    $(this).siblings().css('max-height', "100%");
    $(".moaccordion1").not(this).siblings().css('max-height', '0');

    if (!($(this).siblings().css('max-height') == '0px')) {
        $(this).siblings().css('max-height', '0');
    }
    // console.log("acc1")
})