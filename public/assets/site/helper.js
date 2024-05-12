jQuery(document).ready(function() {
    $('.show-list').click(function(event) {
        event.preventDefault();
        var action=$('.list-action').val();
        var id=$(this).data('id');
        var data={id:id};
        $('#list-modal').modal('show').find('.modal-body').html('<center><h3><i class="fa fa-cog fa-spin fa-3x fa-fw"></i></h3></center>');
        $.get(action,data,function(msg){ $('#list-modal').find('.modal-body').html(msg); });
        return false;
    });
    $('.select-loca').click(function(event) {
        event.preventDefault();
        var cont='<div class="form-group">';
        cont+='<label class="control-label col-lg-2">الموقع على الخريطة</label>';
        cont+='<div class="col-lg-10"><div class="input-group">';
        cont+='<input id="us3-address" name="address" class="form-control" >';
        cont+='<input type="hidden" id="us3-lat" name="lat">';
        cont+='<input type="hidden" id="us3-lng" name="lng">';
        cont+='<div id="us3"></div></div></div>';
        cont+='<script type="text/javascript"> getMap() </script>';
        $('.area-div').hide();
        $('.map-content').html(cont);
    });
    $('#follow-user').click(function(event) {
        event.preventDefault();
        var btn=$(this);
        var link=btn.attr('href');
        btn.append('<i class="fa fa-cog fa-spin fa-3x fa-fw" style="font-size:15px"></i>');
        $.get(link,{},function(msg){
            if(msg==0){
                btn.html("<i class='fa fa-minus'></i> إلغاء متابعة العضو");
            }else{
                btn.html("<i class='fa fa-plus'></i> متابعة العضو");
            }
        });
    });
    $('.btn-like,.btn-dislike').click(function(event) {
        event.preventDefault();
        var btn=$(this);
        var link=btn.parent().attr('href');
        btn.find('.vote-number').html('<i class="fa fa-cog fa-spin fa-3x fa-fw" style="font-size:15px"></i>');
        $.get(link,{},function(msg){
            var msg=$.parseJSON(msg);
            $('.btn-dislike').find('.vote-number').html(msg['dislikes']);
            $('.btn-like').find('.vote-number').html(msg['likes']);
        });
    });
    $('#VoteUser a').click(function(event) {
        $('#VoteUser a').stop( true, true );
        event.preventDefault();
        var btn=$(this);
        var link=btn.attr('href');
        btn.parent().find('.vote-number').html('<i class="fa fa-cog fa-spin fa-3x fa-fw" style="font-size:15px"></i>');
        $.get(link,{},function(msg){
            btn.parent().find('.vote-number').html(msg);
        });
    });
    $('#advs_dept_id,.advs_dept_id').change(function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var btn=$(this);
        var id=$(this).val();
        var info = $(this).data('info');
        var data={dept:id , item_id : info};
        var action=$("input[name='getDetails']").data('action');
        var loader=$('#frm-loader').html();
        btn.parents('form').find('.advs_details').html(loader);
        $.get(action,data,function(msg){
            // alert(msg);
            btn.parents('form').find('.advs_details').html(msg);
        });
        return false;
    });

    $('#proptype,.proptype').change(function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var btn=$(this);
        var id=$(this).val();
        var data={proptype:id};
        var action=$("input[name='getDetails']").data('action');
        var loader=$('#frm-loader').html();
        btn.parents('form').find('.advs_proptypes').html(loader);
        $.get(action,data,function(msg){
            btn.parents('form').find('.advs_proptypes').html(msg);
        });
        return false;
    }); 

    $('#type_id,.type_id').change(function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var btn=$(this);
        var id=$(this).val();
        var data={type:id};
        var action=$("input[name='getDetails']").data('action');
        var loader=$('#frm-loader').html();
        btn.parents('form').find('.type_details').html(loader);
        $.get(action,data,function(msg){
            btn.parents('form').find('.type_details').html(msg);
        });
        return false;
    });

    $(".country,#country").change(function(e) {
        // alert('111111111');
        e.preventDefault();
        e.stopImmediatePropagation();
        var btn=$(this);
        var id=$(this).val();
        var data={country:id};
        var action=$("input[name='getDetails']").data('action');
        var loader=$('#frm-loader').html();
        btn.parents('form').find('.area_content').html(loader);
        $.get(action,data,function(msg){
            // alert(msg);
            btn.parents('form').find('.area_content').html(msg);
        });
        return false;
    });
    // $('.switches,.swithcer').bootstrapSwitch();

    $('.remove-contact').click(function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var btn=$(this);
        var action=$('#remove-c-action').val();
        var id=btn.data('id');
        var token=$("input[name='_token']").val();
        if(!id){
            btn.parent().parent().hide();
        }else{
            $.post(action,{id:id,_token:token},function(result){
              btn.parent().parent().hide();  
            });
        }
        return false;
    });

    $('.remove-advs').click(function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var btn=$(this);
        var action=$('#remove-advs-action').val();
        var id=btn.data('id');
        var token=$("input[name='_token']").val();
        $.post(action,{id:id,_token:token},function(result){
          btn.parent().parent().hide();  
        });
        return false;
    });

    $('.add-more-contacts').click(function(event) {
        var ct=$('.contacts-row').html();
        $('.contacts-content').append(ct);
    });

    $('#srh-form').submit(function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var data=$(this).serialize();
        var action=$(this).attr('action');
        var loader=$('#loader').html();
        $('.pages-content').html(loader);
        $.get(action,data,function(result){
            $('.pages-content').html(result);
        });
        return false;
    });

});

/*function getMap(lat=24.7135517,lng=46.67529569999999){
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
}*/
    