jQuery(document).ready(function($) {
	$("a.delete_custom_image").live( 'click', function(e) {
		e.preventDefault();
		delete_custom_image(this);
	});
});

// Part of media-uploader extensions, inserts the img into html on save
function save_custom_image( button_id, id, src, is_single ) {

	// Close the thickbox
	tb_remove();
		
	// Add the id to the hidden field
	if( is_single == 'yes' )
		jQuery( '#' + button_id ).attr( "value", jQuery( '#' + button_id ).attr( "value" ) + ',' + id );
	else
		jQuery( '#' + button_id ).attr( "value", id );
	
	// If there is already an image remove it
	if( is_single !== 'yes' )
		jQuery( '#' + button_id + '_container' ).html( '' );
	    
	// Create the image
	jQuery( '<span class="image-wrapper" id="' + id + '"><img src="' + src + '" /><a class="delete_custom_image" rel="' + button_id + ':' + id + '">Delete</a> | </span>' ).appendTo( '#' + button_id + '_container' );
	
	// Finally show the containing div
	jQuery( '#' + button_id + '_container' ).show( 'fast' );
	
	//if there is an empty message, hide it
	if( jQuery( '#' + button_id + '_container' ).find('.empty-message').length > 0 )
		jQuery( '#' + button_id + '_container' ).find('.empty-message').hide();

}

function delete_custom_image( element ) {
	
	args = jQuery(element).attr('rel').split(':');

	// Remove the image and the delete link from the form
	jQuery( '#' + args[0] + '_container' ).find("#" + args[1]).hide( 'normal', function() { jQuery(this).remove() } );
	
	$ids = jQuery( '#' + jQuery( element ).attr( 'rel' ) ).val();
	// Remove the hidden input's value
	jQuery( '#' + args[0] ).val( jQuery( '#' + args[0] ).val().replace( args[1], '' ) );
}