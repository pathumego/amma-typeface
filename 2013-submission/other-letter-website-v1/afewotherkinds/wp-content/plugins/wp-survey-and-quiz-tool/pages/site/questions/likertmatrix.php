<table class="wpsqt_likertmatrix_question">
<thead>
	<tr>
		<td width="20%"></td>
		<?php if (isset($question['likertmatrixscale']) && $question['likertmatrixscale'] == '1-5') { ?>
			<td>1</td>
			<td>2</td>
			<td>3</td>
			<td>4</td>
			<td>5</td>
		<?php } else { ?>
			<td width="20%"><?php _e('Strongly Disagree', 'wp-survey-and-quiz-tool'); ?></td>
			<td width="20%"><?php _e('Disagree', 'wp-survey-and-quiz-tool'); ?></td>
			<td width="20%"><?php _e('No Opinion', 'wp-survey-and-quiz-tool'); ?></td>
			<td width="20%"><?php _e('Agree', 'wp-survey-and-quiz-tool'); ?></td>
			<td width="20%"><?php _e('Strongly Agree', 'wp-survey-and-quiz-tool'); ?></td>
		<?php } ?>
	</tr>
</thead>
<?php foreach ($question['answers'] as $key => $answer) { ?>
	<tr>
		<td><?php echo $answer['text']; ?></td>
		<td><input type="radio" name="answers[<?php echo $questionKey; ?>][<?php echo $key; ?>]" value="<?php echo $answer['text']; ?>_1" id="answer_<?php echo $key; ?>" /></td>
		<td><input type="radio" name="answers[<?php echo $questionKey; ?>][<?php echo $key; ?>]" value="<?php echo $answer['text']; ?>_2" id="answer_<?php echo $key; ?>" /></td>
		<td><input type="radio" name="answers[<?php echo $questionKey; ?>][<?php echo $key; ?>]" value="<?php echo $answer['text']; ?>_3" id="answer_<?php echo $key; ?>" /></td>
		<td><input type="radio" name="answers[<?php echo $questionKey; ?>][<?php echo $key; ?>]" value="<?php echo $answer['text']; ?>_4" id="answer_<?php echo $key; ?>" /></td>
		<td><input type="radio" name="answers[<?php echo $questionKey; ?>][<?php echo $key; ?>]" value="<?php echo $answer['text']; ?>_5" id="answer_<?php echo $key; ?>" /></td>
	</tr>
<?php } ?>

<?php if (isset($question['likertmatrixcustom']) && $question['likertmatrixcustom'] == 'yes') { ?>
	<tr>
		<td><?php _e('Other', 'wp-survey-and-quiz-tool'); ?>: <input type="text" name="answers[<?php echo $questionKey; ?>][custom][text]" id="answer_<?php echo $questionKey; ?>_custom_text" /></td>
		<td><input type="radio" name="answers[<?php echo $questionKey; ?>][custom][]" value="other_1" id="answer_<?php echo $questionKey; ?>_custom_1" /></td>
		<td><input type="radio" name="answers[<?php echo $questionKey; ?>][custom][]" value="other_2" id="answer_<?php echo $questionKey; ?>_custom_2" /></td>
		<td><input type="radio" name="answers[<?php echo $questionKey; ?>][custom][]" value="other_3" id="answer_<?php echo $questionKey; ?>_custom_3" /></td>
		<td><input type="radio" name="answers[<?php echo $questionKey; ?>][custom][]" value="other_4" id="answer_<?php echo $questionKey; ?>_custom_4" /></td>
		<td><input type="radio" name="answers[<?php echo $questionKey; ?>][custom][]" value="other_5" id="answer_<?php echo $questionKey; ?>_custom_5" /></td>
	</tr>
<?php } ?>

</table>