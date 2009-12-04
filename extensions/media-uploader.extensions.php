<?php
/**
 * register_custom_media_button function.
 *
 * Wrapper function for easily added new add media buttons
 *
 * @param int $id
 * @param string $button_text (optional)
 * @param bool $hide_other_options (optional) hide the default send to editor button and the other
 */
function register_custom_media_button( $id, $button_text = null, $hide_other_options = true, $multiple = false ) {

	if ( empty( $id ) || !is_string( $id ) )
		return false;
	
	$id = sanitize_title( $id );
	
	if ( is_null( $button_text ) )
		$button_text = 'Use as ' . ucwords( preg_replace( '#(-|_)#', ' ', $id ) );

	$buttons = get_option( 'custom_media_buttons' );

	$button = array( 'id' => $id, 'button_text' => $button_text, 'hide_other_options' => (bool) $hide_other_options, 'multiple' => ( $multiple ? 'yes' : '' ) );

	$buttons[$id] = $button;

	update_option( 'custom_media_buttons', $buttons );

}

/**
 * add_extra_media_buttons function.
 *
 * Adds the "Use as Post Thumbnail" button to the add media thickbox.
 *
 * @param array $form_fields
 * @param object $media
 * @return array $form_fields
 */
function add_extra_media_buttons( $form_fields, $media ) {

	$buttons = get_option( 'custom_media_buttons' );

	if ( $_GET['button'] ) :
		$button_id = $_GET['button'];

	else :
		preg_match( '/button=([A-z0-9_][^&]*)/', $_SERVER['HTTP_REFERER'], $matches );
		$button_id = $matches[1];

	endif;
	
	

	if ( isset( $button_id ) && $button = $buttons[$button_id] )
		$buttons_html = '<input type="submit" class="button" name="' . $button['id'] . '[' . $media->ID . ']" value="' . esc_attr( $button['button_text'] ) . '" />';

	if ( !$button['hide_other_options'] ) :
		$send = '<input type="submit" class="button" name="send[' . $media->ID . ']" value="' . esc_attr( __( 'Insert into Post' ) ) . '" />';

	else : ?>
	
		<style type="text/css">
			.slidetoggle tbody tr { display: none; }
			.slidetoggle tbody tr.submit { display: table-row; }
		</style>
	
<?php endif;
	
	// Standard Buttons
	$delete_href = wp_nonce_url( 'post.php?action=delete-post&amp;post=$media->ID', 'delete-post_' . $media->ID );
	$delete = '<a href="#" class="del-link" onclick="document.getElementById(\'del_attachment_' . $media->ID . '\').style.display=\'block\'; return false; ">' . __('Delete') . '</a>';

	// Create the buttons array
	$form_fields['buttons'] = array( 'tr' => "\t\t<tr class='submit'><td></td><td class='savesend'>$send $buttons_html $delete
		<div id=\"del_attachment_$media->ID\" class=\"del-attachment\" style=\"display:none;\">" . sprintf(__("You are about to delete <strong>%s</strong>."), $media->post_title ) . " <a href=\"$delete_href\" id=\"del[$media->ID]\" class=\"delete\">" . __('Continue') . "</a>
		<a href=\"#\" class=\"del-link\" onclick=\"this.parentNode.style.display='none';return false;\">" . __('Cancel') . "</a></div></td></tr>\n" );

	return $form_fields;

}
add_filter( 'attachment_fields_to_edit', 'add_extra_media_buttons', 99, 2 );


/**
 * catch_extra_media_buttons function.
 *
 * Catches when the "Use as Post Thumbnail" button is pressed, sets up the variables and calls the javascript
 *
 */
function catch_extra_media_buttons() {

	// Check if a custom button was passed and if it was get its id by regex
	if ( strpos( $_POST['_wp_http_referer'], 'button=' ) ) :
		
		//is_single check
		preg_match( '/multiple=([A-z0-9_][^&]*)/', $_POST['_wp_http_referer'], $multiple_matches );
		$multiple = $multiple_matches[1];
		
		preg_match( '/button=([A-z0-9_][^&]*)/', $_POST['_wp_http_referer'], $matches );
		$button_id = $matches[1]; ?>

		<?php // If the custom button was pressed
		if ( is_array( $_POST[$button_id] ) ) :
			
			$attach_id = key( $_POST[$button_id] );
			$attach_thumb_url = wp_get_attachment_thumb_url( $attach_id ); 
			tw( $is_single );
			?>
		
			<script type="text/javascript">
			    var win = window.dialogArguments || opener || parent || top;
			    win.save_custom_image( '<?php echo $button_id; ?>', <?php echo $attach_id; ?>, '<?php echo $attach_thumb_url; ?>', '<?php echo $multiple ?>' );
			</script>
		
			<?php exit;
		endif;

	endif;

}
add_filter( 'admin_head', 'catch_extra_media_buttons' );


/** add_button_to_upload_form function
 *	
 * Adds the button variable to the GET params of the media buttons thickbox link
 *
 */
function add_button_to_upload_form() { ?>

	<script type="text/javascript">

		jQuery( document ).ready( function() {
			jQuery( '#image-form' ).attr( 'action', jQuery( '#image-form' ).attr( 'action' ) + '&amp;button=<?php echo $_GET['button']; ?>');
		} );

	</script>

<?php }
add_action( 'admin_head', 'add_button_to_upload_form' ); ?>