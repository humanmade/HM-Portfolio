<?php
include_once('meta-boxes.php');

add_action( 'admin_menu', 'hmp_add_meta_boxes' );
function hmp_add_meta_boxes() {
	
	$hmp_gallery_post_types =  get_option('hmp_post_type', array('hmp-entry') );

	add_meta_box( 'brief', 'Brief', 'hmp_brief_meta_box', 'hmp-entry', 'normal', 'high' );
	foreach( $hmp_gallery_post_types as $post_type ) {
		add_meta_box( 'additional-images', 'Gallery', 'hmp_gallery_meta_box', $post_type, 'normal', 'high' );
	}
	add_meta_box( 'additional-info', 'Additional Information', 'hmp_additional_information_meta_box', 'hmp-entry', 'side', 'low' );
	
	//register the options page
	hmp_register_settings();
	add_options_page('Portfolio Settings', 'HM Portfolio', 'manage_options', 'hmp-portfolio-options', 'hmp_options_page');	
}

add_action( 'wp_insert_post', 'hmp_insert_post', 10, 2 );
function hmp_insert_post( $post_id, $post ) {
	
	//fire all the beta box _submitted functions
	//gallery could be on other post types too.
		
	if( $post->post_type == 'hmp-entry' ) :
		hmp_brief_meta_box_submitted( $post );
		hmp_gallery_meta_box_submitted( $post );
		hmp_additional_information_meta_box_submitted( $post );
	elseif( in_array( $post->post_type, get_option('hmp_post_type', array('hmp-entry') ) ) ) :
		hmp_gallery_meta_box_submitted( $post );
	else:
		return;
	endif;
		
}

function hmp_register_settings() {
	register_setting( 'hmp-settings', 'hmp_url_base' );
	register_setting( 'hmp-settings', 'hmp_single_base' );
	register_setting( 'hmp-settings', 'hmp_add_page_link' );
	register_setting( 'hmp-settings', 'hmp_title' );
	register_setting( 'hmp-settings', 'hmp_portfolio_menu_order' );
	register_setting( 'hmp-settings', 'hmp_post_type' );
	register_setting( 'hmp-settings', 'hmp_append_gallery' );
}

function hmp_is_checked( $post_type, $enabled_post_types ) {
	if( in_array( $post_type, $enabled_post_types ) ) 
		echo 'checked="checked"';
}
function hmp_is_selected( $option = 1, $true = 1  ) {
	if( $option == 1 && $true == true || $option == 0 && $selected == false )
		echo 'selected="selected"';
}

function hmp_upgrade_jhp_notice() {
	
	if( isset( $_GET['hmp_migrate'] )) {
		hmp_upgrade_jhp();
		echo '<div id="message" class="updated below-h2"><p>Done</p></div>';
		return;
	}
	
	global $wpdb;
	$results = $wpdb->get_var( "SELECT * FROM $wpdb->posts WHERE post_type = 'jh-portfolio'" );
	
	if ( !$results ) 
		return;
	
	?>
	<div id="message" class="updated below-h2">
	    <p>Looks like you have been using JH-Portfolio. You can migrate your data and settings HM-Portfolio.</p>
	    <p><em><b>Note:</b> this plugin is much simpler and some settings will not be reversible. Please backup your data first.</em></p>
	    <p><a class="button" href="<?php echo admin_url('options-general.php?page=hmp-portfolio-options&hmp_migrate=true'); ?>">Update Now</a></p>
	</div>
	<?php
}

function hmp_options_page() {
	?>
	
	<div class="wrap">
		<h2>Portfolio Settings</h2>
	
		<?php hmp_upgrade_jhp_notice() ?>		
		
		<form method="post" action="options.php">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><strong>Permalinks</strong></th>
					<td>
						<input type="text" name="hmp_url_base" value="<?php echo get_option('hmp_url_base', 'portfolio'); ?>" />
						<span class="description">Portfolio home URL (default: /portfolio/)</span>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><strong>Enable Gallery for Post Type</strong></th>
					<td>
					<?php 
						$hmp_enable_post_type =  get_option('hmp_post_type', array('hmp-entry') ); 
						$args = array( 'public'   => true, '_builtin' => false );
						$custom_post_types = get_post_types( $args, 'objects' );
					?>	
						<label for="hmp_post_type_post"><input type="checkbox" id="hmp_post_type_post" name="hmp_post_type[]" value="post" <?php hmp_is_checked( 'post', $hmp_enable_post_type ); ?>/> post</label><br/>
						<label for="hmp_post_type_page"><input type="checkbox" id="hmp_post_type_page" name="hmp_post_type[]" value="page" <?php hmp_is_checked( 'page', $hmp_enable_post_type ); ?>/> page</label><br/>
					<?php 
						foreach( $custom_post_types as $post_type ) { ?>
							<label for="hmp_post_type_<?php echo $post_type->name; ?>"><input type="checkbox" id="hmp_post_type_<?php echo $post_type->name; ?>" name="hmp_post_type[]" value="<?php echo $post_type->name; ?>" <?php hmp_is_checked( $post_type->name, $hmp_enable_post_type ); ?>/> <?php echo $post_type->name; ?></label><br/>
						<?php }
					?>		
						<small class="description">Enable the gallery for other post types.</small>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><strong>Append Gallery to Content.</strong></th>
					<td>
						<select name="hmp_append_gallery" id="hmp_append_gallery">
							<option value="0" <?php hmp_is_selected( 1, get_option( 'hmp_append_gallery', 1 ) ); ?>>Off</option>
							<option value="1" <?php hmp_is_selected( 1, get_option( 'hmp_append_gallery', 1 ) ); ?>>On</option>
						</select>
						<br/>
						<small class="description">Enabled by default so that the plugin works out of the box. Disable if you want greater control over how the gallery is displayed.</small>
					</td>
				</tr>
								
			</table>
			
			<input type="hidden" name="action" value="update" />
			
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
			
			<?php 
			settings_fields( 'hmp-settings' );
			
			// Output any sections defined for page sl-settings
			do_settings_sections('hmp-settings'); 
			?>
		</form>
		
		<div id="message">
			<p><small>If you are having any issue with HM Portfolio please file a bug or question <a href="http://github.com/joehoyle/hmp-Portfolio/issues" target="_blank">here.</a><small></small></p>
		</div>
	</div>
	<?php
}

?>