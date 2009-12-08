<?php
### Class: JH Portfolio Selector
 class WP_Widget_JH_Portfolio_Additional_Info extends WP_Widget {
	// Constructor
	function WP_Widget_JH_Portfolio_Additional_Info() {
		$widget_ops = array( 'description' => __( 'Shows the portfolio entry\'s additional info (URL and Related Work)', 'table_rss_news' ) );
		$this->WP_Widget( 'jh_portfolio_additional_info', __( 'JHP Entry Additional Info' ), $widget_ops );
	}
 
	// Display Widget
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
				
		echo $before_widget;
		global $jh_portfolio;
		
		?>
		<!-- Additional Info -->
		<?php if( jhp_has_info( null, 'url,related_work' ) ) : ?>
			<h4>Additional Information</h4>
			<?php if( $url = jhp_get_url() ) : ?>
				<p><strong>Visit</strong><br /><a target="_blank" href="<?php echo $url ?>"><?php echo $url ?></a></p>
			<?php endif; ?>
			<?php if( $related_work = jhp_get_related_work() ) : ?>
				<p><strong>Related Work</strong></p>
				<ul id="related-work">
					<?php foreach( $related_work as $post_id ) : ?>
						<li><a href="<?php echo get_permalink($post_id) ?>"><?php echo get_the_title($post_id) ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		<?php endif; ?>
		
		<?php
		echo $after_widget;
	
	}
}
 
 
### Function: Init Table News Widget
add_action('widgets_init', 'widget_jh_portfolio_additional_info');
function widget_jh_portfolio_additional_info() {
	register_widget( 'WP_Widget_JH_Portfolio_Additional_Info' );
}
?>