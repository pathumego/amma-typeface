			<ul class="wpsqt_multiple_question">
			<?php
				if (isset($question['randomize_answers']) && $question['randomize_answers'] == 'yes') {
					$answers = array();
					while (count($question['answers']) > 0) {
						$key = array_rand($question['answers']);
						$answers[$key] = $question['answers'][$key];
						unset($question['answers'][$key]);
					}
					$question['answers'] = $answers;

					// Store the order of the answers for review page
					$_SESSION['wpsqt'][$quizName]['sections'][$sectionKey]['questions'][$questionKey]['answers'] = $answers;
				}
			?>
			<?php foreach ( $question['answers'] as $answerKey => $answer ){ ?>
				<li>
					<input type="<?php echo ($question['type'] == 'Single' ) ? 'radio' : 'checkbox'; ?>" name="answers[<?php echo $questionKey; ?>][]" value="<?php echo $answerKey; ?>" id="answer_<?php echo $question['id']; ?>_<?php echo $answerKey;?>" <?php if ( (isset($answer['default']) && $answer['default'] == 'yes') || in_array($answerKey, $givenAnswer)) {  ?> checked="checked" <?php } ?> /> <label for="answer_<?php echo $question['id']; ?>_<?php echo $answerKey;?>"><?php echo esc_html( $answer['text'] ); ?></label> 
				</li>
			<?php } 
				if (    $question['type'] == 'Multiple Choice' 
					 && array_key_exists('include_other',$question)
					 && $question['include_other'] == 'yes' ){					
				?>
				<li>
					<input type="checkbox" name="answers[<?php echo $questionKey; ?>]" value="0" id="answer_<?php echo $question['id']; ?>_other"> <label for="answer_<?php echo $question['id']; ?>_other"><?php _e('Other', 'wp-survey-and-quiz-tool'); ?></label> <input type="text" name="other[<?php echo $questionKey; ?>]" value="" />
				</li>
				<?php } ?>
			</ul>