<?php
if( $_GET['action'] == 'delete' && is_numeric($_GET['term_id']) ) {
	wp_delete_term($_GET['term_id'], 'jh-portfolio-category');
}
if( $_POST['action'] == 'addtag' && $_POST['name'] ) {	
	$term = wp_insert_term( $_POST['name'], 'jh-portfolio-category' );
	$term = get_term( $term['term_id'], 'jh-portfolio-category');
}

if( $_POST['action'] == 'edittag' && $_POST['name'] ) {	
	$term = wp_update_term( (int) $_POST['term_id'], 'jh-portfolio-category', array( 'name' =>  $_POST['name'], 'slug' => sanitize_title( $_POST['name']) ) );
}

$jh_portfolio = new JH_Portfolio('query=posts');
?>
<div class="wrap">
	<h2><?php echo $title ?></h2>
	
	<div id="col-container">

		<div id="col-right">
			<div class="col-wrap">
				<input type="hidden" name="taxonomy" value="<?php echo esc_attr($taxonomy); ?>" />
				<div class="clear"></div>

				<table class="widefat tag fixed" cellspacing="0">
				    <thead>
				    	<tr>
				    		<th>Name</th>
				    		<th>Slug</th>
				    		<th>Entries</th>
				    	</tr>
				    </thead>
				
				    <tfoot>
				    	<tr>
				    		<th>Name</th>
				    		<th>Slug</th>
				    		<th>Entries</th>
				    	</tr>
				    </tfoot>

				    <tbody id="the-list" class="list:tag">
				    	<?php foreach( $jh_portfolio->get_portfolio_categories() as $cat ) : ?>
				    		<tr>
				    			<td>
				    				<strong><?php echo $cat->name ?></strong>
				    				<div class="row-actions">
				    					<span class="edit"><a href="#" class="inline-edit">Edit</a></span> | 
				    					<span class="delete"><a href="<?php echo add_query_arg('term_id', $cat->term_id, add_query_arg('action', 'delete')) ?>">Delete</a></span>
				    				</div>
				    				<div style="display:none;" class="inline-edit">
				    					<form action="?page=jh-portfolio/admin/admin.categories.php" method="post" name="edittag">
				    						<input type="text" name="name" value="<?php echo $cat->name ?>" />
				    						<input type="hidden" name="action" value="edittag" />
				    						<input type="hidden" name="term_id" value="<?php echo $cat->term_id ?>" />
				    						<input type="submit" name="submit" class="button" value="Save" />
				    						<a href="#" class="cancel button">Cancel</a>
				    					</form>
				    				</div>
				    			</td>
				    			<th><?php echo $cat->slug ?></th>
				    			<td><?php echo $cat->count ?></td>
				    		</tr>
				    	<?php endforeach; ?>
				    </tbody>
				</table>
				<br class="clear" />
			</div>
		</div><!-- /col-right -->

		<div id="col-left">
			<div class="col-wrap">

				<div class="form-wrap">
					<h3><?php _e('Add a New Category'); ?></h3>
					
					<form name="addtag" method="post" action="?page=jh-portfolio/admin/admin.categories.php" class="add:the-list: validate">
						<input type="hidden" name="action" value="addtag" />
						
						<div class="form-field form-required">
							<label for="name"><?php _e('Category name') ?></label>
							<input name="name" id="name" type="text" value="" size="40" aria-required="true" />
						</div>
						
						<p class="submit"><input type="submit" class="button" name="submit" value="<?php esc_attr_e('Add Category'); ?>" /></p>
					</form>
				</div>

			</div>
		</div><!-- /col-left -->

	</div><!-- /col-container -->
</div><!-- /wrap -->

<?php inline_edit_term_row('edit-tags'); ?>

</div>