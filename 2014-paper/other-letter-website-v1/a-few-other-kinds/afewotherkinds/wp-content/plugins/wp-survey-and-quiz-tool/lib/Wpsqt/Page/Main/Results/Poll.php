<?php

require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Results.php';

class Wpsqt_Page_Main_Results_Poll extends Wpsqt_Page_Main_Results {
	
	public function init(){

		if (isset($_POST['deleteall'])) {
			Wpsqt_System::deleteAllResults($_GET['id']);
		}

		$this->_pageView = 'admin/poll/result.php';
	}

	public function displayResults($pollId) {
		global $wpdb;

		$results = $wpdb->get_row(
					$wpdb->prepare("SELECT * FROM `".WPSQT_TABLE_SURVEY_CACHE."` WHERE item_id = %d",
								   array($pollId)), ARRAY_A
								);
		
		$sections = unserialize($results['sections']);

		if (empty($sections) || !is_array($sections)) {
			echo 'There are no results for this poll yet';
			return;
		}

		foreach ($sections as $section) {
			foreach ($section['questions'] as $question) {
				$total = 0;
				if (!empty($question['answers']) && is_array($question['answers'])) {
					foreach($question['answers'] as $answer) {
						$total += $answer['count'];
					}
				}
				echo '<h3>'.$question['name'].'</h3>';
				if ($question['type'] == 'Free Text') {
					echo 'This question has free text answers which cannot be shown';
					continue;
				}
				?>
				<table class="widefat post fixed" cellspacing="0">
				<thead>
					<tr>
						<th class="manage-column column-title" scope="col"><?php _e('Answer', 'wp-survey-and-quiz-tool'); ?></th>
						<th scope="col" width="75"><?php _e('Votes', 'wp-survey-and-quiz-tool'); ?></th>
						<th scope="col" width="90"><?php _e('Percentage', 'wp-survey-and-quiz-tool'); ?></th>
					</tr>			
				</thead>
				<tfoot>
					<tr>
						<th class="manage-column column-title" scope="col"><?php _e('Answer', 'wp-survey-and-quiz-tool'); ?></th>
						<th scope="col" width="75"><?php _e('Votes', 'wp-survey-and-quiz-tool'); ?></th>
						<th scope="col" width="90"><?php _e('Percentage', 'wp-survey-and-quiz-tool'); ?></th>
					</tr>			
				</tfoot>
				<tbody>
				<?php
				foreach ($question['answers'] as $answer) {
					$percentage = round($answer['count'] / $total * 100, 2);
					echo '<tr>';
						echo '<td>'.$answer['text'].'</td>';
						echo '<td>'.$answer['count'].'</td>';
						echo '<td>'.$percentage.'%</td>';
					echo '</tr>';
				}
				?>
				</tbody>
				</table>
				<?php
			}
		}
	}
	
}

?>
