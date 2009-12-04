<?php 
if( isset( $_POST['submit'] ) && $_POST['submit'] == 'Update' ) :
	//stw options
	update_option( 'jh_portfolio_access_key_id', $_POST['access_key_id'] );
	update_option( 'jh_portfolio_secret_key', $_POST['secret_key'] );
	update_option( 'jh_portfolio_template_file', $_POST['template_file'] );
	update_option( 'jh_portfolio_permalink_structure', $_POST['permalink_structure'] );
	$update = true;
endif;
?> 
<div class="wrap" style="clear: both;">
	<h2><?php echo $title ?></h2>
	
	<?php if( isset($update) && $update == true ) : ?>
		<div class="updated fade" id="message"><p>Settings Saved</p></div>	
	<?php endif; ?>
	
	
	<form action="?page=jh-portfolio/admin/admin.settings.php" method="post">
		
		<table class="form-table">
			<tr>
				<td colspan="2"><h3>ShrinkTheWeb Integration</h3><p>JH Portfolio can use the free <a href="http://www.shrinktheweb.com" target="_blank">ShrinkTheWeb</a> service for automatic website thumbnails, you must sign up for a free account <a href="http://www.shrinktheweb.com/index.php?view=join" target="_blank">here</a> and enter your Access Key ID and Secret Key below.</p></td>
			</tr>
			<tr>
				<td style="width: 50%;">Access Key ID</td>
				<td><input type="text" name="access_key_id" value="<?php echo get_option('jh_portfolio_access_key_id') ?>" /></td>
			</tr>
			<tr>
				<td>Secret Key</td>
				<td><input type="text" name="secret_key" value="<?php echo get_option('jh_portfolio_secret_key') ?>" /></td>
			</tr>
			
			<tr><td colspan="2"><h3>Template File</h3></td></tr>
		
			<tr>
				<td>Template filename <br /><small class="description">This is creating a custom template file in your theme directory for the portfolio</small></td>
				<td><input type="text" name="template_file" value="<?php echo get_option('jh_portfolio_template_file', 'template.portfolio.php') ?>" /></td>
			</tr>
			
			<tr><td colspan="2"><h3>Permalinks</h3></td></tr>
		
			<tr>
				<td>Portfolio Permalink Structure<br /><small class="description">Enter '/' or %category_name% - E.g. /works/%category_name%/</small></td>
				<td>/portfolio/ <input type="text" name="permalink_structure" value="<?php echo get_option('jh_portfolio_permalink_structure', '/%category_name%/') ?>" /> /%entry_slug%/</td>
			</tr>
			
		</table>
	<input type="submit" class="button-primary" name="submit" value="Update" />
	</form>
	<?php include('admin.help.php') ?>
</div>