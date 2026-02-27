<?php

require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Resultsdelete.php';

class Wpsqt_Page_Main_Resultsdelete_Survey extends Wpsqt_Page_Main_Resultsdelete {
	public function process() {
	
		global $wpdb;
		
		if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
		
			// Get the actual result we want to delete
			global $wpdb;
			$results = $wpdb->get_results("SELECT * FROM `".WPSQT_TABLE_RESULTS."` WHERE `id` = '".$_GET['resultid']."'", ARRAY_A);
			$answers = unserialize($results[0]['sections']);
			$answers = $answers[0]['answers'];
			
			// Get the cached version of the result for the survey
			$cachedResults = $wpdb->get_results("SELECT * FROM `".WPSQT_TABLE_SURVEY_CACHE."` WHERE `item_id` = '".$_GET['id']."'", ARRAY_A);
			$cachedQuestions = unserialize($cachedResults[0]['sections']);
			$cachedQuestions2 = $cachedQuestions[0]['questions'];

			// Decrement the cached counts by the amount found above
			foreach ($answers as $key => &$answer) {
				if ($cachedQuestions2[$key]['type'] == 'Likert')
					$cachedQuestions2[$key]['answers'][$answer['given']]['count']--;
				if ($cachedQuestions2[$key]['type'] == 'Multiple Choice' || $cachedQuestions2[$key]['type'] == 'Dropdown') {
					$answerGiven = (int)$answer['given'];
					$cachedQuestions2[$key]['answers'][$answerGiven]['count']--;
				}
			}
			
			// Send the updated cached result back to the db
			$cachedQuestions[0]['questions'] = $cachedQuestions2;
			$sectionToSend = serialize($cachedQuestions);
			$wpdb->query("UPDATE `".WPSQT_TABLE_SURVEY_CACHE."` SET `sections` = '".$sectionToSend."' WHERE `item_id` = '".$_GET['id']."'");
		
			$wpdb->query(
				$wpdb->prepare("DELETE FROM `".WPSQT_TABLE_RESULTS."`
								WHERE id = %d", array($_GET['resultid']))
					);
			$this->redirect(WPSQT_URL_MAIN."&section=results".
							               "&subsection=survey&id=".
							               $_GET['id']."&deleted=true");
			echo 'deleted survey result. redirecting...';
		} else {
			$this->_pageVars['personName'] = $wpdb->get_var(
												$wpdb->prepare( "SELECT person_name FROM `".WPSQT_TABLE_RESULTS."` WHERE id = %d" , array($_GET['resultid']) )
									     				);
			$this->_pageView = "admin/results/delete.php";
		}
	}
}

?>