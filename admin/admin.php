<?php
include_once('meta-boxes.php');

add_action( 'admin_menu', 'jhp_add_meta_boxes' );
function jhp_add_meta_boxes() {
	add_meta_box( 'brief', 'Brief', 'jhp_brief_meta_box', 'jh-portfolio', 'normal', 'high' );
	add_meta_box( 'main-image', 'Main Image', 'jhp_main_image_meta_box', 'jh-portfolio', 'normal', 'high' );
	add_meta_box( 'additional-images', 'Gallery', 'jhp_gallery_meta_box', 'jh-portfolio', 'normal', 'high' );
	add_meta_box( 'additional-info', 'Additional Information', 'jhp_additional_information_meta_box', 'jh-portfolio', 'side', 'low' );
	
	//register the options page
	jhp_register_settings();
	add_options_page('Portfolio Settings', 'JH Portfolio', 'manage_options', 'jh-portfolio-options', 'jhp_options_page');	
}

add_action( 'wp_insert_post', 'jhp_insert_post', 10, 2 );
function jhp_insert_post( $post_id, $post ) {
	
	if( $post->post_type !== 'jh-portfolio' )
		return;
	
	//fire all the beta box _submitted functions
	jhp_brief_meta_box_submitted( $post );
	jhp_main_image_meta_box_submitted( $post );
	jhp_gallery_meta_box_submitted( $post );
	jhp_additional_information_meta_box_submitted( $post );
}

function jhp_register_settings() {
	
	register_setting( 'jhp-settings', 'jhp_url_base' );
	register_setting( 'jhp-settings', 'jhp_single_base' );
	register_setting( 'jhp-settings', 'jhp_add_page_link' );
	register_setting( 'jhp-settings', 'jhp_use_styles' );
	register_setting( 'jhp-settings', 'jhp_use_scripts' );
	register_setting( 'jhp-settings', 'jhp_title' );
	register_setting( 'jhp-settings', 'jhp_template_single' );
	register_setting( 'jhp-settings', 'jhp_template_home' );
	register_setting( 'jhp-settings', 'jhp_portfolio_menu_order' );
	
}

function jhp_options_page() {

	?>
	
	<div class="wrap">
		<h2>Portfolio Settings</h2>
		
		<form method="post" action="options.php">
			<table class="form-table">
				
				<tr valign="top">
					<th scope="row"><strong>General</strong></th>
					<td>
						<input type="text" name="jhp_title" value="<?php echo get_option('jhp_title', 'Portfolio'); ?>" />
						<span class="description">Portfolio page title (default: Portfolio)</span>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><strong>Portfolio Link</strong></th>
					<td>
						<input type="checkbox" name="jhp_add_page_link" id="jhp_add_page_link" <?php echo get_option('jhp_add_page_link', 'on') ? ' checked="checked" ' : '' ?> />
						Add Link to Portfolio in main menu
						<p>
							<input class="small-text" type="text" name="jhp_portfolio_menu_order" value="<?php echo get_option('jhp_portfolio_menu_order', '0'); ?>" />
						<span class="description">Portfolio Menu Order</span>
						</p>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><strong>Permalinks</strong></th>
					<td>
						<input type="text" name="jhp_url_base" value="<?php echo get_option('jhp_url_base', 'portfolio'); ?>" />
						<span class="description">Portfolio home URL (default: /portfolio/)</span>
						<p>
							<input type="text" name="jhp_single_base" value="<?php echo get_option('jhp_single_base', '/%category%/'); ?>" />
							<span class="description">Relative to the Portfolio URL. Use <code>%category%</code> for the category name. (default: /%category%/)</span>
						</p>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><strong>JavaScript & CSS</strong></th>
					<td>
						<input type="checkbox" name="jhp_use_scripts" id="jhp_use_scripts" <?php echo get_option('jhp_use_scripts', 'on') ? ' checked="checked" ' : '' ?> />
						Use JH Portfolio JavaScript
						<p>
							<input type="checkbox" name="jhp_use_styles" id="jhp_use_styles" <?php echo get_option('jhp_use_styles', 'on') ? ' checked="checked" ' : '' ?> />
							Use JH Portfolio CSS
						</p>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><strong>Custom Templates</strong></th>
					<td>
						<input type="text" name="jhp_template_home" value="<?php echo get_option('jhp_template_home', 'portfolio-home.php'); ?>" />
						<span class="description">Home Template</span>
						<p>
							<input type="text" name="jhp_template_single" value="<?php echo get_option('jhp_template_single', 'portfolio-single.php'); ?>" />
							<span class="description">Single Template</span>
						</p>
					</td>
				</tr>
				
			</table>
			
			<input type="hidden" name="action" value="update" />
			
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
			
			<?php 
			settings_fields( 'jhp-settings' );
			
			// Output any sections defined for page sl-settings
			do_settings_sections('jhp-settings'); 
			?>
		</form>
	</div>
	<?php
}


//add_action( 'init', 'jhp_admin_setup' );
function jhp_admin_setup() {
	
	add_action( 'cwp_settings_page_below_form_' . $settings->get_page_id(), 'jhp_add_error_report_button' );
	
	// debug
	$debug = $admin->add_page( 'debug', 'Debug', null, array( 'email' => 'info@joehoyle.co.uk' ) );
	$debug->add_debug_info( array(
		'options' => array( 
			'jhp_url_base' => get_option('jhp_url_base'),
			'jhp_single_base' => get_option('jhp_single_base'),
			'jhp_title' => get_option('jhp_title'),
			'jhp_add_page_link' => get_option('jhp_add_page_link'),
			'jhp_use_styles' => get_option( 'jhp_use_styles' ),
			'jhp_use_scripts' => get_option( 'jhp_use_scripts' ),
			'jhp_template_home' => get_option( 'jhp_template_home', 'portfolio-home.php' ),
			'jhp_template_single' => get_option( 'jhp_template_single', 'portfolio-single.php' )
		),
		'template' => array( 
		    'home_exists' => file_exists( get_template_directory() . '/' . get_option( 'jhp_template_home', 'portfolio-home.php' ) ),
		    'single_exists' => file_exists( get_template_directory() . '/' . get_option( 'jhp_template_single', 'portfolio-single.php' ) ),
		),
		'data' => array(
		    'categories' => get_terms( 'jh-portfolio-category', array('hide_empty' => false) ),
		    'tags' => get_terms( 'jh-portfolio-tag', array('hide_empty' => false) ),
		    'entries' => get_posts( 'post_type=jh-portfolio&post_status=any' ),
		),
	));
	
}

function jhp_add_error_report_button( $page ) {
	?>
	<p>
	<a href="<?php echo $page->admin_section->pages['cwp_debug_page_debug']->get_remote_send_report_url() ?>" class="button">Submit Error Report</a>
	</p>
	<p>
		<small>By clicking the above link you agree to sending an email to the author of JH Portfolio container information on your JH Portfolio setup, data and options. To view the error report without sending click <a href="<?php echo $page->admin_section->pages['cwp_debug_page_debug']->get_page_url() ?>">here.</small>

	</p>
	<?php
}
?>