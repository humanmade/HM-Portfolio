<?php
function jhp_get_byline( $post = null ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_byline()' );
	return hmp_get_byline( $post );
}
function jhp_get_brief( $post = null ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_brief()' );
	return hmp_get_brief( $post );
}
function jhp_get_url( $post = null ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_url()' );
	return hmp_get_url( $post );
}
function jhp_get_related_work( $post = null) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_related_work()' );
	return hmp_get_related_work( $post ); 
}
function jhp_has_info( $post = null, $string = '_url,_related_work' ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_has_info()' );
	return hmp_has_info( $post, $string );
}
function jhp_get_the_category( $post = null ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_the_category()' );
	return hmp_get_the_category( $post );
}
function jhp_get_category_link( $id ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_category_link()' );
	return hmp_get_category_link( $id ); 
}
function jhp_in_category( $category, $post = null ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_in_category()' );
	return hmp_in_category( $category, $post );
}
function jhp_the_category(  $separator = '', $parents='', $post = null ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_the_category()' );
	return hmp_the_category( $separator, $parents, $post );
}
function jhp_get_the_tags( $id = 0 ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_the_tags()' );
	return hmp_get_the_tags( $id );
}
function jhp_get_the_tag_list( $before = '', $sep = '', $after = '' ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_the_tag_list()' );
	return hmp_get_the_tag_list( $before, $sep, $after );
}
function jhp_the_tags( $before = null, $sep = ', ', $after = '' ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_the_tags()' );
	return hmp_the_tags( $before, $sep, $after );
}
function jhp_get_main_image( $post = null, $w = 0, $h = 0, $crop = false ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_main_image()' );
	return hmp_get_main_image( $post, $w, $crop );	
}
function jhp_get_main_image_id( $post = null ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_main_image_id()' );
	return hmp_get_main_image_id( $post );
}
function jhp_get_gallery_images( $post = null, $w = 0, $h = 0, $crop = false ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_gallery_images()' );
	return hmp_get_gallery_images( $post, $w, $h, $crop ); 
}
function jhp_get_gallery_image( $id, $w = 0, $h = 0, $crop = false ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_gallery_image()' );
	return hmp_get_gallery_image( $id, $w, $h, $crop );
}
function jhp_get_gallery_ids( $post = null ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_gallery_ids()' );
	return hmp_get_gallery_ids( $post );
}
function jhp_default_query_vars() {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_default_query_vars()' );
	return hmp_default_query_vars();
}
function jhp_is_home() {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_is_home()' );
	return hmp_is_home();
}
function jhp_is_single() {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_is_single()' );
	return hmp_is_single();
}
function jhp_is_portfolio() {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_is_portfolio()' );
	return hmp_is_portfolio();
}
function jhp_get_single_permalink_structure() {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_single_permalink_structure()' );
	return hmp_get_single_permalink_structure();
}
?>