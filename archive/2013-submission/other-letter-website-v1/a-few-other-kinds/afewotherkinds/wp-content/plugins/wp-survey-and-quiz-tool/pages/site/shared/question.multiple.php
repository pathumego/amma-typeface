<?php echo $text; ?>

<ul>
	<?php foreach ( $answers as $answer ){ ?>
		<li>
			<input type="<?php echo ($type == 'single') ? 'radio' : 'checkbox'; ?>" name="answers[<?php echo $id; ?>][]" value="<?php echo $answer['id']; ?>" id="answer_<?php echo $id; ?>_<?php echo $answer['id'];?>"> <label for="answer_<?php echo $id; ?>_<?php echo $answer['id'];?>"><?php echo $answer['text']; ?></label> 
		</li>
	<?php } ?>
</ul>	