@foreach($props as $p)
	<div class="form-group myprops">
		<label class="control-label col-lg-2">{{$p->name}}</label>
		<div class="col-lg-10">
			<div class="input-group">
				<div class="row">
					<input name="type[]" type="hidden" value="{{$p->id}}">
					<div class="col-sm-5">
						<input type="text" name="props[]" class="form-control">
					</div>
					<div class="col-sm-5">
						<input type="file" name="images[]">
					</div>
					<div class="col-sm-2">
						<span class="btn btn-danger fa fa-trash"></span>
					</div>
				</div>
			</div>
			<div class="other-props-{{$p->id}}"></div><br />
			<a class="btn btn-danger add-other-props" data-parent="{{$p->id}}">+ اضافة نوع اخر</a>
		</div>
	</div>
@endforeach

<script type="text/javascript">
	$('.add-other-props').click(function(){
        var parent=$(this).data('parent');
        var ids=$(this).data('ids');
        var ct='<br /><div class="input-group">';
        ct+='<div class="row">';
        parent ? ct+='<input type="hidden" value="'+parent+'" name="type[]" >' : '';
        ct+='<div class="col-sm-5">';
        ct+='<input type="text" name="props[]" class="form-control">';
        ct+='</div><div class="col-sm-5">';
        ct+='<input type="file" name="images[]"></div>';
        ct+='<div class="col-sm-2">';
        ct+='<span class="btn btn-danger fa fa-trash"></span>';
        ct+='</div></div></div>';
        ct+="<script>$('.fa-trash').on('click',function(){";
        ct+='$(this).parent().parent().hide();});';
        ids ? ct+='<input type="hidden" name="ids[]" value="0" />' : ''; 
        parent ? $('.other-props-'+parent+'').append(ct) : $('.other-props').append(ct);
        return false;
    });
    $('.fa-trash').on('click',function(){
        var btn=$(this);
        var id=$(this).data('id');
        var action=$('.proptypes-action').val();
        var token=$("input[name='_token']").val();
        var data={id:id,_token:token};
        if(id){
            $.post(action,data,function(msg){
                msg ? btn.parent().parent().hide() : '';
            });
        }else{
            btn.parent().hide();
        }
    });

    $('#prop_type').change(function(){
        var id=$(this).val();
        var data={prop:id};
        var action=$(this).data('action');
        $.get(action,data,function(msg){
            $('.propContent').html(msg);
        });
    });
</script>