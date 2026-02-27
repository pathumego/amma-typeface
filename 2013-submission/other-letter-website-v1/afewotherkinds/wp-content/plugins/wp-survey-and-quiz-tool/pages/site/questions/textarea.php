<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('.show_hide_hint').unbind('click').click( function() {
		jQuery(this).parent().next().toggle("slow");
		return false;
	});
});
</script>
<p><textarea rows="6" cols="50" name="answers[<?php echo $questionKey; ?>][]"><?php if (!empty($givenAnswer)) { echo stripcslashes(current($givenAnswer)); }?></textarea></p>
<?php if ( isset($question['hint']) && $question['hint'] != "" ) : ?>
<p>- <a href="#" class="show_hide_hint"><?php _e('Show/Hide Hint', 'wp-survey-and-quiz-tool'); ?></a></p>
<div class="hint" style="display:none;">
	<h5><?php _e('Hint', 'wp-survey-and-quiz-tool'); ?></h5>
	<p style="background-color : #c9c9c9;padding : 5px;"><?php echo nl2br(esc_html(stripslashes($question['hint']))); ?></p>
</div>
<?php endif;?>
