<?php
include('meta-boxes.php');

add_action( 'init', 'jhp_admin_setup' );
function jhp_admin_setup() {
	$admin = new Admin_Section( 'Portfolio', __FILE__, 'menu_order=6&icon=' . str_replace( ABSPATH , trailingslashit(get_bloginfo('wpurl')), dirname( __FILE__ ) . '/icon.png') );
	
	$manage = $admin->add_page( 'manage', 'Manage Entries', $parent = true, 'single=Entry&multiple=Entries&title=Manage Entries&edit=Add Entry' );
	$manage->query( 'post_type=jh-portfolio' );
	$manage->set_table_column( 'cb' );
	$manage->set_table_column( 'title', 'Entry Name' );
	$manage->set_table_column( 'jh-portfolio-category', 'Category', 'edit=Categories' );
	$manage->set_table_column( 'jh-portfolio-tag', 'Tags', 'edit=Tags' );
	$manage->set_table_column( 'date', 'Publish Date' );
	$manage->add_filter( 'type=taxonomy&taxonomy=jh-portfolio-category&single=category&multiple=categories' );
	
	$edit = $admin->add_page( 'edit', 'Add Entry', false, 'single=Entry&multiple=Entries' );
	
	$edit->add_meta_box( 'publish' );
	$edit->add_meta_box( 'taxonomy', null, null, null, 'title=Tags&taxonomy=jh-portfolio-tag' );
	$edit->add_meta_box( 'brief', 'The Brief', 'normal', 'jhp_brief_meta_box' );
	$edit->add_meta_box( 'main-image', 'Main Image', 'normal', 'jhp_main_image_meta_box' );
	$edit->add_meta_box( 'additional-images', 'Gallery', 'normal', 'jhp_gallery_meta_box' );
	$edit->add_meta_box( 'category', 'Category', 'side', 'jhp_category_meta_box' );
	$edit->add_meta_box( 'additional-info', 'Additional Information', 'side', 'jhp_additional_information_meta_box' );
	$edit->add_post_arg( 'post_type', 'jh-portfolio' );
	
	$edit->enqueue_script( 'jhp-common.js', str_replace( ABSPATH, trailingslashit(get_bloginfo('wpurl')), dirname( __FILE__ ) ) . '/common.js', array( 'jquery' ) );
	
	$cats = $admin->add_page( 'taxonomy', 'Categories', false, 'single=Category&multiple=Categories&taxonomy=jh-portfolio-category' );
	$cats = $admin->add_page( 'taxonomy', 'Tags', false, 'single=Tag&multiple=Tags&taxonomy=jh-portfolio-tag' );

	$settings = $admin->add_page( 'settings', 'JH Portfolio', false, 'callback=jhp_settings_page' );
	$settings->register_setting( 'jhp_url_base' );
	$settings->register_setting( 'jhp_single_base' );
	$settings->register_setting( 'jhp_add_page_link' );
	$settings->register_setting( 'jhp_use_styles' );
	$settings->register_setting( 'jhp_use_scripts' );
	$settings->register_setting( 'jhp_title' );
	$settings->register_setting( 'jhp_template_single' );
	$settings->register_setting( 'jhp_template_home' );
	
	$settings->add_settings_section( 'general', 'General Settings' );
	$settings->add_settings_field( 'jhp_url_base', 'Portfolio URL', '<br />The portfolio base is the url to the portfolio home page, you can use multiple "/". E.g <code>web/portfolio</code>', 'general', 'portfolio' );
	$settings->add_settings_field( 'jhp_single_base', 'Single URL', '<br />Relative to the Portfolio URL. Use <code>%category%</code> for the category name.', 'general', '%category%' );
	$settings->add_settings_field( 'jhp_title', 'Portfolio Title', 'The portfolio title in the page menu etc.', 'general', 'Portfolio' );

	$settings->add_settings_field( 'jhp_add_page_link', 'Add Link to Portfolio in menu', 'Controls whether to hook into your themes menu and show a link to the Portfolio', 'general', 'on', 'type=checkbox' );
	$settings->add_settings_field( 'jhp_use_styles', 'Use JH Portfolio CSS Styles', 'The JH Portfolio default styles will not be added if you are using custom template files.', 'general', 'on', 'type=checkbox' );
	$settings->add_settings_field( 'jhp_use_scripts', 'Use JH Portfolio Javascript', 'The Javascript adds effects such as Ligthbox to the Entry Gallery widgets', 'general', 'on', 'type=checkbox' );
	
	$settings->add_settings_section( 'template', 'Custom Templtes' );
	$settings->add_settings_field( 'jhp_template_home', 'Home Template', 'Relative to your theme folder ', 'template', 'portfolio.home.php' );
	$settings->add_settings_field( 'jhp_template_single', 'Single Template', 'Relative to your theme folder ', 'template', 'portfolio.single.php' );
	
	$admin->check_for_submitted();
}
?>