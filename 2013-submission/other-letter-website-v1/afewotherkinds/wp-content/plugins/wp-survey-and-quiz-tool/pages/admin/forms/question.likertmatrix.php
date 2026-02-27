<div id="sub_form_likertmatrix" class="sub_form">
	<h3>Likert Matrix Answers</h3>
	
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<thead>
			<tr>
				<td>Name</td>
				<td>Delete</td>
			</tr>
		</thead>
		<tbody>
			<?php   $i = 0;
					foreach( $answers as $key => $answer ) { ?>
				<tr>
					<td><input type="text" name="likertmatrix_name[<?php echo $i; ?>]" value="<?php echo esc_attr(wp_kses_stripslashes($answer["text"])); ?>" /></td>
					<td><input type="checkbox" name="likertmatrix_delete[<?php echo  $i; ?>]" value="yes" /></td>
				</tr>
			<?php	
					$i++; 
				} ?>
		</tbody>
	</table>

	<p><a href="#" class="button-secondary" title="Add New Answer" id="wsqt_likertmatrix_add">Add New Answer</a></p>
			
</div>