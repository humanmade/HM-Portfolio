<?php require_once( '../../../../../wp-load.php' ); ?>

actionsUrl = "<?php echo JH_PORTFOLIO_URL ?>ajax-actions.php";

jQuery(document).ready(function($) {  
	
	//JH Portfolio Selector
	$("#jh-portfolio-selector li a").live( 'click', function(e) {
		e.preventDefault();
		showSingle( $(this).attr('rel') );
	});
	
	$("ul#related-work li a").live('click', function(e) {
		e.preventDefault();
		showSingle( $(this).attr('rel') );
	});
	
	function showSingle( postId ) {
		
		//update the list
    	$("#jh-portfolio-selector li a.active").removeClass('active');
    	$("#jh-portfolio-selector li a[rel='" + postId + "']").addClass('active');
    	container = $("#jh-portfolio-selector").closest(".entry");
    	
 		
 		//populate the single entry
    	$.ajax({
			type: "POST",
			url: actionsUrl,
			data: ({ 
				action: 'get_single',
				post_id: postId
			}),
			success: function( data ){
				$(container).contents().remove();
				$(container).html(data);
			}
 		});
	}
	
	//Additional Image Gallery
 	$("#jh-portfolio-additional-images-holder img").live( 'click', function() {
 		
 		//fire the request for the image
 		$.ajax({
			type: "POST",
			url: actionsUrl,
			data: ({ 
				action: 'get_additional_image',
				attach_id: $(this).attr('rel'),
				width: 200,
				height: 140
			}),
			success: function( data ){
				if( data ) {
					$("#jh-portfolio-additional-image-holder img").fadeOut('fast', function() {
						$(this).attr('src', data);
						$(this).fadeIn('fast');
					})
				}
					$("#jh-portfolio-additional-image-holder img").attr('src', data);
				
			}
 		});
 		
 	});
	
});