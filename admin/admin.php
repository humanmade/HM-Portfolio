<?php

include('cwp-framework/cwp-framework.php');
include('meta-boxes.php');
include_once( 'media-uploader.extensions.php' );

add_action( 'init', 'jhp_admin_setup' );
function jhp_admin_setup() {
	$admin = new Admin_Section( 'Portfolio', __FILE__, 'menu_order=6&icon=' . str_replace( ABSPATH , trailingslashit(get_bloginfo('wpurl')), dirname( __FILE__ ) . '/icon.png') );
	
	$manage = $admin->add_page( 'manage', 'Manage Entries', $parent = true, 'single=Entry&multiple=Entries&title=Manage Entries&edit=Add Entry' );
	$manage->query( 'post_type=jh-portfolio' );
	$manage->set_table_column( 'cb' );
	$manage->set_table_column( 'title', 'Entry Name' );
	$manage->set_table_column( 'jh-portfolio-category', 'Category', 'edit=Categories' );
	$manage->set_table_column( 'date', 'Publish Date' );
	$manage->add_filter( 'type=taxonomy&taxonomy=jh-portfolio-category&single=category&multiple=categories' );
	
	$edit = $admin->add_page( 'edit', 'Add Entry', false, 'single=Entry&multiple=Entries' );
	
	$edit->add_meta_box( 'publish' );
	$edit->add_meta_box( 'brief', 'The Brief', 'normal', 'jhp_brief_meta_box' );
	$edit->add_meta_box( 'main-image', 'Main Image', 'normal', 'jhp_main_image_meta_box' );
	$edit->add_meta_box( 'additional-images', 'Gallery', 'normal', 'jhp_gallery_meta_box' );
	$edit->add_meta_box( 'category', 'Category', 'side', 'jhp_category_meta_box' );
	$edit->add_meta_box( 'additional-info', 'Additional Information', 'side', 'jhp_additional_information_meta_box' );
	$edit->add_post_arg( 'post_type', 'jh-portfolio' );
	
	$edit->enqueue_script( 'jhp-common.js', str_replace( ABSPATH, trailingslashit(get_bloginfo('wpurl')), dirname( __FILE__ ) ) . '/common.js', array( 'jquery' ) );
	
	$cats = $admin->add_page( 'taxonomy', 'Categories', false, 'single=Category&multiple=Categories&taxonomy=jh-portfolio-category' );
	
	$settings = $admin->add_page( 'settings', 'JH Portfolio', false, 'callback=jhp_settings_page' );
	$settings->register_setting( 'jhp_url_base' );
	$settings->add_settings_section( 'general', 'General Settings' );
	$settings->add_settings_field( 'jhp_url_base', 'Portfolio Base', '<br />The portfolio base is the url to the portfolio home page, you can use multiple "/". E.g <code>web/portfolio</code>', 'general', 'portfolio' );
	
	$admin->check_for_submitted();
}

function jhp_settings_page( $page ) {
	?>
	<h4><?php _e('General'); ?></h4>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="jh_portfolio_base"><?php _e('Portfolio base'); ?></label></th>
			<td><input name="jh_portfolio_base" type="text" id="jh_portfolio_base" value="<?php echo get_option('jh_portfolio_base', 'portfolio'); ?>" class="regular-text code" />
				<span class="description"><?php _e('Default is <code>portfolio</code>'); ?></span><br />
				<small>The portfolio base is the url to the portfolio home page, you can use multiple "/". E.g <code>web/portfolio</code></small>
			</td>
		</tr>
	</table>
	<?php
}

?>