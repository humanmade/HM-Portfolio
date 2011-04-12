<?php
function jhp_get_byline( $post = null ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_byline()' );
	hmp_get_byline( $post );
}
function jhp_get_brief( $post = null ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_brief()' );
	hmp_get_brief( $post );
}
function jhp_get_url( $post = null ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_url()' );
	hmp_get_url( $post );
}
function jhp_get_related_work( $post = null) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_related_work()' );
	hmp_get_related_work( $post ); 
}
function jhp_has_info( $post = null, $string = '_url,_related_work' ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_has_info()' );
	hmp_has_info( $post, $string );
}
function jhp_get_the_category( $post = null ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_the_category()' );
	hmp_get_the_category( $post );
}
function jhp_get_category_link( $id ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_category_link()' );
	hmp_get_category_link( $id ); 
}
function jhp_in_category( $category, $post = null ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_in_category()' );
	hmp_in_category( $category, $post );
}
function jhp_the_category(  $separator = '', $parents='', $post = null ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_the_category()' );
	hmp_the_category( $separator, $parents, $post );
}
function jhp_get_the_tags( $id = 0 ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_the_tags()' );
	hmp_get_the_tags( $id );
}
function jhp_get_the_tag_list( $before = '', $sep = '', $after = '' ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_the_tag_list()' );
	hmp_get_the_tag_list( $before, $sep, $after );
}
function jhp_the_tags( $before = null, $sep = ', ', $after = '' ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_the_tags()' );
	hmp_the_tags( $before, $sep, $after );
}
function jhp_get_main_image( $post = null, $w = 0, $h = 0, $crop = false ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_main_image()' );
	hmp_get_main_image( $post, $w, $crop );	
}
function jhp_get_main_image_id( $post = null ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_main_image_id()' );
	hmp_get_main_image_id( $post );
}
function jhp_get_gallery_images( $post = null, $w = 0, $h = 0, $crop = false ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_gallery_images()' );
	hmp_get_gallery_images( $post, $w, $h, $crop ); 
}
function jhp_get_gallery_image( $id, $w = 0, $h = 0, $crop = false ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_gallery_image()' );
	hmp_get_gallery_image( $id, $w, $h, $crop );
}
function jhp_get_gallery_ids( $post = null ) {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_gallery_ids()' );
	hmp_get_gallery_ids( $post );
}
function jhp_default_query_vars() {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_default_query_vars()' );
	hmp_default_query_vars();
}
function jhp_is_home() {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_is_home()' );
	hmp_is_home();
}
function jhp_is_single() {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_is_single()' );
	hmp_is_single();
}
function jhp_is_portfolio() {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_is_portfolio()' );
	hmp_is_portfolio();
}
function jhp_get_single_permalink_structure() {
	_deprecated_function( __FUNCTION__, '0.9.8', 'hmp_get_single_permalink_structure()' );
	hmp_get_single_permalink_structure();
}
?>