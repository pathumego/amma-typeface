<?php if ( $sections == false ) { ?>

	<p>There are no results for this survey yet.</p>

<?php } else { ?>

	<?php foreach ( $sections as $sectionKey => $secton ){
			foreach ( $secton['questions'] as $questonKey => $question ) {
		?>
			<div class="wpsqt-question-review">
			<h3><?php echo $question['name']; ?></h3>

			<?php
			$chartWidth = get_option('wpsqt_chart_width');
			$chartHeight = get_option('wpsqt_chart_height');
			$chartTextColour = get_option('wpsqt_chart_text_colour');
			$chartTextSize = get_option('wpsqt_chart_text_size');
			$chartAbbreviations = get_option('wpsqt_chart_abbreviation');
			if (!isset($chartWidth) || $chartWidth == NULL)
				$chartWidth = 400;
			if (!isset($chartHeight) || $chartHeight == NULL)
				$chartHeight = 185;
			if (!isset($chartTextColour) || $chartTextColour == NULL)
				$chartTextColour = '000000';
			if (!isset($chartTextSize) || $chartTextSize == NULL)
				$chartTextSize = 13;
			$chartSize = 'chs='.$chartWidth.'x'.$chartHeight;
			?>

			<?php if ( $question['type'] == "Multiple Choice" ||
					   $question['type'] == "Dropdown" ) {
						$googleChartUrl = 'http://chart.apis.google.com/chart?'.$chartSize.'&chxs=0,'.$chartTextColour.','.$chartTextSize.',0,lt,'.$chartTextColour.'|1,'.$chartTextColour.','.$chartTextSize.',1,lt,'.$chartTextColour.'&cht=p&chf=bg,s,'.get_option("wpsqt_chart_bg").'&chco='.get_option("wpsqt_chart_colour");
						$valueArray    = array();
						$nameArray     = array();
					   foreach ( $question['answers'] as $answer ) {
					   		$nameArray[] = $answer['text'];
							$valueArray[] = $answer['count'];
					   }

						$googleChartUrl .= '&chd=t:'.implode(',', $valueArray);
						$googleChartUrl .= '&chl='.implode('|',$nameArray);
						?>

						<img class="wpsqt-chart" src="<?php echo $googleChartUrl; ?>" alt="<?php echo $question['name']; ?>" />
				<?php } else if ($question['type'] == "Free Text") {

						$i = 1; // Variable used to count answers - used later

						?> <em>All answers for this question</em> <?php

						foreach($uncachedresults as $uresult) {
							$usection = unserialize($uresult['sections']);

							foreach($usection as $result) {

								foreach($result['answers'] as $uanswerkey => $uanswer) {
									if($uanswerkey == $questonKey && in_array($uanswerkey, $freetextq)) {
										echo '<p>'.$i.') '.$uanswer['given'][0].'</p>';
										$i++;
									}

								}
							}

						}
					  } else if ($question['type'] == "Likert") {
							$googleChartUrl = 'http://chart.apis.google.com/chart?&cht=bvs&chxs=0,'.$chartTextColour.','.$chartTextSize.',0,lt,'.$chartTextColour.'|1,'.$chartTextColour.','.$chartTextSize.',1,lt,'.$chartTextColour.'&chf=bg,s,'.get_option("wpsqt_chart_bg").'&chco='.get_option("wpsqt_chart_colour");
							$valueArray    = array();
							$nameArray     = array();
							$maxValue = 0;
							$numAnswers = count($question['answers']);
							
							// Populates data array
							foreach ( $question['answers'] as $key => $answer ) {
								$nameArray[] = $key;
								$valueArray[] = $answer['count'];
								// Gets the maximum value
								if ($answer['count'] > $maxValue)
									$maxValue = $answer['count'];
							}
							// Makes chart wider if its an agree/disagree question
							if (array_key_exists('Disagree', $question['answers'])) {
								$googleChartUrl .= '&'.$chartSize.'&chbh=r,5,10';
								if ($chartAbbreviations == 'yes') {
									$googleChartUrl .= '&chxt=x&chxl=0:|Strgly Disagree|Disagree|No Opinion|Agree|Strgly Agree'; // Sets labelling to x-axis only
								} else {
									$googleChartUrl .= '&chxt=x&chxl=0:|Strongly Disagree|Disagree|No Opinion|Agree|Strongly Agree'; // Sets labelling to x-axis only
								}
							} else {
								$googleChartUrl .= '&'.$chartSize;
								$googleChartUrl .= '&chxt=x&chxl=0:|'.implode('|', $nameArray); // Sets labelling to x-axis only
							}
							$googleChartUrl .= '&chm=N,000000,0,,10|N,000000,1,,10|N,000000,2,,10'; // Adds the count above bars
							$googleChartUrl .= '&chds=0,'.(++$maxValue); // Sets scaling to a little bit more than max value
							$googleChartUrl .= '&chd=t:'.implode(',', $valueArray); // Chart data
							?><img class="wpsqt-chart" src="<?php echo $googleChartUrl; ?>" alt="<?php echo $question['name']; ?>" /><?php
					  } else if ($question['type'] == "Likert Matrix") {
					  	if (isset($question['scale']) && $question['scale'] == 'disagree/agree') {
				  			$wordScale = true;
				  		} else {
				  			$wordScale = false;
				  		}

						// Remove the 'other' answers if it isn't allowed
						$questionMeta = $wpdb->get_row('SELECT meta FROM '.WPSQT_TABLE_QUESTIONS.' WHERE id = "'.$questonKey.'"', ARRAY_A);
						$questionMeta = unserialize($questionMeta['meta']);
						if ($questionMeta['likertmatrixcustom'] == 'no'){
							unset($question['answers']['other']);
						}

					  	foreach($question['answers'] as $optionkey => $matrixOption) {
					  			$googleChartUrl = 'http://chart.apis.google.com/chart?&cht=bvs&chxs=0,'.$chartTextColour.','.$chartTextSize.',0,lt,'.$chartTextColour.'|1,'.$chartTextColour.','.$chartTextSize.',1,lt,'.$chartTextColour.'';
								$valueArray    = array();
								$nameArray     = array();
								$maxValue = 0;
								$numAnswers = count($question['answers']);

								foreach ($matrixOption as $key => $answer) {
									$nameArray[] = $key;
									$valueArray[] = $answer['count'];
									// Gets the maximum value
									if ($answer['count'] > $maxValue)
										$maxValue = $answer['count'];
								}

								$googleChartUrl .= '&'.$chartSize;

								if (isset($wordScale) && $wordScale == true) {
									if ($chartAbbreviations == 'yes') {
										$googleChartUrl .= '&chxt=x&chxl=0:|Strgly Disagree|Disagree|No Opinion|Agree|Strgly Agree'; // Sets labelling to x-axis only
									} else {
										$googleChartUrl .= '&chxt=x&chxl=0:|Strongly Disagree|Disagree|No Opinion|Agree|Strongly Agree'; // Sets labelling to x-axis only
									}
									$googleChartUrl .= '&'.$chartSize.'&chbh=r,5,10'; // Makes chart wider		
								} else {
									$googleChartUrl .= '&chxt=x&chxl=0:|'.implode('|', $nameArray); // Sets labelling to x-axis only and labels with numbers
								}

								
								$googleChartUrl .= '&chm=N,000000,0,,10|N,000000,1,,10|N,000000,2,,10'; // Adds the count above bars
								$googleChartUrl .= '&chds=0,'.(++$maxValue); // Sets scaling to a little bit more than max value
								$googleChartUrl .= '&chd=t:'.implode(',', $valueArray); // Chart data

								echo '<h4>'.$optionkey.'</h4>';
								?><img class="wpsqt-chart" src="<?php echo $googleChartUrl; ?>" alt="<?php echo $question['name']; ?>" />
								<?php
					  		}
					  } else {
							echo 'Something went really wrong, please report this bug to the forum. Here\'s a var dump which might make you feel better.<pre>'; var_dump($question); echo '</pre>';
					  } ?>
					<div class="wpsqt-question-info">
						<div class="wpsqt-question-title">Question Info</div>
						<?php for ($i = 0; $i < count($nameArray); $i++) {
							echo '<div class="wpsqt-question-response">'.$nameArray[$i].':&nbsp;'.$valueArray[$i].'&nbsp;entries</div>';
						} ?>
	<?php $givenAnswers = $wpdb->get_row("SELECT `sections` FROM `".WPSQT_TABLE_RESULTS."` ORDER BY `id` DESC LIMIT 1", ARRAY_A);
	$givenAnswers = unserialize($givenAnswers['sections']);
	if (isset($givenAnswers[$sectionKey]['answers'][$questonKey]['given'])) {
		$givenAnswers = $givenAnswers[$sectionKey]['answers'][$questonKey]['given'];
		echo '<div class="wpsqt-question-response-you">You entered: ';
		if (is_array($givenAnswers)) {
			$i = 1;
			foreach ($givenAnswers as $givenAnswer) {
				foreach($_SESSION['wpsqt'][$_SESSION['wpsqt']['current_id']]['sections'][$sectionKey]['questions'] as $question) {
					if ($question['id'] == $questonKey) {
						if ($question['type'] == 'Likert Matrix') {
							if (is_array($givenAnswer)) {
								$givenAnswerDetails = explode("_", $givenAnswer[0]);
							} else {
								$givenAnswerDetails = explode("_", $givenAnswer);
							}
							echo '<em>'.$givenAnswerDetails[0].'</em>: '.$givenAnswerDetails[1];
						} else if(isset($question['answers'][$givenAnswer]['text'])) {
							echo $question['answers'][$givenAnswer]['text'];
						} else {
							echo '<em>'.__('You didn\'t answer this question', 'wp-survey-and-quiz-tool').'</em>';
						}
						if ($i < count($givenAnswers)) 
							echo ', ';
					}
				}
				$i++;
			}
		} else {
			echo $givenAnswers;
		}
	} else {
		echo '<div class="wpsqt-question-response-you">' . __('You didn\'t answer this question', 'wp-survey-and-quiz-tool');
	}
?>
</div>
					</div>
					</div>
					<?php } ?>
		<?php } ?>
		<div class="wpsqt-survey-info">
			<strong>Survey info</strong> <?php
			$nOfParticipants = $wpdb->get_var("SELECT `total` FROM `".WPSQT_TABLE_SURVEY_CACHE."` WHERE `item_id` = '".$_SESSION['wpsqt']['item_id']."'");
			echo '<p>There has been '.$nOfParticipants.' participants</p>';
		?></div><?php
} ?>
