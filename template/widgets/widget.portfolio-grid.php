<?php
### Class: JH Portfolio Selector
class WP_Widget_JH_Portfolio_Grid extends WP_Widget {
	// Constructor
	function WP_Widget_JH_Portfolio_Grid() {
		$widget_ops = array( 'description' => __( 'Show a grid of all portfolio entries with thumbnails' ) );
		$this->WP_Widget( 'jh_portfolio_grid', __( 'JHP Grid' ), $widget_ops );
	}
 
	// Display Widget
	function widget( $args, $instance ) {	
		global $post, $wp_query;
		$post_backup = $post;
		$wp_query_backup = $wp_query;
		
		extract( $args, EXTR_SKIP );
		extract( $instance );
						
		echo $before_widget;
		
		
		//Modify the global jh_portfolio to respect the order in the widget
		$query_vars = $jh_portfolio->query_vars;
		$query_vars['orderby'] = $sort_by;
		$jh_portfolio = new WP_Query( $query_vars );

		$orig = $jh_portfolio; ?>
		<div id="jh-portfolio-grid">
			<?php foreach( get_terms( 'jh-portfolio-category', array( 'parent' => 0 ) ) as $cat ) :
			 ?>
				<?php $jh_portfolio = new WP_Query( array( 'taxonomy' => 'jh-portfolio-category', 'term' => $cat->slug, 'showposts' => -1, 'orderby' => $sort_by, 'post_type' => 'jh-portfolio') ); ?>
				<ul id="<?php echo $cat->slug ?>">
					<li><strong><?php echo $cat->name ?></strong></li>
					
					<li>
						<ul>
						
							<?php while( $jh_portfolio->have_posts() ): $jh_portfolio->the_post(); global $post; ?>
								<li>
									<?php if( $image = jhp_get_main_image( null, $image_width, $image_height, true ) ) : ?>
										<a class="<?php if( $orig->post->ID == get_the_id() ) echo 'active' ?>" href="<?php the_permalink() ?>" rel="<?php echo get_the_id() ?>"><img id="main-image" alt="<?php the_title() ?>" src="<?php echo $image ?>" /></a>
									<?php endif; ?>
									<a class="<?php if( $orig->post->ID == get_the_id() ) echo 'active' ?>" href="<?php the_permalink() ?>" rel="<?php echo get_the_id() ?>"><?php echo $post->post_title ?></a>
								</li>
							<?php endwhile; ?>
						
						</ul>
					</li>
					
				</ul>
			<?php endforeach; ?>
			

		</div>	
		<?php
		echo $after_widget;
		
		//restore old data
		$post = $post_backup;
		$wp_query = $wp_query_backup;
	
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['image_width'] = (int) strip_tags( $new_instance['image_width'] );
		$instance['image_height'] = (int) strip_tags( $new_instance['image_height'] );
		$instance['sort_by'] = strip_tags( $new_instance['sort_by'] );

		$hidden_cats = array();
		foreach( get_terms('jh-portfolio-category') as $cat ) {
			$instance['cat_' . $cat->term_id] = (int) strip_tags( $new_instance['cat_' . $cat->term_id] );
			if( $new_instance['show_cat_' . $cat->term_id] !== 'on' )
				$hidden_cats[(int) $cat->term_id] = (int) $cat->term_id;
						
			update_post_meta( $cat->term_id, 'menu_order', $new_instance['cat_' . $cat->term_id] );
		}
		$instance['hidden_cats'] = $hidden_cats;
		return $instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array( 'image_width' => 100, 'image_height' => 50 ) );
		
		$width = intval( $instance['image_width'] );
		$height = intval( $instance['image_height'] );
		$sort = esc_attr( $instance['sort_by'] );
		
		$jh_portfolio = new WP_Query('showposts=-1');
		
		?>

		<p>
			<label for="<?php echo $this->get_field_id('image_width'); ?>">
				<?php _e('Image Width:'); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('image_width'); ?>" name="<?php echo $this->get_field_name('image_width'); ?>" type="text" value="<?php echo $width; ?>" />
			</label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('image_height'); ?>">
				<?php _e('Image Height:'); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('image_height'); ?>" name="<?php echo $this->get_field_name('image_height'); ?>" type="text" value="<?php echo $height; ?>" />
			</label>
		</p>
		
		<p>
			<label><strong><?php _e('Category Order:'); ?></strong></label><br />
			<?php foreach( get_terms('jh-portfolio-category', array( 'parent' => 0 )) as $cat ) : ?>
				<label for="<?php echo $this->get_field_id('cat_' . $cat->term_id); ?>" style="clear: both; display: block;">
					<input type="checkbox" <?php if( !$instance['hidden_cats'][$cat->term_id] ) echo 'checked="checked"'; ?> name="<?php echo $this->get_field_name('show_cat_' . $cat->term_id); ?>" id="<?php echo $this->get_field_id('show_cat_' . $cat->term_id); ?>" />
					<?php _e($cat->name); ?>
					<?php $var_name = 'cat_' . $cat->term_id; ?>
					<input style="width: 40px; float:right" type="text" name="<?php echo $this->get_field_name('cat_' . $cat->term_id); ?>" id="<?php echo $this->get_field_id('cat_' . $cat->term_id); ?>" value="<?php echo (int) $instance[$var_name] ?>" />
				</label>
			<?php endforeach; ?>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('sort_by'); ?>">
				<?php _e('Sort Entries By:'); ?>
					<select style="float: right" name="<?php echo $this->get_field_name('sort_by'); ?>" id="<?php echo $this->get_field_id('sort_by'); ?>">
						<option <?php selected( $sort, 'post_name' ) ?> value="post_name">Entry Name</option>
						<option <?php selected( $sort, 'post_date' ) ?> value="post_date">Date Created</option>
						<option <?php selected( $sort, 'post_modified' ) ?> value="post_modified">Date Updated</option>
					</select>
			</label>
		</p>
		
	<?php
	
	}

}
 
 
### Function: Init Table News Widget
add_action('widgets_init', 'widget_jh_portfolio_grid');
function widget_jh_portfolio_grid() {
	register_widget( 'WP_Widget_JH_Portfolio_Grid' );
}
?>