<?php 
$currentPoints = 0; 
$totalPoints = 0;
$hardPoints = 0;
?>
<div class="wrap">

	
	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Mark</h2>	
		
	<?php require WPSQT_DIR.'pages/admin/misc/navbar.php'; ?>
	
	
	<?php if ( isset($successMessage) ){ ?>
		<div class="updated" id="question_added"><?php echo $successMessage; ?></div>
	<?php } ?>
	
	<?php if ( isset($errorArray) && !empty($errorArray) ) { ?>
		<ul class="error">
			<?php foreach($errorArray as $error ){ ?>
				<li><?php echo $error; ?></li>
			<?php } ?>
		</ul>
	<?php } ?>
	
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">	
	<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />
	<?php if (!empty($result['person'])) { ?>
		<h3>User Details</h3>
		<div class="person">
		
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<?php foreach($result['person'] as $fieldName => $fieldValue){?>
				<tr>
					<th scope="row"><?php echo esc_html(strip_tags(wp_kses_stripslashes(ucwords($fieldName)))); ?></th>
					<td><?php echo esc_html(strip_tags(wp_kses_stripslashes(ucwords($fieldValue)))); ?></td>
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
				<tr>
					<th scope="row">Time taken</th>
					<td><?php echo $timeTaken; ?></td>
				</tr>
			</table>
		</div>
	<?php } ?>
	
	<?php
		if ( is_array($result['sections']) ){
			foreach ( $result['sections'] as $section ){ ?>
			
			<h3 style="text-decoration:underline;">Section - <?php echo $section['name']; ?></h3>
			
			<?php
				if (!isset($section['questions'])){
					continue;
				}
				
				foreach ($section['questions'] as $questionKey => $questionArray){ 
					$questionId = $questionArray['id'];
					?>
					
				<h4><?php echo "<u>"; print stripslashes($questionArray['name']); echo "</u>"; ?></h4>
				<?php if ( ucfirst($questionArray['type']) == 'Multiple'
						|| ucfirst($questionArray['type']) == 'Single'  ){
						$addPoints = (!empty($questionArray['points']) ? intval($questionArray['points']) : 1);
						if ( isset($section['answers'][$questionId]['mark']) 
						  && $section['answers'][$questionId]['mark'] == 'correct' ){
							$currentPoints += $addPoints;
							$hardPoints++;
						}
						$totalPoints += $addPoints;	
					?>
					<div style="margin-left: 35px; margin-bottom: 40px;">
					<b>Answers (Correct are marked green)</b>
					<p class="answer_given">
						<ol>
							<?php foreach ($questionArray['answers'] as $answerKey => $answer){ ?>
								  <li><font color="<?php echo esc_attr( $answer['correct'] != 'yes' ) ?  (isset($section['answers'][$questionId]['given']) &&  in_array($answerKey, $section['answers'][$questionId]['given']) ) ? '#FF0000' :  '#000000' : 'green' ; ?>"><?php echo (stripslashes($answer['text'])); ?></font><?php if (isset($section['answers'][$questionId]['given']) && in_array($answerKey, $section['answers'][$questionId]['given']) ){ ?> - Given<?php }?></li>
							<?php } ?>
						</ol>
					</p>
					<b>Correct/Incorrect</b> - <?php if (isset($section['answers'][$questionId]['mark'])) { if ($section['answers'][$questionId]['mark'] == "incorrect") { echo '<font style="color: red">Incorrect</font>'; } elseif ($section['answers'][$questionId]['mark'] == "correct") { echo '<font style="color: green">Correct</font>';} } else { echo '<font style="color: red">Incorrect</font>'; } ?><br /></div>
				<?php } else { 
					?>		
					<div style="margin-left: 35px; margin-bottom: 40px;">		
					<b>Answer Given</b>
					<p class="answer_given" style="background-color : #c0c0c0; border : 1px dashed black; padding : 5px;overflow:auto;height : 200px; width: 500px;"><?php if ( isset($section['answers'][$questionId]['given']) && is_array($section['answers'][$questionId]['given']) ){ echo nl2br(esc_html(stripslashes(current($section['answers'][$questionId]['given'])))); } ?></p>
					<p><b>Mark</b> <input type="hidden" name="old_mark[<?php echo $questionKey; ?>]" id="old_mark_<?php echo $questionKey; ?>" value="<?php echo (isset($questionArray['mark']) && ctype_digit($questionArray['mark']) ? $questionArray['mark'] : 0 ); ?>" /> <select name="mark[<?php echo $questionKey; ?>]" class="mark" id="current_mark_<?php echo $questionKey; ?>">
						<?php for( $i = 0; $i <= $questionArray['points']; $i++ ){ 
								if ( $i != 0) { $totalPoints++; }
						?>
								<option value="<?php echo $i; ?>" <?php   if ( isset($questionArray['mark']) && $questionArray['mark'] == $i ){ if ($i != 0){ $currentPoints+=$i; } ?> selected="yes"<?php }?>><?php echo $i; ?></option>
						<?php } ?>
						</select> <b>Comment</b> : <input type="text" name="comment[<?php echo $questionKey; ?>]" value="<?php if ( isset($questionArray['comment']) ){ echo esc_html($questionArray['comment']); } ?>" /> 
					<?php if ( isset($questionArray['hint']) && $questionArray['hint'] != "" ) { ?>- <a href="#" class="show_hide_hint">Show/Hide Hint</a></p>
					<div class="hint">
						<h5>Hint</h5>
						<p style="background-color : #c9c9c9;padding : 5px;"><?php echo nl2br(esc_html(stripslashes($questionArray['hint']))); ?></p>
					</div>
					
					<?php } else { ?></p></div><?php } ?>
				<?php } ?>
			<?php } ?>
		<?php }
		  } ?>
	<p style="margin-top: 50px;"><font size="+3">Total Points <span id="total_points"><?php echo $currentPoints; ?></span> out of <?php echo $totalPoints; ?></font></p>
	<?php
	$wpdb->query('UPDATE `'.WPSQT_TABLE_RESULTS.'` SET `score` = "'.$currentPoints.'" WHERE `id` = "'.$result['id'].'"');
	$wpdb->query('UPDATE `'.WPSQT_TABLE_RESULTS.'` SET `total` = "'.$totalPoints.'" WHERE `id` = "'.$result['id'].'"');
	$percentage = ($currentPoints / $totalPoints) * 100;
	$wpdb->query('UPDATE `'.WPSQT_TABLE_RESULTS.'` SET `percentage` = "'.$percentage.'" WHERE `id` = "'.$result['id'].'"');
	?>
	<select name="status">
		<option value="Unviewed" <?php if ($result['status'] == 'Unviewed'){?> selected="yes"<?php } ?>>Unviewed</option>
		<option value="Rejected" <?php if ($result['status'] == 'Rejected'){?> selected="yes"<?php } ?>>Rejected</option>
		<option value="Accepted" <?php if ($result['status'] == 'Accepted'){?> selected="yes"<?php } ?>>Accepted</option>
	</select>
	<input type="hidden" name="overall_mark" id="overall_mark" value="<?php echo $currentPoints; ?>" />
	<input type="hidden" name="total_mark" id="total_mark" value="<?php echo $totalPoints; ?>" />
	<p><input class="button-primary" type="submit" value="Submit"></p>
</div>
</form>
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>
