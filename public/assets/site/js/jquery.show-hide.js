$(document).ready(function(){
    (function( $ ){
	
        $.fn.show_hide_by_value = function(settings) {
			var config = {
				//'foo': 'bar'
			};
			if (settings){$.extend(config, settings);}
 
            this.change(function() {
				var run = true;
				var val = String($(this).val());
				var input_type = $(this).attr('type');
				// «Œ›«¡ ﬂ· «·⁄‰«’— «·Œ«’ »«· key 
				// Õ Ï ·« Ì „ √ŸÂ«— ≈·« «·„ÿ·Ê» ›ﬁÿ 
				$("[show_by='"+config.key+"']").hide();
				
				// ≈–« ﬂ«‰ «·⁄‰’— checkbox ›·« Ì „  ‘€Ì· ≈·« «·⁄‰’— «·–Ï Ì√Œ– checked
				if(input_type == 'checkbox'){
					var is_checked = $(this).attr('checked');
					if(!is_checked){
						var run = false;
					}
				}
				
				if(run == true){
					$("[show_by='"+config.key+"']").each(function() {
						var Get_if_value = $(this).attr('if_value');
						var Get_if_values = $(this).attr('if_values');
						 
						if(typeof(Get_if_values) != "undefined" && Get_if_values !== null && Get_if_values != '' ) {
							var par = JSON.parse(Get_if_values); //an array [1,2]
							if(jQuery.inArray(val, par)!==-1) {
								$(this).show('slow');
							}
						}else if(typeof(Get_if_value) != "undefined" && Get_if_value !== null && Get_if_value != '' ) {
							if(val == Get_if_value) {
								$(this).show('slow');
							}
						}
					});
				}

            });

			$(this).each(function() {
				var run = true;
				var val = String($(this).val());
				var input_type = $(this).attr('type');
				// ≈–« ﬂ«‰ «·⁄‰’— radio ›·« Ì „  ‘€Ì· ≈·« «·⁄‰’— «·–Ï Ì√Œ– checked
				// Êﬂ–·ﬂ «·√„— ·‹ checkbox
				if(input_type == 'radio' || input_type == 'checkbox'){
					var is_checked = $(this).attr('checked');
					if(!is_checked){
						var run = false;
					}
				}
				if(run == true){
					$("[show_by='"+config.key+"']").each(function() {
						var Get_if_value = $(this).attr('if_value');
						var Get_if_values = $(this).attr('if_values');
						
						if(typeof(Get_if_values) != "undefined" && Get_if_values !== null && Get_if_values != '') {
							// ≈–« ﬂ«‰  «·ﬁÌ„ „√ŒÊ–… „‰ „’›Ê›… 
							var par = JSON.parse(Get_if_values); //an array [1,2]
							// ≈–« ﬂ«‰  ﬁÌ„… «·⁄‰’— «·„ı⁄ „œ⁄·Ì… „ÊÃÊœ… ›Ï «·„’›Ê›… 
							if(jQuery.inArray(val, par)!==-1) {
								$(this).show();
							}
						}else if(typeof(Get_if_value) != "undefined" && Get_if_value !== null && Get_if_value != '' ) {
							// ≈–« ﬂ«‰  «·ﬁÌ„Ì… „√ŒÊ–… ﬂ‰’ ⁄«œÏ
							if(val == Get_if_value) {
								$(this).show();
							}
						}
					});
				}
			});
        };
		
	})( jQuery );
	// √Œ›«¡ Ã„Ì⁄ «·⁄‰«’— «·„ﬁ’Êœ «· ⁄«„· „⁄Â« 
	// Õ Ï ·« Ì „ √ŸÂ«— ≈·« „« Ì Ê«›ﬁ „⁄ «·«Œ Ì«—«  
	// Â–« «·ﬂÊœ Ì⁄„· ›Ï »œ«Ì…  Õ„· Â–« «·„·› „‰ «·„ ’›Õ
	$("[show_by]").each(function() {
		$(this).hide();
	});
});
	