<div class="pre-content"></div>
<div class="poll">

<?php if ( isset($_SESSION['wpsqt']['current_message']) ) { ?>
	<p><?php echo $_SESSION['wpsqt']['current_message']; ?></p>
<?php } ?>

<?php 
if (isset($GLOBALS['q_config']) && isset($GLOBALS['q_config']['url_info']['url'])) {
	$url = $GLOBALS['q_config']['url_info']['url'];
} else {
	$url = $_SERVER['REQUEST_URI'];
}
?>
<form method="post" action="<?php echo esc_url($url); ?>">
	<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />
	<input type="hidden" name="step" value="<?php echo ( $_SESSION['wpsqt']['current_step']+1); ?>" />
<?php
		$answers = ( isset($_SESSION["wpsqt"][$quizName]["sections"][$sectionKey]["answers"]) ) ? $_SESSION["wpsqt"][$quizName]["sections"][$sectionKey]["answers"] : array();
foreach ($_SESSION['wpsqt'][$quizName]['sections'][$sectionKey]['questions'] as $questionKey => $question) { ?>

	<div class="wpst_question">
		<?php 
		
			$questionId = $question['id'];		
			$givenAnswer = isset($answers[$questionId]['given']) ? $answers[$questionId]['given'] : array();
			
			if ( isset($question["required"]) &&  $question["required"] == "yes" ){ 
				?>
				<font color="#FF0000"><strong>*
				
			<?php			
				// See if the question has been missed and this a replay if not end the red text here.
				if ( empty($_SESSION['wpsqt']['current_message']) || in_array($questionId,$_SESSION['wpsqt']['required']) ){
					?></strong></font><?php 
				}
			}			
						
			echo stripslashes($question['name']);
			
			// See if the question has been missed and this is a replay
			if ( !empty($_SESSION['wpsqt']['current_message']) && !in_array($questionId,$_SESSION['wpsqt']['required']) ){
				?></strong></font><?php 
			}	
		
			if ( !empty($question['add_text']) ){
			?>
			<p><?php echo nl2br( esc_html( wp_kses_stripslashes($question['add_text']) ) ); ?></p>
			<?php } ?>
			
			<?php if ( isset($question['image'])) { ?>
			<p><?php echo stripslashes($question['image']); ?></p>
			<?php } ?>
			
			<?php do_action('wpsqt_quiz_question_section',$question); ?>
			
			<?php require Wpsqt_Question::getDisplayView($question); ?>
			
	</div>
<?php } ?>

<?php
if ($sectionKey == (count($_SESSION['wpsqt'][$quizName]['sections']) - 1)) {
	?><p><input type='submit' value='<?php _e('Submit', 'wp-survey-and-quiz-tool'); ?>' class='button-secondary' /></p><?php
} else {
	?><p><input type='submit' value='<?php _e('Next', 'wp-survey-and-quiz-tool'); ?> &raquo;' class='button-secondary' /></p><?php
}
?>
</form>
</div>
<div class="post-content"></div>