$(document).ready(function () {
    $('.remove-contact').click(function () {
        var id = $(this).data('id');
        var btn = $(this);
        if (id && id != 0) {
            var action = $('#remove-action').data('action');
            // alert(action);
            var token = $("input[name='_token']").val()
            var data = {
                id: btn.data('id'),
                table: 'site_contacts',
                _token: token
            };
            var conf = confirm('هل متأكد من الحذف ؟؟');
            if (conf) {
                $.post(action, data, function (msg) {
                    msg == 1 ? btn.parent().parent().parent().remove() : alert('لم يتم الحذف');
                });
            }
        } else {
            btn.parent().parent().parent().hide();
        }
    });
    $('.navigation li a').each(function () {
        var url = window.location.href.split('?')[0];
        if (url == $(this).attr('href')) {
            $('.navigation').find('li').removeClass('active');
            $(this).parents('li').addClass('active');
            $(this).parents('li').find('ul').slideDown();
        }
    });
    $('#tags').tagsInput();
    $('.table:not(.normal-table)').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Arabic.json"
        }
    });
    $(document).on('click', '.fa-remove', function () {
        var btn = $(this);
        var action = $('#remove-action').data('action');
        var token = $("input[name='_token']").val()
        var data = {
            id: btn.data('id'),
            table: btn.data('table'),
            _token: token
        };
        if ($(this).data('table') == 'depts') {
            var conf = confirm("يرجي العلم انه سيتم حذف الإعلانات المتعلقة بهذا القسم .... هل أنت متأكد من الحذف ؟");
        } else {
            var conf = confirm('هل متأكد من الحذف');
        }
        console.log(conf);
        if (conf) {
            $.post(action, data, function (msg) {
                msg == 1 ? btn.parent().parent().hide() : alert('لم يتم الحذف');
            });
        }
    });
    var uploadedfile = $('#uploadfile').data('file');
    $("#uploadfile,.uploadfile").fileinput({
        initialPreview: [uploadedfile],
        overwriteInitial: true,
        initialPreviewAsData: true,
        maxFilesNum: 1,
        showRemove: true,
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
    });
    var uploadedfile = $('#multi-uploadfile').data('file');
    $("#multi-uploadfile").fileinput({
        initialPreview: [uploadedfile],
        overwriteInitial: true,
        initialPreviewAsData: true,
        maxFilesNum: 10,
        allowedFileTypes: ['image', 'video', 'flash'],
        slugCallback: function (filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
    });

    $('.switches,.swithcer').bootstrapSwitch();
    // $('select:not(.norselect)').selectpicker();
    $('.add-other').click(function () {
        var ct = $('.add-other-content').html();
        $('.other-contacts').append(ct);
        return false;
    });

    $('.add-other-props').click(function () {
        var parent = $(this).data('parent');
        var ids = $(this).data('ids');
        var ct = '<br /><div class="input-group">';
        ct += '<div class="row">';
        parent ? ct += '<input type="hidden" value="' + parent + '" name="type[]" >' : '';
        ct += '<div class="col-sm-6">';
        ct += '<input type="text" name="props[]" class="form-control">';
        ct += '</div><div class="col-sm-5">';
        ids ? ct += '<input type="hidden" name="ids[]" value="0" />' : '';
        ct += '<input type="file" name="images[]"></div>';
        ct += '<div class="col-sm-1">';
        ct += '<span class="btn btn-danger fa fa-trash"></span>';
        ct += '</div></div></div>';
        ct += "<script>$('.fa-trash').on('click',function(){";
        ct += '$(this).parent().parent().hide();});</script>';
        parent ? $('.other-props-' + parent + '').append(ct) : $('.other-props').append(ct);
        return false;
    });
    $('.fa-trash').on('click', function () {
        var btn = $(this);
        var id = $(this).data('id');
        var action = $('.proptypes-action').val();
        var token = $("input[name='_token']").val();
        var data = {
            id: id,
            _token: token
        };
        if (id) {
            $.post(action, data, function (msg) {
                msg ? btn.parent().parent().hide() : '';
            });
        } else {
            btn.parent().parent().hide();
        }
    });

    $('#prop_type').change(function () {
        var id = $(this).val();
        var data = {
            prop: id
        };
        var action = $(this).data('action');
        $.get(action, data, function (msg) {
            $('.propContent').html(msg);
        });
    });

    $('#dept_id').change(function () {
        var id = $(this).val();
        var data = {
            dept: id
        };
        var action = $(this).data('action');
        $.get(action, data, function (msg) {
            $('#prop_type').html(msg);
        });
    });

    $('#dept_titles').change(function () {
        var id = $(this).val();
        var data = {
            dept: id
        };
        var action = $(this).data('action');
        $.get(action, data, function (msg) {
            $("[name='title_id']").html(msg);
        });
    });


    $('body').on('change', '.advs_dept_id', function () {
        var id = $(this).val();
        var item_id = $(this).attr('data-id');
        get_dept_props(id,item_id);
    });
    
    $('body').on('change', '#advs_dept_id', function (e) {
        var btn = $(this);
        var id = $(this).val();
        get_dept_props(id , $(this).data('id'));
    });

    $('.proptype').change(function () {
        var id = $(this).val();
        var data = {
            proptype: id
        };
        var action = $("input[name='getDetails']").data('action');
        $.get(action, data, function (msg) {
            $('.advs_proptypes').html(msg);
        });
    });

    $('#type_id').change(function () {
        var id = $(this).val();
        var data = {
            type: id
        };
        var action = $("input[name='getDetails']").data('action');
        $.get(action, data, function (msg) {
            $('.type_details').html(msg);
        });
    });

    $("#country").change(function () {
        var id = $(this).val();
        var data = {
            country: id
        };
        var action = $("input[name='getDetails']").data('action');
        $.get(action, data, function (msg) {
            $('.area_content').html(msg);
        });
    });

});



function getMap(lat = 30.0444196, lng = 31.23571160000006) {
    $('#us3').locationpicker({
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

function remove_row() {
    var btn = $(this);
    var action = $('#remove-action').data('action');
    var token = $("input[name='_token']").val()
    var data = {
        id: btn.data('id'),
        table: btn.data('table'),
        _token: token
    };
    var conf = confirm('هل متأكد من الحذف');
    if (conf) {
        $.post(action, data, function (msg) {
            msg == 1 ? btn.parent().parent().hide() : alert('لم يتم الحذف');
        });
    }
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