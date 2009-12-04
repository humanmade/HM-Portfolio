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
	update_post_meta( $post->ID, 'brief', esc_html($_POST['brief']) );
}

function jhp_main_image_meta_box( $post ) {
	$image = jhp_get_main_image( $post, 150, 150, true );
	$id = jhp_get_main_image_id( $post );
	?>
	<p style="display: block; float: right">
		<?php
		register_custom_media_button( 'jhp_main_image', 'Main Image' );
		?>
		<a class="add-image button thickbox" onclick="return false;" title="Add Image" href="media-upload.php?button=jhp_main_image&amp;type=image&amp;TB_iframe=true&amp;width=640&amp;height=197">
			<?php echo $image ? 'Change' : 'Add' ?> Main Image
		</a>
		<input type="hidden" name="jhp_main_image" id="jhp_main_image" value="<?php echo jhp_get_main_image_id( $post ) ?>" />
	</p>
	
	<div style="padding: 0 10px; float: left;" id="jhp_main_image_container">
		<?php if( $image ) : ?>
			<span class="image-wrapper" id="<?php echo $id ?>"><img src="<?php echo $image ?>" />
			<a class="delete_custom_image" rel="jhp_main_image:<?php echo $id ?>">Delete</a> | </span>
		<?php else: ?>
			<p class="empty-message">No Main Image Added</p>
		<?php endif; ?>
	</div>
	<div style="clear: both;" /></div>
	<?php
}

function jhp_main_image_meta_box_submitted( $post ) {
	update_post_meta( $post->ID, 'jhp_main_image', (int) $_POST['jhp_main_image'] );
}


function jhp_gallery_meta_box( $post ) {
	$images = jhp_get_gallery_images( $post, 150, 150, true );
	$image_ids = jhp_get_gallery_ids( $post );
	?>
	<style>
		.image-wrapper { text-align: center; display: block; padding: 5px; border: 1px solid #DFDFDF; float: left; margin-right: 7px; margin-bottom: 7px; }
		.image-wrapper img { display: block; }
	</style>
	<p style="display: block; float: right">
		<?php
		register_custom_media_button( 'jhp_gallery_images', 'Gallery Image' );
		?>
		<a class="add-image button thickbox" onclick="return false;" title="Add Image" href="media-upload.php?button=jhp_gallery_images&amp;multiple=yes&amp;type=image&amp;TB_iframe=true&amp;width=640&amp;height=197">
			Add Gallery Image
		</a>
		<input type="hidden" name="jhp_gallery_images" id="jhp_gallery_images" value="<?php echo implode( ',', jhp_get_gallery_ids( $post ) ) ?>" />
	</p>
	
	<div style="padding: 0 10px; float: left;" id="jhp_gallery_images_container">
		<?php if( $image_ids ) : ?>
		
			<?php foreach( $image_ids as $id ) : ?>
				<span class="image-wrapper" id="<?php echo $id ?>"><img src="<?php echo $images[$id] ?>" />
				<a class="delete_custom_image" rel="jhp_gallery_images:<?php echo $id ?>">Delete</a> | </span>
			<?php endforeach; ?>
		
		<?php else: ?>
			<p class="empty-message">No Gallery Images Added</p>
		<?php endif; ?>
	</div>
	<div style="clear: both;" /></div>
	<?php
}

function jhp_gallery_meta_box_submitted( $post ) {
	$images = array_filter( explode( ',', $_POST['jhp_gallery_images'] ) );
	update_post_meta( $post->ID, 'jhp_gallery_images', $images );
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
function jhp_category_meta_box_submitted( $post ) {
	if( $_POST['jh_portfolio_new_category'] )
		wp_set_object_terms( $post->ID, (string) $_POST['jh_portfolio_new_category'], 'jh-portfolio-category' );
	elseif( $_POST['jh_portfolio_category'] )
		wp_set_object_terms( $post->ID, (int) $_POST['jh_portfolio_category'], 'jh-portfolio-category' );
}

function jhp_additional_information_meta_box( $post ) {
	?>
	<p><label>URL</label></p>
	<input id="website_url" type="text" name="url" value="<?php echo jhp_get_url($post) ?>" />
	<p><label>Related Work (post ID)</label></p>
	<input type="text" name="related_work" value="<?php echo get_post_meta( $post->ID, 'related_work', true ); ?>" />
	<?php
}
function jhp_additional_information_meta_box_submitted( $post ) {
	update_post_meta( $post->ID, 'url', esc_html($_POST['url']));
	update_post_meta( $post->ID, 'related_work', esc_html($_POST['url']) );
}
?>