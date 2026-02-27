<h1><?php echo $_SESSION['wpsqt'][$quizName]['details']['name']; ?></h1>

<?php if ( isset($errors) && !empty($errors) ){ ?>
<ul>
	<?php foreach ($errors as $error){ ?>
	<li><?php echo $error; ?></li>
	<?php } ?>
</ul>
<?php }?>
<form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">

	<input type="hidden" name="step" value="1" />	
	<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<?php foreach($fields as $field){			
			$fieldName = preg_replace('~[^a-z0-9]~i','',$field['name']);
		?>
		<tr>
			<th><?php echo $field['name']; if ($field['required'] == 'yes'){?> <font color="#FF0000">*</font><?php } ?></th>
			<td>
		<?php if ($field['type'] == 'text'){?>
			<input type="text" name="Custom_<?php echo $fieldName; ?>" value="<?php if ( isset($field['value'])) { echo $field['value']; } ?>" />
		<?php } else { ?>
			<textarea name="Custom_<?php echo $fieldName; ?>" rows="4" cols="40"><?php if ( isset($field['value'])) { echo $field['value']; } ?></textarea>
		<?php } ?>
			</td>
		</tr>	
	<?php } ?>
	</table>
	<p><input type='submit' value='Next &raquo;' class='button-secondary' /></p>
</form>

