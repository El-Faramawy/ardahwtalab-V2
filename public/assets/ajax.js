$(document).ready(function(){
	$('#country').change(function(){
		var country=$(this).val();
		var action=$(this).data('action');
		$.post(action,{country:country},function(data){
			$('#area').html(data);
		});
	});

	
});