<?php
include('meta-boxes.php');

add_action( 'init', 'jhp_admin_setup' );
function jhp_admin_setup() {
	global $current_user;
	
	//spoof wordpress into think we can publish the custom post type for portfolio items to show post date edit
	if( current_user_can( 'publish_posts' ) ) {
		$current_user->allcaps['publish_jh-portfolios'] = true;
	}
	
	$admin = new Admin_Section( 'Portfolio', __FILE__, 'menu_order=6&icon=' . str_replace( ABSPATH , trailingslashit(get_bloginfo('wpurl')), dirname( __FILE__ ) . '/icon.png') );
	
	$manage = $admin->add_page( 'manage', 'Edit', $parent = true, 'single=Entry&multiple=Entries&title=Manage Entries&edit=Add New' );
	$manage->query( 'post_type=jh-portfolio' );
	$manage->set_table_column( 'cb' );
	$manage->set_table_column( 'title', 'Entry Name' );
	$manage->set_table_column( 'jh-portfolio-category', 'Category', 'edit=Categories' );
	$manage->set_table_column( 'jh-portfolio-tag', 'Tags', 'edit=Tags' );
	$manage->set_table_column( 'date', 'Publish Date' );
	$manage->add_filter( 'type=taxonomy&taxonomy=jh-portfolio-category&single=category&multiple=categories' );
	$manage->add_post_stati( 'publish', 'Published' );
	$manage->add_post_stati( 'trash', 'Trash' );
	
	$edit = $admin->add_page( 'edit', 'Add New', false, 'single=Entry&multiple=Entries' );
	
	$edit->add_meta_box( 'publish' );
	$edit->add_meta_box( 'taxonomy', null, null, null, 'title=Tags&taxonomy=jh-portfolio-tag' );
	$edit->add_meta_box( 'brief', 'The Brief', 'normal', 'jhp_brief_meta_box' );
	$edit->add_meta_box( 'main-image', 'Main Image', 'normal', 'jhp_main_image_meta_box' );
	$edit->add_meta_box( 'additional-images', 'Gallery', 'normal', 'jhp_gallery_meta_box' );
	$edit->add_meta_box( 'category', 'Category', 'side', 'jhp_category_meta_box', 'default=Uncategorized' );
	$edit->add_meta_box( 'additional-info', 'Additional Information', 'side', 'jhp_additional_information_meta_box' );
	$edit->add_meta_box( 'postcustom', __('Custom Fields'), 'normal', 'post_custom_meta_box' );
	
	$edit->add_post_arg( 'post_type', 'jh-portfolio' );
	$edit->add_post_arg( 'comment_status', 'closed' );
	
	$cats = $admin->add_page( 'taxonomy', 'Tags', false, 'single=Tag&multiple=Tags&taxonomy=jh-portfolio-tag' );
	$cats = $admin->add_page( 'taxonomy', 'Categories', false, 'single=Category&multiple=Categories&taxonomy=jh-portfolio-category' );

	$settings = $admin->add_page( 'settings', 'JH Portfolio', false, 'callback=jhp_settings_page' );
	$settings->register_setting( 'jhp_url_base' );
	$settings->register_setting( 'jhp_single_base' );
	$settings->register_setting( 'jhp_add_page_link' );
	$settings->register_setting( 'jhp_use_styles' );
	$settings->register_setting( 'jhp_use_scripts' );
	$settings->register_setting( 'jhp_title' );
	$settings->register_setting( 'jhp_template_single' );
	$settings->register_setting( 'jhp_template_home' );
	$settings->register_setting( 'jhp_portfolio_menu_order' );
	
	$settings->add_settings_section( 'general', 'General Settings' );
	$settings->add_settings_field( 'jhp_url_base', 'Portfolio URL', '<br />The portfolio base is the url to the portfolio home page, you can use multiple "/". E.g <code>web/portfolio</code>', 'general', 'portfolio' );
	$settings->add_settings_field( 'jhp_single_base', 'Single URL', '<br />Relative to the Portfolio URL. Use <code>%category%</code> for the category name.', 'general', '%category%' );
	$settings->add_settings_field( 'jhp_title', 'Portfolio Title', 'The portfolio title in the page menu etc.', 'general', 'Portfolio' );

	$settings->add_settings_field( 'jhp_add_page_link', 'Add Link to Portfolio in menu', 'Controls whether to hook into your themes menu and show a link to the Portfolio', 'general', 'on', 'type=checkbox' );
	$settings->add_settings_field( 'jhp_portfolio_menu_order', 'Portfolio Menu Order', 'The order in the menu where the Portfolio link appears', 'general', '0');
	$settings->add_settings_field( 'jhp_use_styles', 'Use JH Portfolio CSS Styles', 'The JH Portfolio default styles will not be added if you are using custom template files.', 'general', 'on', 'type=checkbox' );
	$settings->add_settings_field( 'jhp_use_scripts', 'Use JH Portfolio Javascript', 'The Javascript adds effects such as Ligthbox to the Entry Gallery widgets', 'general', 'on', 'type=checkbox' );
	
	$settings->add_settings_section( 'template', 'Custom Templtes' );
	$settings->add_settings_field( 'jhp_template_home', 'Home Template', 'Relative to your theme folder ', 'template', 'portfolio-home.php' );
	$settings->add_settings_field( 'jhp_template_single', 'Single Template', 'Relative to your theme folder ', 'template', 'portfolio-single.php' );
	
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
	
	$admin->check_for_submitted();
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