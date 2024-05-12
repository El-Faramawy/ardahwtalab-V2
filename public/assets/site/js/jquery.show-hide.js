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
				// ����� �� ������� ����� ��� key 
				// ��� �� ��� ����� ��� ������� ��� 
				$("[show_by='"+config.key+"']").hide();
				
				// ��� ��� ������ checkbox ��� ��� ����� ��� ������ ���� ���� checked
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
				// ��� ��� ������ radio ��� ��� ����� ��� ������ ���� ���� checked
				// ����� ����� �� checkbox
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
							// ��� ���� ����� ������ �� ������ 
							var par = JSON.parse(Get_if_values); //an array [1,2]
							// ��� ���� ���� ������ ������������ ������ �� �������� 
							if(jQuery.inArray(val, par)!==-1) {
								$(this).show();
							}
						}else if(typeof(Get_if_value) != "undefined" && Get_if_value !== null && Get_if_value != '' ) {
							// ��� ���� ������� ������ ��� ����
							if(val == Get_if_value) {
								$(this).show();
							}
						}
					});
				}
			});
        };
		
	})( jQuery );
	// ����� ���� ������� ������� ������� ���� 
	// ��� �� ��� ����� ��� �� ������ �� ���������� 
	// ��� ����� ���� �� ����� ���� ��� ����� �� �������
	$("[show_by]").each(function() {
		$(this).hide();
	});
});
	