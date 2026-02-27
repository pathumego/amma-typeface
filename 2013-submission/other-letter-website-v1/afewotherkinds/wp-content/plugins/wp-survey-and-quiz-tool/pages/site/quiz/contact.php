<h1><?php echo $_SESSION['wpsqt']['current_name']; ?></h1>

<?php if ( isset($errors) && !empty($errors) ){ ?>
<ul>
	<?php foreach ($errors as $error){ ?>
	<li><?php echo $error; ?></li>
	<?php } ?>
</ul>
<?php }?>
<form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="step" value="<?php echo ++$_SESSION['wpsqt']['current_step']; ?>" />
	<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<th scope="row"><?php _e('Name', 'wp-survey-and-quiz-tool'); ?> <font color="#FF0000">*</font></th>
			<td><input type="text" name="user_name" value="" /></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Email', 'wp-survey-and-quiz-tool'); ?> <font color="#FF0000">*</font></th>
			<td><input type="text" name="email" value="" /></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Phone', 'wp-survey-and-quiz-tool'); ?> <font color="#FF0000">*</font></th>
			<td><input type="text" name="phone" value="" /></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Heard of us from?', 'wp-survey-and-quiz-tool'); ?></th>
			<td><input type="text" name="heard" value="" /></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Address', 'wp-survey-and-quiz-tool'); ?> <font color="#FF0000">*</font></th>
			<td><textarea rows="5" cols="30" name="address"></textarea></td>
		</tr>
		<tr>
			<th scope="row"><?php _e('Extra Notes', 'wp-survey-and-quiz-tool'); ?> <font color="#FF0000">*</font></th>
			<td><textarea rows="5" cols="30" name="notes"></textarea></td>
		</tr>
	</table>
	<p><input type='submit' value='<?php _e('Next', 'wp-survey-and-quiz-tool'); ?> &raquo;' class='button-secondary' /></p>
</form>