$(document).ready(function () {

    //------------------------------ xs navbar open close 
    $('.xs-navbar-btn').click(function () {
        var right = $('.xs-navbar').css('right');
        $('.xs-navbar').animate({
            right: '0px'
        });
    });
    $('.xs-navbar-content > i').click(function () {
        $('.xs-navbar').animate({
            right: '-100%'
        });
    });
    $('.xs-navbar').click(function (e) {
        if (e.target.id == 'xs-navbar-id') {
            $('.xs-navbar').animate({
                right: '-100%'
            });
        }
    });

    //-------------------------------------
    $('body').click(function (e) {
        if ($(e.target).attr('id') == 'black-background') {
            $('#places-id').css('z-index', '0');
            $('#categories-id').css('z-index', '0');
            $('#black-background').css('display', 'none');
        }
    })
    $('#places-id , #categories-id').click(function (e) {
        if ($('#black-background').css('display') == 'block') {
            $(this).css('z-index', '0');
            $('#black-background').css('display', 'none');
        } else {
            $(this).css('z-index', '2');
            $('#black-background').css('display', 'block');
        }
    });


    //--------------------------------------- new radio btn
    $('.radio-lable').click(function () {
        if ($(this).hasClass("checked")) {
            //            $(this).children().css('display','none');
        } else {
            $('.radio-lable').children().css('display', 'none');
            $('.radio-lable').removeClass("checked");
            $(this).children().css('display', 'block');
            $(this).addClass("checked");
        }
    })

    //----------------------------------------- upload image preview
    function readURL(input) {
        if (input.files) {
            // console.log();
            $('#def').html('');
            $('.def_text').html('');
            for (var i = 0; i < input.files.length; i++) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.imageLoop').append('<img  src="' + e.target.result + '">');
                };
                reader.readAsDataURL(input.files[i]);
            }

            $('.def_text').append(input.files[0]['name']);
        }
    }

    $("#image-input").change(function () {
        readURL(this);
    });

    //------------------------------------------ post slider 
    // $(document).ready(function() {
    //     $('.pgwSlider').pgwSlider({listPosition : 'left'});

    // });

    //------------------------------------------- change post style
    $("#list-btn").click(function () {
        $("#posts-main-div").removeClass("results-box-style");
        $("#posts-main-div").addClass("results-list-style");
        $("#box-btn").removeClass("active");
        $("#list-btn").addClass("active");
    });
    $("#box-btn").click(function () {
        $("#posts-main-div").removeClass("results-list-style");
        $("#posts-main-div").addClass("results-box-style");
        $("#list-btn").removeClass("active");
        $("#box-btn").addClass("active");
    });



    var cat_iid = " جميع الأقسام";
    $('#categories-id').click(function () {
        var xx = $('#categories-id .dropdown-menu li.selected a span').html();
        if (cat_iid != xx) {
            if (xx != " جميع الأقسام") {
                cat_iid = xx;
                // console.log(xx);
                window.location = '/category/' + xx;
            }
        }
    });
    //==================================//
    //-----------Image Loop-------------//
    //==================================//
    $('#newRow').click(function () {
        var count = jQuery('.form-row').length;
        var image = '<div class="form-row">'
        image += '<div class="label-div">'
        image += '<label class="label-div"></label>'
        image += '<div id="def" class="drf rr' + count + '"><label class="deleteImage"><i class="fas fa-times"></i></label></div>'
        image += '</div>'
        image += '<div class="input-div upload-div">'
        image += '<input id="image-input' + count + '" data="' + count + '" class="af" type="file" name="images[]" accept="image/*">'
        image += '<label for="image-input' + count + '"">'
        image += '<font class="fontss text_image textt' + count + '"></font>'
        image += '<span>اضافة صورة </span>'
        image += '</label>'
        image += '</div>'
        image += '</div>';
        $('#imageLoop').append(image);
    });
    //==================================//
    //----------Image Delete------------//
    //==================================//
    $(document).on('click', '.deleteImage', function () {
        $(this).parent().fadeOut(500, function () {
            $(this).parent().remove();
            var tag = $(this).parent().find('.af').attr('data');
            $('.image-' + tag).remove();
        });
    });

    function imageName(input, cc) {
        var xx = 0;
        if (input.files) {
            $('rr' + cc).html('');
            $('textt' + cc).html('');
            for (var i = 0; i < input.files.length; i++) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    // $('.rr'+cc).html(' ');
                    $('.imageLoop').append('<img class="image-' + cc + '"  src="' + e.target.result + '">');
                };
                reader.readAsDataURL(input.files[i]);
            }
            $('.textt' + cc).html(' ');
            $('.textt' + cc).append(input.files[0]['name']);
        }
        return xx;
    }

    $(document).on('change', '.af', function () {
        var cc = $(this).attr('data');
        // console.log(this);
        imageName(this, cc);
    });



    // $('select.countryfff').change(function () {
    //     var id = $(this).val();
    //     var currentArea = $(this).data('selected-area');
    //     $.get('/get-areas' + '/' + id, function (data) {
    //         var _html = '';
    //         _html += '<option data-hidden="true">اختر المدينة</option>';
    //         $.each(data, function (i, el) {
    //             selected = currentArea === el.id ? ' selected ' : '';
    //             _html += '<option ' + selected + 'value="' + el.id + '">' + el.name + '</option>';
    //         });
    //         $('select.areass').html(_html);
    //         $('.selectpicker').selectpicker('refresh');
    //     });
    // });
    $('select.areass').change(function () {
        var country = $('select.countryfff').val();
        //var area = $(this).val();
    });

    setTimeout(function () {
        if (parseInt($('select.countryfff').val()) !== 0) {
            $('select.countryfff').change();
        }
    });




});