<?php 
// Set up the token object
require_once WPSQT_DIR.'/lib/Wpsqt/Tokens.php';
$objTokens = Wpsqt_Tokens::getTokenObject();
$objTokens->setDefaultValues();

?>

<?php
	$pollName = $quizName;
	$pollId = $_SESSION['wpsqt'][$pollName]['details']['id'];
	
	if ($_SESSION['wpsqt'][$pollName]['details']['finish_display'] == 'Poll results') {
		require_once WPSQT_DIR.'/lib/Wpsqt/Page.php';
		require_once WPSQT_DIR.'/lib/Wpsqt/Page/Main/Results/Poll.php';
		Wpsqt_Page_Main_Results_Poll::displayResults($pollId);
	} else {
		if (!empty($_SESSION['wpsqt'][$pollName]['details']['finish_message'])) {
			$message = $_SESSION['wpsqt'][$pollName]['details']['finish_message'];
			$message = $objTokens->doReplacement($message);
			echo nl2br($message);
		} else {
			echo '<h2>'; _e('Thank you for taking the poll.', 'wp-survey-and-quiz-tool'); echo '</h2>';
		}
	}
?>