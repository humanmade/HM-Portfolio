<?php
### Class: HM Portfolio Selector
 class WP_Widget_hmp_Gallery extends WP_Widget {
	// Constructor
	function WP_Widget_hmp_Gallery() {
		$widget_ops = array( 'description' => __( 'Shows the portfolio entry\'s gallery', 'table_rss_news' ) );
		$this->WP_Widget( 'hmp_portfolio_gallery', __( 'HMP Gallery' ), $widget_ops );
	}
 
	// Display Widget
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
				
		echo $before_widget;
		
		?>
		<!-- Additional Images -->
		<?php if( $images = hmp_get_gallery_images( null, 100, 60, true ) ) : ?>
			<h4>Gallery</h4>
			<script type="text/javascript">jQuery().ready( function() { jQuery("a[rel=lightbox]").lightBox(); });</script>
			<div id="hmp-portfolio-additional-images">
			<?php foreach( $images as $id => $image ) : ?>
			    <a rel="lightbox" href="<?php echo hmp_get_gallery_image( $id, 800, 600 ) ?>"><img src="<?php echo $image ?>" rel="<?php echo $id ?>" /></a>
			<?php endforeach; ?>
			</div>
		<?php endif; ?>
		
		<?php
		echo $after_widget;
	
	}
}
 
 
### Function: Init Table News Widget
add_action('widgets_init', 'widget_hmp_portfolio_gallery');
function widget_hmp_portfolio_gallery() {
	register_widget( 'WP_Widget_hmp_Gallery' );
}
?>