<?php
include_once('meta-boxes.php');

add_action( 'admin_menu', 'hmp_add_meta_boxes' );
function hmp_add_meta_boxes() {
	
	$hmp_gallery_post_types =  get_option('hmp_post_type', array('hmp-entry') );

	add_meta_box( 'brief', 'Brief', 'hmp_brief_meta_box', 'hmp-entry', 'normal', 'high' );
	//add_meta_box( 'main-image', 'Main Image', 'thumbnail_id_meta_box', 'hmp-entry', 'normal', 'high' );
	
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
	
	if( $post->post_type !== 'hmp-entry' )
		return;
	
	//fire all the beta box _submitted functions
	hmp_brief_meta_box_submitted( $post );
	thumbnail_id_meta_box_submitted( $post );
	hmp_gallery_meta_box_submitted( $post );
	hmp_additional_information_meta_box_submitted( $post );
}

function hmp_register_settings() {
	
	register_setting( 'hmp-settings', 'hmp_url_base' );
	register_setting( 'hmp-settings', 'hmp_single_base' );
	register_setting( 'hmp-settings', 'hmp_add_page_link' );
	//register_setting( 'hmp-settings', 'hmp_use_styles' );
	//register_setting( 'hmp-settings', 'hmp_use_scripts' );
	register_setting( 'hmp-settings', 'hmp_title' );
	//register_setting( 'hmp-settings', 'hmp_template_single' );
	//register_setting( 'hmp-settings', 'hmp_template_home' );
	//register_setting( 'hmp-settings', 'hmp_template_category' );
	//register_setting( 'hmp-settings', 'hmp_template_tag' );
	register_setting( 'hmp-settings', 'hmp_portfolio_menu_order' );
	register_setting( 'hmp-settings', 'hmp_post_type' );
	
}

function hmp_is_checked( $post_type, $enabled_post_types ) {
	
	if( in_array( $post_type, $enabled_post_types ) ) 
		echo 'checked="checked"';
}

function hmp_options_page() {
	?>
	
	<div class="wrap">
		<h2>Portfolio Settings</h2>
		
		<form method="post" action="options.php">
			<table class="form-table">
				
				<tr valign="top">
					<th scope="row"><strong>General</strong></th>
					<td>
						<input type="text" name="hmp_title" value="<?php echo get_option('hmp_title', 'Portfolio'); ?>" />
						<span class="description">Portfolio page title (default: Portfolio)</span>
					</td>
				</tr>
				<?php /*
				<tr valign="top">
					<th scope="row"><strong>Portfolio Link</strong></th>
					<td>
						<input type="checkbox" name="hmp_add_page_link" id="hmp_add_page_link" <?php echo get_option('hmp_add_page_link', 'on') ? ' checked="checked" ' : '' ?> />
						Add Link to Portfolio in main menu
						<p>
							<input class="small-text" type="text" name="hmp_portfolio_menu_order" value="<?php echo get_option('hmp_portfolio_menu_order', '0'); ?>" />
						<span class="description">Portfolio Menu Order</span>
						</p>
					</td>
				</tr>
				*/ ?>
				<tr valign="top">
					<th scope="row"><strong>Permalinks</strong></th>
					<td>
						<input type="text" name="hmp_url_base" value="<?php echo get_option('hmp_url_base', 'portfolio'); ?>" />
						<span class="description">Portfolio home URL (default: /portfolio/)</span>
						<p>
							<input type="text" name="hmp_single_base" value="<?php echo get_option('hmp_single_base', '/%category%/'); ?>" />
							<span class="description">Relative to the Portfolio URL. Use <code>%category%</code> for the category name. (default: /%category%/)</span>
						</p>
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