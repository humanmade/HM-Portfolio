<?php 

include_once( '../../../wp-load.php' );

if( !is_user_logged_in() )
	exit;

function jhp_debug( $code, $output = true ) {
	
	if ( $output )
		echo '<br /><pre>';
	
	if ( is_null( $code ) || false === $code || true === $code || '' === $code || 0 === $code ) :
		if ( $output )
			var_dump( $code );
		else
			var_export( $code, true );
	
	else :
		if ( $output )
			print_r( $code );
		else
			print_r( $code, true ); 	
	endif;
	
	if ( $output )
		echo '</pre><br />';
}

?>

<h3>All Posts</h3>
<?php

global $jh_portfolio;
$jh_portfolio = new JH_Portfolio('showposts=-1');

jhp_debug($jh_portfolio);

?>

<h3>All Posts with terms</h3>
<?php foreach( $jh_portfolio->posts as $post ): ?>

	<strong>Post Id: <?php echo $post->ID ?></strong><br />
	<?php jhp_debug( wp_get_object_terms( $post->ID, 'jh-portfolio-category' ) ) ;?>
<?php endforeach; ?>

<h3>Widgets</h3>

<h4>Portfolio Selector</h4>

<?php
global $jh_portfolio;
$jh_portfolio = new JH_Portfolio('showposts=-1');

?>
<?php foreach( jh_portfolio_get_portfolio_categories( false, true ) as $cat ) : ?>
    <?php $jh_portfolio = new JH_Portfolio('category=' . $cat->term_id ); ?>
    <h5><?php echo $cat->name ?></h5>
    <?php jhp_debug( $jh_portfolio ) ?>
<?php endforeach; ?>