<?php
### Class: JH Portfolio Selector
 class WP_Widget_JHP_Gallery extends WP_Widget {
	// Constructor
	function WP_Widget_JHP_Gallery() {
		$widget_ops = array( 'description' => __( 'Shows the portfolio entry\'s gallery', 'table_rss_news' ) );
		$this->WP_Widget( 'jh_portfolio_gallery', __( 'JH Portfolio Gallery' ), $widget_ops );
	}
 
	// Display Widget
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
				
		echo $before_widget;
		
		?>
		<!-- Additional Images -->
		<?php if( $images = jhp_get_gallery_images( null, 80, 60 ) ) : ?>
			<h4>Gallery</h4>
			<div id="jh-portfolio-additional-images">
				<div id="jh-portfolio-additional-image-holder">
					<img src="<?php echo jhp_get_gallery_image( key($images), 200, 140)?> " id="jh-portfolio-addiotnal-image" />
				</div>
				<div id="jh-portfolio-additional-images-holder">
					<?php foreach( $images as $id => $image ) : ?>
						<img src="<?php echo $image ?>" rel="<?php echo $id ?>" />
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
		
		<?php
		echo $after_widget;
	
	}
}
 
 
### Function: Init Table News Widget
add_action('widgets_init', 'widget_jh_portfolio_gallery');
function widget_jh_portfolio_gallery() {
	register_widget( 'WP_Widget_JHP_Gallery' );
}
?>