
	function PQuery_elements (t_master_div,t_div,t_add,t_del,t_htmlstr,del_ok,err_msg,t_load_div,t_php){
		$(t_add).click(function() {
			var text = $(t_htmlstr).html();
			$(t_master_div).append(text);
		});
		$(t_del).click(function() {
			var t = $(t_div).length;
				ids=new Array()
				a=0;
			$(t_div).each(function() {
				if ($("input[type=checkbox]",this).is(':checked')) {
					if($(".KeyToDel",this).val()){
					ids[a]=$(".KeyToDel",this).val();
					}else{
					ids[a]=$("input[type=hidden]",this).val();
					}
					a++;
					if(t > 0) {
						$(this).remove();
						t--;
					}
				}
			});
			$.ajax({
			   type: "POST",
			   url: t_php,
				data:"id="+ids,
			   cache: false,
			   success: function(data){
			   if(data ="ok"){
					$(t_load_div).html(del_ok);
			   }else{
					$(t_load_div).html(err_msg);
			   }
				
			  }
			 });
		}); 
	}
	function getSELECT (G_url,G_from,G_to){
		$(".lodsel").animate({left:'10px'}, 700);
		$(".lodsel").queue(function () {
		var chosen = $(G_to).attr('chosen');
		var str = $(G_from).val(); 
		var chosen_arr = $(G_to).attr('chosen_arr');
		if(chosen_arr){
		var Array_chosen_arr = chosen_arr.split(',');
		}else{
		var Array_chosen_arr = false;
		}
		$.getJSON(G_url,{val: str },function(data) {
				$(G_to+" option").remove();
				$(G_to+" optgroup").remove();
			$.each(data, function(i,item){
				var mediam=item.media.m;
				var mediai=item.media.i;
				var lastProductIndex = $.inArray(mediai, Array_chosen_arr);
				if(lastProductIndex >= 0 ){
					$("<option/></option>").html(mediam).val(mediai).attr('selected', 'selected').appendTo(G_to);
				}else if(chosen == mediai){
					$("<option/></option>").html(mediam).val(mediai).attr('selected', 'selected').appendTo(G_to);
				}else{
					$("<option/></option>").html(mediam).val(mediai).appendTo(G_to);
				}
				
			});
		});
		$(this).dequeue();
		});
		$(G_from).change(function () {
			var str = $(this).val();
			var chosen = $(G_to).attr('chosen');
			var chosen_arr = $(G_to).attr('chosen_arr');
			if(chosen_arr){
			var Array_chosen_arr = chosen_arr.split(',');
			}else{
			var Array_chosen_arr = false;
			}
			$(G_to+" option").remove();
			$(G_to+" optgroup").remove();
			$("<option/></option>").html("Looding...").attr("value", 0).appendTo(G_to);
			$.getJSON(G_url,{val: str },function(data) {
				$(G_to+" option").remove();
				$(G_to+" optgroup").remove();
				$.each(data, function(i,item){
					var mediam=item.media.m;
					var mediai=item.media.i;
					var lastProductIndex = $.inArray(mediai, Array_chosen_arr);
					if(lastProductIndex >= 0 ){
						$("<option/></option>").html(mediam).val(mediai).attr('selected', 'selected').appendTo(G_to);
					}else if(chosen == mediai){
						$("<option/></option>").html(mediam).val(mediai).attr('selected', 'selected').appendTo(G_to);
					}else{
						$("<option/></option>").html(mediam).val(mediai).appendTo(G_to);
					}
				});
			});
		})
		.change();
	}