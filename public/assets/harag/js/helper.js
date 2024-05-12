jQuery(document).ready(function () {

    $('.show-list').click(function (event) {
        event.preventDefault();
        var action = $('.list-action').val();
        var id = $(this).data('id');
        var data = {
            id: id
        };
        $('#list-modal').modal('show').find('.modal-body').html('<center><h3><i class="fa fa-cog fa-spin fa-3x fa-fw"></i></h3></center>');
        $.get(action, data, function (msg) {
            $('#list-modal').find('.modal-body').html(msg);
        });
        return false;
    });
    $('.select-loca').click(function (event) {
        event.preventDefault();
        var cont = '<div class="form-group">';
        cont += '<label class="control-label col-lg-2">الموقع على الخريطة</label>';
        cont += '<div class="col-lg-10"><div class="input-group">';
        cont += '<input id="us3-address" name="address" class="form-control" >';
        cont += '<input type="hidden" id="us3-lat" name="lat">';
        cont += '<input type="hidden" id="us3-lng" name="lng">';
        cont += '<div id="us3"></div></div></div>';
        cont += '<script type="text/javascript"> getMap() </script>';
        $('.area-div').hide();
        $('.map-content').html(cont);
    });
    $('#follow-user').click(function (event) {
        event.preventDefault();
        var btn = $(this);
        var link = btn.attr('href');
        btn.append('<i class="fa fa-cog fa-spin fa-3x fa-fw" style="font-size:15px"></i>');
        $.get(link, {}, function (msg) {
            if (msg == 0) {
                btn.html("<i class='fa fa-minus'></i> إلغاء متابعة العضو");
            } else {
                btn.html("<i class='fa fa-plus'></i> متابعة العضو");
            }
        });
    });
    $('.btn-like').click(function (e) {
        var btn = $(this);
        var link = btn.attr('href');
        $.get(link, {}, function (msg) {
            if (msg == 1) {
                btn.parent().find('.like-btn').addClass('active');
                $('.SA').html('');
                $('.SA').html('حذف من المفضله');
            } else {
                //btn.css('color', '#000');
                btn.parent().find('.like-btn').removeClass('active');
                $('.SA').html('');
                $('.SA').html('إضافه الي المفضله');
            }
        });
        e.preventDefault();
    });
    $('.SSA').click(function (e) {
        var btn = $(this);
        var link = btn.attr('href');
        $.get(link, {}, function (msg) {
            if (msg == 1) {
                $('.SSA-Like').addClass('active');
                $('.SA').html('');
                $('.SA').html('حذف من المفضله');
            } else {
                //btn.css('color', '#000');
                $('.SSA-Like').removeClass('active');
                $('.SA').html('');
                $('.SA').html('إضافه الي المفضله');
            }
        });
        e.preventDefault();
    });
    $('#VoteUser a').click(function (event) {
        $('#VoteUser a').stop(true, true);
        event.preventDefault();
        var btn = $(this);
        var link = btn.attr('href');
        btn.parent().find('.vote-number').html('<i class="fa fa-cog fa-spin fa-3x fa-fw" style="font-size:15px"></i>');
        $.get(link, {}, function (msg) {
            btn.parent().find('.vote-number').html(msg);
        });
    });
    $('body').on('change', '.advs_dept_id', function (e) {
        var btn = $(this);
        var id = $(this).val();
        get_dept_props(id , $(this).data('id'));
    });

    $('body').on('change', '#advs_dept_id', function (e) {
        var btn = $(this);
        var id = $(this).val();
        get_dept_props(id , $(this).data('id'));
    });

    $('#proptype,.proptype').change(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var btn = $(this);
        var id = $(this).val();
        var data = {
            proptype: id
        };
        var action = $("input[name='getDetails']").data('action');
        var loader = $('#frm-loader').html();
        btn.parents('form').find('.advs_proptypes').html(loader);
        $.get(action, data, function (msg) {
            btn.parents('form').find('.advs_proptypes').html(msg);
        });
        return false;
    });

    $('#type_id,.type_id').change(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var btn = $(this);
        var id = $(this).val();
        var data = {
            type: id
        };
        var action = $("input[name='getDetails']").data('action');
        var loader = $('#frm-loader').html();
        btn.parents('form').find('.type_details').html(loader);
        $.get(action, data, function (msg) {
            btn.parents('form').find('.type_details').html(msg);
        });
        return false;
    });

    $(".country,#country").change(function (e) {
        // alert('111111111');
        e.preventDefault();
        e.stopImmediatePropagation();
        var btn = $(this);
        var id = $(this).val();
        var data = {
            country: id
        };
        var action = $("input[name='getDetails']").data('action');
        var loader = $('#frm-loader').html();
        btn.parents('form').find('.area_content').html(loader);
        $.get(action, data, function (msg) {
            // alert(msg);
            $('#country').removeClass('requiredInp');
            $('#country').parent().removeClass('requiredInp');
            btn.parents('form').find('.area_content').html(msg);
        });
        return false;
    });
    // $('.switches,.swithcer').bootstrapSwitch();

    $('.remove-contact').click(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var btn = $(this);
        var action = $('#remove-c-action').val();
        var id = btn.data('id');
        var token = $("input[name='_token']").val();
        if (!id) {
            btn.parent().parent().hide();
        } else {
            $.post(action, {
                id: id,
                _token: token
            }, function (result) {
                btn.parent().parent().hide();
            });
        }
        return false;
    });

    $('.remove-advs').click(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var btn = $(this);
        var action = $('#remove-advs-action').val();
        var id = btn.data('id');
        var token = $("input[name='_token']").val();
        $.post(action, {
            id: id,
            _token: token
        }, function (result) {
            btn.parent().parent().hide();
        });
        return false;
    });

    $('.add-more-contacts').click(function (event) {
        var ct = $('.contacts-row').html();
        $('.contacts-content').append(ct);
    });

    $('#srh-form').submit(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var data = $(this).serialize();
        var action = $(this).attr('action');
        var loader = $('#loader').html();
        $('.pages-content').html(loader);
        $.get(action, data, function (result) {
            $('.pages-content').html(result);
        });
        return false;
    });




    //  newwwwwwwwwwwwwww jsssssssssssssssssss
    $('.like-ad').click(function () {
        var btn = $(this);
        var id = btn.data('id');

    });

    $('.chat-with').click(function () {
        $('#chat-modal').modal('show');
        var link = $(this).data('href');
        // alert(link);
        $.get(link, {}, function (result) {
            // alert(result);
            $('#chat-modal').find('.modal-body').html(result);
        });
    });
    $('.side-menu-div li a').each(function () {
        // $('.side-menu-div li a').removeClass('active');
        var link = $(this).attr('href');
        if (link == window.location.href) {
            $(this).addClass('active');
        }
    });

    $('.follow-user-btn').click(function () {
        var btn = $(this);
        var link = $(this).attr('href');
        $.get(link, function (result) {
            result == 0 ? btn.find('span').html('إلغاء المتابعة') : btn.find('span').html('متابعة');
        });
        return false;
    });

    $('.like-user-btn').click(function () {
        var link = $(this).attr('href');
        var likes = $('.like-num').html();
        var dislikes = $('.dislike-num').html();
        // alert(likes);
        $.get(link, {}, function (result) {
            $('.like-num').html('( ' + result['likes'] + ' )')
            $('.dislike-num').html('( ' + result['dislikes'] + ' )')
        }, "json");
        return false;
    });

    $('#btn-remove-advs').click(function () {
        var link = $(this).data('href');
        var t = confirm('هل تريد حذف الإعلان');
        if (t) {
            window.location = link;
        }
    });

    $('.preview-img a').click(function () {
        var t = confirm('هل تريد حذف الصورة');
        var link = $(this).data('href');
        var btn = $(this);
        if (t) {
            $.get(link, function (result) {
                if (result == 1) {
                    btn.parent().hide();
                } else {
                    alert('غير مسموح بحذف الصورة');
                }
            });
        }
    });

});

function getMap(lat = 24.7135517, lng = 46.67529569999999) {
    $('#map').locationpicker({
        location: {
            latitude: lat,
            longitude: lng
        },
        radius: 300,
        zoom: 12,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: true,
        inputBinding: {
            latitudeInput: $('#us3-lat'),
            longitudeInput: $('#us3-lng'),
            locationNameInput: $('#us3-address')
        },
        enableAutocomplete: true,
        enableAutocompleteBlur: true,
        autocompleteOptions: null,

    });
}

function get_dept_props(dept_id = null, item_id = null) {
    var data = {
        dept: dept_id,
        item_id: item_id
    };
    if (dept_id != '') {
        var action = $("input[name='getDetails']").data('action');
        $.get(action, data, function (msg) {
            $('.advs_details').html(msg);
        });
    }
}