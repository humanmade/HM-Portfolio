<?php

function jhp_byline_meta_box( $post ) {
	?>
	<label for="jhp_byline">Byline
		<input type="text" name="jhp_byline" value="<?php jhp_get_byline( $post ) ?>" class="widefat" />
	</label>
	<?php
}

function jhp_brief_meta_box( $post ) {
	?>
	<textarea name="brief" class="widefat"><?php echo jhp_get_brief() ?></textarea>
	<?php
}
function jhp_brief_meta_box_submitted( $post ) {
	if ( isset( $_POST['brief'] ) )
		update_post_meta( $post->ID, '_brief', esc_html($_POST['brief']) );
}

function jhp_main_image_meta_box( $post ) {
	$ids = array_filter( array( jhp_get_main_image_id( $post ) ) );

	global $temp_ID;
    $post_image_id = $post->ID ? $post->ID : $temp_ID;

	global $temp_ID;
    $post_image_id = $post->ID ? $post->ID : $temp_ID;

	tj_register_custom_media_button( 'jhp_main_image', 'Main Image', true, false, 150, 150 );
	$non_added_text = "No Main Image Added " .  ( ($jh_url = jhp_get_url( $post ) ) ? '| <a href="' . esc_url( $jh_url ) . '" target="_blank">Screenshot your site now</a>' : '' );

	tj_add_image_html_custom( 'jhp_main_image', ($ids ? 'Change' : 'Add') . ' Main Image', $post_image_id, $ids, false, 'width=150&height=150&crop=1', $non_added_text );

}

function jhp_main_image_meta_box_submitted( $post ) {
	if ( isset( $_POST['jhp_main_image'] ) )
		update_post_meta( $post->ID, '_jhp_main_image', (int) $_POST['jhp_main_image'] );
}


function jhp_gallery_meta_box( $post ) {
	$image_ids = jhp_get_gallery_ids( $post );

	global $temp_ID;
    $post_image_id = $post->ID ? $post->ID : $temp_ID;

	tj_register_custom_media_button( 'jhp_gallery_images', 'Gallery Image', true, true, 150, 150 );
	$non_added_text = "No Gallery Images Added " .  ( ( $jh_url = jhp_get_url( $post ) ) ? '| <a href="' . esc_url( $jh_url ) . '" target="_blank">Screenshot your site now</a>' : '' );

	tj_add_image_html_custom( 'jhp_gallery_images', 'Add Gallery Images', $post_image_id, $image_ids, false, 'width=150&height=150&crop=1', $non_added_text );
}

function jhp_gallery_meta_box_submitted( $post ) {

	$images = array_filter( explode( ',', $_POST['jhp_gallery_images'] ) );

	if ( isset( $_POST['jhp_gallery_images'] ) )
		update_post_meta( $post->ID, '_jhp_gallery_images', $images );
}

function jhp_category_meta_box( $post ) {
	global $post;
	?>
	<p><label for="jh_portfolio_category">Category</label></p>
	<select name="jh_portfolio_category">
		<option value="">Select Category...</option>
		<?php
		$cats = get_terms('jh-portfolio-category', array( 'hide_empty' => false ) );
		$obj_cat = wp_get_object_terms($post->ID, 'jh-portfolio-category' );
		$obj_cat = $obj_cat[0];

		foreach( $cats as $cat ) : ?>
			<option <?php if($cat->term_id == $obj_cat->term_id) echo 'selected="selected" '; ?>value="<?php echo $cat->term_id ?>"><?php echo $cat->name ?></option>
		<?php
		endforeach;
		?>
	</select>
	<p><label for="jh_portfolio_new_category">Add New Category</label></p>
	<input name="jh_portfolio_new_category" type="text" />
	<?php
}
function jhp_category_meta_box_submitted( $post, $args = array() ) {

	if( $_POST['jh_portfolio_new_category'] )
		wp_set_object_terms( $post->ID, (string) $_POST['jh_portfolio_new_category'], 'jh-portfolio-category' );
	elseif( $_POST['jh_portfolio_category'] )
		wp_set_object_terms( $post->ID, (int) $_POST['jh_portfolio_category'], 'jh-portfolio-category' );
	elseif( $args['default'] ) {
		wp_set_object_terms( $post->ID, $args['default'], 'jh-portfolio-category' );
	}
}

function jhp_additional_information_meta_box( $post ) {
	?>
	<p><label>URL</label></p>
	<input id="website_url" type="text" name="url" value="<?php echo jhp_get_url($post) ?>" />
	<p><label>Related Work (post ID)</label></p>
	<input type="text" name="related_work" value="<?php echo implode( ', ', (array) get_post_meta( $post->ID, '_related_work', true ) ); ?>" />
	<?php
}
function jhp_additional_information_meta_box_submitted( $post ) {
	$related = explode( ',', esc_attr( $_POST['related_work'] ) );
	$related = array_map( 'absint', $related );

	if ( isset( $_POST['url'] ) )
		update_post_meta( $post->ID, '_url', esc_url($_POST['url']));

	if ( isset( $_POST['related_work'] ) )
		update_post_meta( $post->ID, '_related_work', $related );
} ?>