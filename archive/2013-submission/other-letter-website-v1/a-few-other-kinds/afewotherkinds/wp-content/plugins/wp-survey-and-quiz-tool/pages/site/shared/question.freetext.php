<?php echo $text; ?>

<?php if ( !empty($additional) ) { ?>
	<p><?php echo stripslashes($additional); ?></p>
<?php } ?>
		

<p><textarea rows="6" cols="50" name="answers[<?php echo $id; ?>][]"></textarea></p>