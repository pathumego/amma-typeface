<?php if ( $sections == false ) { ?>

	<p>There are no results for this survey yet.</p>

<?php } else { ?>

	<?php foreach ( $sections as $sectionKey => $secton ){
			foreach ( $secton['questions'] as $questonKey => $question ) { ?>
			<h3><?php echo $question['name']; ?></h3>

			<?php if ( $question['type'] == "Multiple Choice" ||
					   $question['type'] == "Dropdown" ) {
						$googleChartUrl = 'http://chart.apis.google.com/chart?chs=400x185&cht=p';
						$valueArray    = array();
						$nameArray     = array();
					   foreach ( $question['answers'] as $answer ) {
					   		$nameArray[] = $answer['text'];
							$valueArray[] = $answer['count'];
					   }

						$googleChartUrl .= '&chd=t:'.implode(',', $valueArray);
						$googleChartUrl .= '&chl='.implode('|',$nameArray);
						?>

						<img src="<?php echo $googleChartUrl; ?>" alt="<?php echo $question['name']; ?>" />
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
							$googleChartUrl = 'http://chart.apis.google.com/chart?&cht=bvs';
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
								$googleChartUrl .= '&chs=500x250&chbh=r,70,10';
								$googleChartUrl .= '&chxt=x&chxl=0:|Strongly Disagree|Disagree|No Opinion|Agree|Strongly Agree'; // Sets labelling to x-axis only
							} else {
								$googleChartUrl .= '&chs=350x250';
								$googleChartUrl .= '&chxt=x&chxl=0:|'.implode('|', $nameArray); // Sets labelling to x-axis only
							}
							$googleChartUrl .= '&chm=N,000000,0,,10|N,000000,1,,10|N,000000,2,,10'; // Adds the count above bars
							$googleChartUrl .= '&chds=0,'.(++$maxValue); // Sets scaling to a little bit more than max value
							$googleChartUrl .= '&chd=t:'.implode(',', $valueArray); // Chart data
							?><img src="<?php echo $googleChartUrl; ?>" alt="<?php echo $question['name']; ?>" /><?php
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
					  			$googleChartUrl = 'http://chart.apis.google.com/chart?&cht=bvs';
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

								$googleChartUrl .= '&chs=350x250';

								if (isset($wordScale) && $wordScale == true) {
									$googleChartUrl .= '&chxt=x&chxl=0:|Strongly Disagree|Disagree|No Opinion|Agree|Strongly Agree'; // Sets labelling to x-axis only and labels with numbers
									$googleChartUrl .= '&chs=500x250&chbh=r,70,10'; // Makes chart wider		
								} else {
									$googleChartUrl .= '&chxt=x&chxl=0:|'.implode('|', $nameArray); // Sets labelling to x-axis only and labels with numbers
								}
								$googleChartUrl .= '&chm=N,000000,0,,10|N,000000,1,,10|N,000000,2,,10'; // Adds the count above bars
								$googleChartUrl .= '&chds=0,'.(++$maxValue); // Sets scaling to a little bit more than max value
								$googleChartUrl .= '&chd=t:'.implode(',', $valueArray); // Chart data

								echo '<h4>'.$optionkey.'</h4>';
								?><img src="<?php echo $googleChartUrl; ?>" alt="<?php echo $question['name']; ?>" /><?php
					  		}
					  } else {
							echo 'Something went really wrong, please report this bug to the GitHub Issues page. Here\'s a var dump which might make you feel better.<pre>'; var_dump($question); echo '</pre>';
					  } ?>

	<?php }
	}
} ?>
