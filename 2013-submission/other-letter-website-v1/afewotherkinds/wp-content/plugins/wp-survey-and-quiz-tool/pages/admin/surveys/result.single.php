<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Survey Result</h2>
		
	<?php require WPSQT_DIR.'pages/admin/misc/navbar.php'; ?>
		
	<?php if (!empty($result['person'])) { ?>
		<h3>User Details</h3>
		<div class="person">
		
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<?php foreach($result['person'] as $fieldName => $fieldValue){?>
				<tr>
					<th scope="row"><?php echo esc_html(strip_tags(wp_kses_stripslashes($fieldName))); ?></th>
					<td><?php echo esc_html(strip_tags(wp_kses_stripslashes($fieldValue))); ?></td>
				</tr>
				<?php }
					  if (isset($result['ipaddress'])){
				?>
				<tr>
					<th scope="row">IP Address</th>
					<td><?php echo $result['ipaddress']; ?></td>
				</tr>
				<tr>
					<th scope="row">Hostname</th>
					<td><?php echo gethostbyaddr($result['ipaddress']); ?></td>
				</tr>
				<?php } ?>
			</table>
		</div>
	<?php } ?>
	
	<?php foreach ( $result['sections'] as $section ){ ?>
		<h3><?php echo $section['name']; ?></h3>
		
		<?php
			if (!isset($section['questions'])){
				continue;
			}
			foreach ($section['questions'] as $questionKey => $questionArray){ 
			
				$questionId = $questionArray['id'];
				?>
				
			<h4><?php print stripslashes($questionArray['name']); ?></h4>
			<?php if ( ucfirst($questionArray['type']) == 'Multiple' 
					|| ucfirst($questionArray['type']) == 'Single' 
					|| ucfirst($questionArray['type']) == "Multiple Choice" 
					|| ucfirst($questionArray['type']) == "Dropdown" ){
					
				?>				
				<b><u>Answers</u></b>
				<p class="answer_given">
					<ol>
						<?php foreach ($questionArray['answers'] as $answerKey => $answer){ ?>
							  <li><font color="<?php echo ( !isset($answer['correct']) || $answer['correct'] != 'yes' ) ?  (isset($section['answers'][$questionId]['given']) &&  in_array($answerKey, $section['answers'][$questionId]['given']) ) ? '#FF0000' :  '#000000' : '#00FF00' ; ?>"><?php echo stripslashes($answer['text']) ?></font><?php if (isset($section['answers'][$questionId]['given']) && in_array($answerKey, $section['answers'][$questionId]['given']) ){ ?> - Given<?php }?></li>
						<?php } ?>
					</ol>
				</p>
			<?php } else if (ucfirst($questionArray['type']) == 'Likert') {
					?><p></p><b><u>Answer Given</u>:&nbsp;</b><?php if(isset($section['answers'][$questionId]['given'])) { echo $section['answers'][$questionId]['given']; } else { echo 'None'; } ?> </p> <?php
				} else if (ucfirst($questionArray['type']) == 'Likert Matrix') {
					echo '<ul>';
					foreach ($section['answers'][$questionId]['given'] as $givenAnswer) {
						if (is_array($givenAnswer)) {
							$otherText = $givenAnswer['text'];
							$givenAnswer = explode("_", $givenAnswer[0]);
							echo '<li><strong>'.$otherText.'</strong> - '.$givenAnswer[1].'</li>';
						} else {
							$givenAnswer = explode("_", $givenAnswer);
							echo '<li><strong>'.$givenAnswer[0].'</strong> - '.$givenAnswer[1].'</li>';
						}
					}
					echo '</ul>';
				} else {
				?>				
				<b><u>Answer Given</u></b>
				<p class="answer_given" style="background-color : #c0c0c0; border : 1px dashed black; padding : 5px;overflow:auto;height : 200px;"><?php if ( isset($section['answers'][$questionId]['given']) && is_array($section['answers'][$questionId]['given']) ){ echo nl2br(esc_html(stripslashes(current($section['answers'][$questionId]['given'])))); } ?></p>
			<?php } ?>
		<?php } ?>
	<?php } ?>

</div>
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>