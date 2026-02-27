<div id="sub_form_multiple" class="sub_form">
	<h3>Multiple Choice Answers</h3>
	
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<thead>
			<tr>
				<td>Name</td>
				<td>Correct</td>
				<td>Selected By Default</td>
				<td>Delete</td>
			</tr>
		</thead>
		<tbody>
			<?php   $i = 0;
					foreach( $answers as $key => $answer ) { ?>
				<tr>
					<td><input type="text" name="multiple_name[<?php echo $i; ?>]" value="<?php echo esc_attr(wp_kses_stripslashes($answer["text"])); ?>" /></td>
					<td><input type="checkbox" name="multiple_correct[<?php echo  $i; ?>]" <?php if ( $answer["correct"] == "yes" ){ ?> checked="checked"<?php }?> value="yes" /></td>
					<td><input type="radio" name="multiple_default" <?php if ( isset($answer["default"]) && $answer["default"] == "yes" ){ ?> checked="checked"<?php }?> value="<?php echo $i; ?>" /></td>
					<td><input type="checkbox" name="multiple_delete[<?php echo  $i; ?>]" value="yes" /></td>
				</tr>
			<?php	
					$i++; 
				} ?>
		</tbody>
	</table>
	
	
	<p><a href="#" class="button-secondary" title="Add New Answer" id="wsqt_multi_add">Add New Answer</a></p>
			
</div>