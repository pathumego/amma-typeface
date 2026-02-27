<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Delete Survey Question</h2>
		
	<?php require WPSQT_DIR.'pages/admin/misc/navbar.php'; ?>
	

	<form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />
		<p style="text-align: center;">Are you sure you want to delete the "<em><?php echo stripslashes($questionText); ?></em>" question?</p>
		<p style="text-align: center;"><input type="submit" name="confirm" value="Yes" class='button-secondary' /></p>
	</form>
	
</div>
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>