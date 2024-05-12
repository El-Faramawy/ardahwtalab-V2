
$(document).ready(function(){
	$('.is_online').each(function(i, obj) {
		var id_user = $( this ).data( "id-user" ) ;
		var offline = $(this).find('.offline_user');
		var online = $(this).find('.online_user');
		
		// ÇáßÔİ Úä ÊæÇÌÏ ÇáÃÚÖÇÁ
		$.get( LiknSite+"scan_online.php?id_user="+id_user, function( data ) {
			if(data == 0){
				$(offline).show( );
				$(online).hide( );
			}else{
				$(offline).hide( );
				$(online).show( );
			}
		});
	});


	setInterval(function(){
		
		
	},5000);
});