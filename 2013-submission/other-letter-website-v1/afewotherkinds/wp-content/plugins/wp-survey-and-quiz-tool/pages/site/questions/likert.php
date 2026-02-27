<?php
if ($question['likertscale'] != "Agree/Disagree") {
	$scale = (int) $question['likertscale'];
	for ( $i = 1; $i <= $scale; $i++){ ?>
		<span class="wpsqt_likert_answer"><input type="radio" name="answers[<?php echo $questionKey; ?>]" value="<?php echo $i; ?>" <?php if ( in_array($i, $givenAnswer) ) { ?> checked="checked" <?php } ?> id="answer_<?php echo $question['id']; ?>_<?php echo $i; ?>" /> <label for="answer_<?php echo $question['id']; ?>_<?php echo $i; ?>"><?php echo $i; ?></label></span>
	<?php }
} else {
	?>
		<span class="wpsqt_likert_answer"><input type="radio" name="answers[<?php echo $questionKey; ?>]" value="<?php _e('Strongly Disagree', 'wp-survey-and-quiz-tool'); ?>" id="answer_<?php echo $question['id']; ?>_stronglydisagree" /> <label for="answer_<?php echo $question['id']; ?>_stronglydisagree"><?php _e('Strongly Disagree', 'wp-survey-and-quiz-tool'); ?></label></span>
	<span class="wpsqt_likert_answer"><input type="radio" name="answers[<?php echo $questionKey; ?>]" value="<?php _e('Disagree', 'wp-survey-and-quiz-tool'); ?>" id="answer_<?php echo $question['id']; ?>_disagree" /> <label for="answer_<?php echo $question['id']; ?>_disagree"><?php _e('Disagree', 'wp-survey-and-quiz-tool'); ?></label></span>
<span class="wpsqt_likert_answer"><input type="radio" name="answers[<?php echo $questionKey; ?>]" value="<?php _e('No Opinion', 'wp-survey-and-quiz-tool'); ?>" id="answer_<?php echo $question['id']; ?>_noopinion" /> <label for="answer_<?php echo $question['id']; ?>_noopinion"><?php _e('No Opinion', 'wp-survey-and-quiz-tool'); ?></label></span>
<span class="wpsqt_likert_answer"><input type="radio" name="answers[<?php echo $questionKey; ?>]" value="<?php _e('Agree', 'wp-survey-and-quiz-tool'); ?>" id="answer_<?php echo $question['id']; ?>_agree" /> <label for="answer_<?php echo $question['id']; ?>_agree"><?php _e('Agree', 'wp-survey-and-quiz-tool'); ?></label></span>
<span class="wpsqt_likert_answer"><input type="radio" name="answers[<?php echo $questionKey; ?>]" value="<?php _e('Strongly Agree', 'wp-survey-and-quiz-tool'); ?>" id="answer_<?php echo $question['id']; ?>_stronglyagree" /> <label for="answer_<?php echo $question['id']; ?>_stronglyagree"><?php _e('Strongly Agree', 'wp-survey-and-quiz-tool'); ?></label></span>
<?php } ?>
<br /><br />
