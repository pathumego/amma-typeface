<?php
require_once WPSQT_DIR.'lib/Wpsqt/Question.php';
require_once WPSQT_DIR.'lib/Wpsqt/Mail.php';
if ( !defined('DONOTCACHEPAGE') ){
	define('DONOTCACHEPAGE',true);
}
if (!defined ('exclude_from_search') ) {
	//define('exclude_from_search',true);
}


	/**
	 * Handles the main displaying and processing
	 * of the quizzes and surveys.
	 *
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
	 * @license http://www.gnu.org/licenses/gpl.html GPL v3
	 */

class Wpsqt_Shortcode {

	/**
	 * Defines what step in the quiz/survey we are in.
	 *
	 * @var integer
	 * @since 2.0
	 */
	protected $_step;

	/**
	 * Holds any errors which have happened within
	 * the process from construction to display.
	 *
	 * @var array
	 * @since 2.0
	 */
	protected $_errors = array();

	/**
	 * Contains either quiz or survey. Used for selected
	 * what filters are applied
	 *
	 * @var string
	 * @since 2.0
	 */
	protected $_type;

	/**
     * The current section key.
     *
     * @var integer
     * @since 2.0
	 */
	protected $_key;
	/**
	 * The identifier for the question.
	 *
	 * @var string
	 * @since 2.0
	 */
	protected $_identifier;

	protected $_acceptableTypes = array('quiz','survey', 'poll');

	protected $_restore = false;

	/**
	 * Starts the shortcode off firstly checks to see
	 * if there is a wpsqt key item in the session
	 * array. Then checks to see if there is a step
	 * number provided if not it's zero. If the step
	 * is zero we then build up the quiz data, fetching
	 * the quiz first, then fetching the sections.
	 *
	 * @param integer $identifier
	 * @since 2.0
	 */
	public function __construct($identifier,$type){

		global $wpdb;

		if ( !isset($_SESSION['wpsqt']) ){
			$_SESSION['wpsqt'] = array();
		}

		if ( empty($identifier) ) {
			$this->_errors['name'] = "The name is missing for ".$type;
		}

		$this->_acceptableTypes = apply_filters("wpsqt_shortcode_types",$this->_acceptableTypes);
		$this->_acceptableTypes = array_map("strtolower",$this->_acceptableTypes);
		if ( !in_array($type, $this->_acceptableTypes) ) {
			$this->_errors['type'] = "Invalid type given";
		}

		$_SESSION['wpsqt']['current_type'] = $type;
		$this->_type = $type;
		$this->_step = ( isset($_POST['step']) && ctype_digit($_POST['step']) ) ? intval($_POST['step']) : 0;
		$_SESSION['wpsqt']['current_id'] = $identifier;
		if ( $this->_step == 0 ){

			$_SESSION['wpsqt'][$identifier]['start_time'] = microtime(true);
			$_SESSION['wpsqt'][$identifier]['person'] = array();
			$_SESSION['wpsqt'][$identifier]['details'] = Wpsqt_System::getItemDetails($identifier, $type);

			$_SESSION['wpsqt']['item_id'] = $_SESSION['wpsqt'][$identifier]['details']['id'];
			if ( !empty($_SESSION['wpsqt'][$identifier]['details']) ){
				$_SESSION['wpsqt'][$identifier]['sections'] = $wpdb->get_results(
														$wpdb->prepare("SELECT * FROM `".WPSQT_TABLE_SECTIONS."` WHERE item_id = %d ORDER BY `id` ASC",
																		array($_SESSION['wpsqt'][$identifier]['details']['id'])), ARRAY_A
												);
			} else {
				$noquiz = true;
			}

		}

		if ( empty($_SESSION['wpsqt'][$identifier]['details']) ){
			if ( !isset($noquiz) ){
				$this->_errors['session'] = true;
			} else {
				$this->_errors['noexist'] = true;
			}
		}

		if (isset($_COOKIE['wpsqt_'.$_SESSION['wpsqt']['item_id'].'_state'])) {
			$uid = $_COOKIE['wpsqt_'.$_SESSION['wpsqt']['item_id'].'_state'];
			if (!empty($uid)) {
				$state = $wpdb->get_row("SELECT * FROM ".WPSQT_TABLE_QUIZ_STATE." WHERE uid = '{$uid}'", ARRAY_A);
				$answers = unserialize($state['answers']);

				$_SESSION['wpsqt'] = $answers;
				$_POST = unserialize($state['post']);
	?>
	<script type="text/javascript">
		function setCookie(c_name,value,exdays) {
			var exdate=new Date();
			exdate.setDate(exdate.getDate() + exdays);
			var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
			document.cookie=c_name + "=" + c_value;
		}
		setCookie('wpsqt_<?php echo $_SESSION['wpsqt'][$identifier]['details']['id']; ?>_state', '', '-10');
	</script>
	<?php

				$this->_key = $state['current_section'];
				$this->_step = $state['current_section'];
				$this->_restore = true;
			}

		}
	}

	/**
	 * Displays the quiz/survey.
	 *
	 * @since 2.0
	 */

	// Guy 1: What does this do?
	// Guy 2: Dunno.
	// Guy 1: What does the comment say?
	// Guy 2: "Displays the quiz/survey"
	// Guy 2: I better look at the source!
	// http://geekandpoke.typepad.com/.a/6a00d8341d3df553ef014e5f3e2868970c-pi
	public function display(){

		global $wpdb;

		// Check and see if there is a major issue.
		if ( !empty($this->_errors) ){
			global $message;
			if ( isset($this->_errors["session"]) ){
				$message = __("PHP Sessions error. Check your sessions settings.", 'wp-survey-and-quiz-tool');
			} elseif ( isset($this->_errors["noexist"]) ){
				$message = __("No such quiz/survey/poll", 'wp-survey-and-quiz-tool');
			} elseif ( isset($this->_errors['name']) ) {
				$message = __("No quiz identifier/name was given", 'wp-survey-and-quiz-tool');
			} elseif ( isset($this->_errors["type"]) ){
				$message = __("Invalid type given", 'wp-survey-and-quiz-tool');
			}
			$message = apply_filters("wpsqt_".$this->_type."_error",$message, $this->_errors);
			echo $message;
			return;
		}
		$quizName = $_SESSION['wpsqt']['current_id'];

		// Checks if the quiz/survey/poll is disabled
		if (isset($_SESSION['wpsqt'][$quizName]['details']['status']) && $_SESSION['wpsqt'][$quizName]['details']['status'] == 'disabled') {
			printf(__('This %s is currently disabled.', 'wp-survey-and-quiz-tool'), $_SESSION['wpsqt'][$quizName]['details']['type']);
			return;
		}

		// Checks if limiting per IP is enabled and if the user has already taken it
		if (isset($_SESSION['wpsqt'][$quizName]['details']['limit_one']) && $_SESSION['wpsqt'][$quizName]['details']['limit_one'] == 'yes') {
			$item_id = $_SESSION['wpsqt'][$quizName]['details']['id'];
			$ip = $_SERVER['REMOTE_ADDR'];
			$results = $wpdb->get_results('SELECT * FROM `'.WPSQT_TABLE_RESULTS. '` WHERE `ipaddress` = "'.$ip.'" AND `item_id` = "'.$item_id.'"', ARRAY_A);
			if (count($results) != 0) {
				printf(__('You appear to have already taken this %s.', 'wp-survey-and-quiz-tool'), $this->_type);
				if (($this->_type == 'poll' || $this->_type == 'survey') && isset($_SESSION['wpsqt'][$quizName]['details']['show_results_limited']) && $_SESSION['wpsqt'][$quizName]['details']['show_results_limited'] == 'yes') {
					require_once WPSQT_DIR.'/lib/Wpsqt/Page.php';
					require_once WPSQT_DIR.'/lib/Wpsqt/Page/Main/Results/Poll.php';
					Wpsqt_Page_Main_Results_Poll::displayResults($item_id);
				}
				return;
			}
		}

		// Checks if limiting per WP user is enabled and if the user has already taken it
		if (isset($_SESSION['wpsqt'][$quizName]['details']['limit_one_wp']) && $_SESSION['wpsqt'][$quizName]['details']['limit_one_wp'] == 'yes') {
			global $user_login;
			$item_id = $_SESSION['wpsqt'][$quizName]['details']['id'];
			$results = $wpdb->get_results('SELECT * FROM `'.WPSQT_TABLE_RESULTS. '` WHERE `item_id` = "'.$item_id.'"', ARRAY_A);
			foreach ($results as $result) {
				if (isset($result['person_name']) && $result['person_name'] == $user_login) {
					printf(__('You appear to have already taken this %s.', 'wp-survey-and-quiz-tool'), $this->_type);
					if (($this->_type == 'poll' || $this->_type == 'survey') && isset($_SESSION['wpsqt'][$quizName]['details']['show_results_limited']) && $_SESSION['wpsqt'][$quizName]['details']['show_results_limited'] == 'yes') {
						$id = (int) $_SESSION['wpsqt']['item_id'];
						$result = $wpdb->get_row("SELECT * FROM `".WPSQT_TABLE_SURVEY_CACHE."` WHERE item_id = '".$id."'", ARRAY_A);
						$sections = unserialize($result['sections']);
						require_once WPSQT_DIR.'/lib/Wpsqt/Page.php';
						require_once WPSQT_DIR.'/lib/Wpsqt/Page/Main/Results/Poll.php';
						Wpsqt_Page_Main_Results_Poll::displayResults($id);
					}
					return;
				}
			}
		}

		// Checks if limiting by cookie is enabled and if the user has already taken it
		if (isset($_SESSION['wpsqt'][$quizName]['details']['limit_one_cookie']) && $_SESSION['wpsqt'][$quizName]['details']['limit_one_cookie'] == 'yes') {
			$quizNameEscaped = str_replace(" ", "_", $quizName);
			if (isset($_COOKIE['wpsqt_'.$quizNameEscaped.'_taken']) && $_COOKIE['wpsqt_'.$quizNameEscaped.'_taken'] == 'yes') {
				printf(__('You appear to have already taken this %s.', 'wp-survey-and-quiz-tool'), $this->_type);
				if (($this->_type == 'poll' || $this->_type == 'survey') && isset($_SESSION['wpsqt'][$quizName]['details']['show_results_limited']) && $_SESSION['wpsqt'][$quizName]['details']['show_results_limited'] == 'yes') {
					$id = (int) $_SESSION['wpsqt']['item_id'];
					$result = $wpdb->get_row("SELECT * FROM `".WPSQT_TABLE_SURVEY_CACHE."` WHERE item_id = '".$id."'", ARRAY_A);
					$sections = unserialize($result['sections']);
					require_once WPSQT_DIR.'/lib/Wpsqt/Page.php';
					require_once WPSQT_DIR.'/lib/Wpsqt/Page/Main/Results/Poll.php';
					Wpsqt_Page_Main_Results_Poll::displayResults($id);
				}
				return;
			}
		}

		// handle contact form and all the stuff that comes with it.
		if ( isset($_SESSION['wpsqt'][$quizName]['details']['contact']) && $_SESSION['wpsqt'][$quizName]['details']['contact'] == "yes" && $this->_step <= 1 ){
			$fields = $wpdb->get_results(
							$wpdb->prepare("SELECT * FROM `".WPSQT_TABLE_FORMS."` WHERE item_id = %d ORDER BY id ASC",
							array($_SESSION['wpsqt'][$quizName]['details']['id'])),ARRAY_A
										);
			$fields = apply_filters("wpsqt_".$this->_type."_form_fields",$fields);

			if ( $this->_step == 1 ){
				$errors = array();
				$_SESSION['wpsqt'][$quizName]['person'] = array();
				foreach ( $fields as $key => $field ){

					if ( empty($field) ){
						continue;
					}

					$fieldName = preg_replace('~[^a-z0-9]~i','',$field['name']);
					$fields[$key]['value'] = $_POST["Custom_".$fieldName];

					if ( !isset($_POST["Custom_".$fieldName]) || empty($_POST["Custom_".$fieldName]) ){
						if ( $field['required'] == 'yes' ){
							/* translators: %s is the question name */
							$errors[] = sprintf(__('%s is required', 'wp-survey-and-quiz-tool'), $field['name']);
						}
					} else {
						$field['value'] = $_POST["Custom_".$fieldName];
						$_SESSION['wpsqt'][$quizName]['person'][ strtolower($field['name']) ] = $_POST["Custom_".$fieldName];
					}
				}

				if ( !empty($errors) ) {
					do_action("wpsqt_".$this->_type."_form","original");
					require Wpsqt_Core::pageView('site/shared/custom-form.php');
					return;
				}

			} else {
				do_action("wpsqt_".$this->_type."_form","original");
				require Wpsqt_Core::pageView('site/shared/custom-form.php');
				return;
			}

		}
		if ( isset($_SESSION['wpsqt'][$quizName]['details']['contact']) && $_SESSION['wpsqt'][$quizName]['details']['contact'] == "yes" ){
			$this->_key = $this->_step - 1;
		} else {
			$this->_key = $this->_step;
		}

		// Handles the timer if enabled
		if (is_page() || is_single()) {
			if (isset($_SESSION['wpsqt'][$quizName]['details']['timer']) && $_SESSION['wpsqt'][$quizName]['details']['timer'] != '0' && $_SESSION['wpsqt'][$quizName]['details']['timer'] != "") {
				$timerVal = ((int) $_SESSION['wpsqt'][$quizName]['details']['timer']) * 60;
				if ($this->_key != 0) {
					// Resume timer
					$timerVal = $timerVal - $_POST['wpsqt_time_elapsed'];
				}
				echo '<div class="timer" style="float: right;"></div>';
				$timerStrings = array(
					'timeleft' => __('Time Left:', 'wp-survey-and-quiz-tool'),
					'mins' => __('minutes and', 'wp-survey-and-quiz-tool'),
					'secs' => __('seconds', 'wp-survey-and-quiz-tool'),
					'outoftime' => __('Unfortunately you have run out of time for this quiz', 'wp-survey-and-quiz-tool'),
				);
				?>
					<script type="text/javascript">
						jQuery(document).ready( function(){
							var timeSecs = <?php echo $timerVal; ?>;
							var refreshId = setInterval(function() {
								if (timeSecs != 0) {
									timeSecs = timeSecs - 1;
									var timeMins = timeSecs / 60;
									timeMins = (timeMins<0?-1:+1)*Math.floor(Math.abs(timeMins)); // Gets rid of the decimal place
									var timeSecsRem = timeSecs % 60;
									if (timeMins > 0) {
										jQuery(".timer").html("<?php echo $timerStrings['timeleft']; ?> " + timeMins + " <?php echo $timerStrings['mins']; ?> " + timeSecsRem + " <?php echo $timerStrings['secs']; ?>");
									} else {
										jQuery(".timer").html("<?php echo $timerStrings['timeleft']; ?>" + timeSecsRem + " <?php echo $timerStrings['secs']; ?>");
									}

									var timeElapsed = jQuery(".wpsqt_time_elapsed");
									timeElapsed.attr('value', parseInt(timeElapsed.attr('value')) + 1);
								} else {
									jQuery(".quiz").html("<?php echo $timerStrings['outoftime']; ?>");
									jQuery(".timer").hide();
								}
							}, 1000);
						});
					</script>
				<?php
			}
		}

		// if we are still here then we are to
		// show the section with some questions and stuff.

		$requiredQuestions = array('exist' => 0, 'given' => array());
		if ( $this->_key != 0 ){
			// We should have data to deal with.

			$incorrect = 0;
			$correct = 0;
			$pastSectionKey = $this->_key - 1;

			if (!$this->_restore) {
				$_SESSION['wpsqt'][$quizName]['sections'][$pastSectionKey]['answers'] = array();
			}
			$canAutoMark = true;
			if (isset($_SESSION["wpsqt"][$quizName]["sections"][$pastSectionKey]["questions"]) && is_array($_SESSION["wpsqt"][$quizName]["sections"][$pastSectionKey]["questions"])) {
				foreach ($_SESSION["wpsqt"][$quizName]["sections"][$pastSectionKey]["questions"] as $questionData ){
					if ( isset($questionData['required']) && $questionData['required'] == "yes") {
						$requiredQuestions['exist']++;
					}
				}
			}

			if ( isset($_POST['answers']) ){

				foreach ( $_POST['answers'] as $questionKey => $givenAnswers ){
					$answerMarked = array();
					$questionData =  (isset($_SESSION["wpsqt"][$quizName]["sections"][$pastSectionKey]["questions"][$questionKey])) ? $_SESSION["wpsqt"][$quizName]["sections"][$pastSectionKey]["questions"][$questionKey] : array();
					$questionId = $questionData['id'];

					if ( $questionData["type"] == "Single" ||
						 $questionData["type"] == "Multiple" ) {
						if ( !isset($_SESSION["wpsqt"][$quizName]["sections"][$pastSectionKey]["questions"][$questionKey]) ){
							$incorrect++;
							continue;
						}// END if isset question
						$subNumOfCorrect = 0;
						$subCorrect = 0;
						$subIncorrect = 0;
						foreach ( $questionData["answers"] as $answerKey => $rawAnswers ){
							$numberVarName = "";
							if ($rawAnswers["correct"] == "yes"){
								$numberVarName = "subCorrect";
								$subNumOfCorrect++;
							} else {
								$numberVarName = "subIncorrect";
							}

							if ( in_array($answerKey, $givenAnswers) ){
								${$numberVarName}++;
							}
						}

						if ( $subCorrect === $subNumOfCorrect && $subIncorrect === 0 ){
							$correct += $questionData["points"];
							$answerMarked['mark'] = __('correct', 'wp-survey-and-quiz-tool');
						}
						else {
							// TODO Insert ability to set point per answer scores

							$incorrect += $questionData["points"];
							$answerMarked['mark'] = __('incorrect', 'wp-survey-and-quiz-tool');
						}
					} else {
							$canAutoMark = false;
					}// END if section type == multiple

					if ( isset($questionData['required']) && $questionData['required'] == 'yes' ){
						if ($questionData['type'] == 'Free Text') {
							if ($givenAnswers[0] != '') {
								$requiredQuestions['given'][] = $questionId;
							}
						} else {
							$requiredQuestions['given'][] = $questionId;
						}
					}


					$answerMarked["given"] = $givenAnswers;
					$_SESSION["wpsqt"][$quizName]["sections"][$pastSectionKey]["answers"][$questionId] = $answerMarked;
				}// END foreach answer
				$_SESSION["wpsqt"][$quizName]["sections"][$pastSectionKey]["stats"] = array("correct" => $correct, "incorrect" => $incorrect);
				$_SESSION["wpsqt"][$quizName]["sections"][$pastSectionKey]["can_automark"] = $canAutoMark;
			}// END if isset($_POST['answers'])

		}

		if ( isset($requiredQuestions) && $requiredQuestions['exist'] > sizeof($requiredQuestions['given']) && !$this->_restore ){
			$_SESSION['wpsqt']['current_message'] = __('Not all the required questions were answered!', 'wp-survey-and-quiz-tool');
			$this->_step--;
			$this->_key--;
		}

		$_SESSION['wpsqt']['current_step'] = $this->_step;
		$_SESSION['wpsqt']['required'] = $requiredQuestions;

		// if equal or greater than so other
		// plugins can add extra steps at the end.
		if ( sizeof($_SESSION["wpsqt"][$quizName]["sections"]) <= $this->_key  &&
			!isset($_POST['wpsqt-save-state'])){
			// finished!
			do_action("wpsqt_".$this->_type."_finished",$this->_step);
			$this->finishQuiz();

			return;
		} else {
			// Show section.
			do_action("wpsqt_".$this->_type."_step",$this->_step);
			$this->showSection();

			if (isset($_SESSION['wpsqt'][$quizName]['details']['show_progress_bar']) && $_SESSION['wpsqt'][$quizName]['details']['show_progress_bar'] == 'yes') {
				// Progress bar
				$current_step = $this->_step + 1;
				// If there is a contact page then loose 1
				if (isset($_SESSION['wpsqt'][$quizName]['details']['contact']) && $_SESSION['wpsqt'][$quizName]['details']['contact'] == "yes") {
					$current_step--;
				}
				printf(__('Page %d out of %d', 'wp-survey-and-quiz-tool'), $current_step, (sizeof($_SESSION["wpsqt"][$quizName]["sections"])));
				$percentage = $current_step / (sizeof($_SESSION["wpsqt"][$quizName]["sections"])) * 100;
				?>
				<div class="wpsqt-progress">
					<div style="width: <?php echo $percentage; ?>%;">
					</div>
				</div>

				<?php
			}
			return;
		}

	}

	/**
	 * Handles showing the section.
	 *
	 * @since 2.0
	 */
	public function showSection(){

		global $wpdb;

		$quizName = $_SESSION["wpsqt"]["current_id"];
		$sectionKey = $this->_key;

		if (isset($_POST['wpsqt-save-state']) && isset($_SESSION['wpsqt'][$quizName]['details']['save_resume']) && $_SESSION['wpsqt'][$quizName]['details']['save_resume'] == 'yes') {
			Wpsqt_Core::saveCurrentState($sectionKey);
			_e('Saved the current state. You can resume by revisiting the quiz.', 'wp-survey-and-quiz-tool');
			$sectionKey--;
			$show = false;
		} else {
			$show = true;
		}

		$section = $_SESSION["wpsqt"][$quizName]["sections"][$sectionKey];
		$orderBy = ($section["order"] == "random") ? "RAND()" : "`order` ".strtoupper($section["order"]);
		$_SESSION["wpsqt"][$quizName]["sections"][$sectionKey]["questions"] = array();


		if ( !empty($_SESSION["wpsqt"][$quizName]["sections"][$sectionKey]['limit']) ){
			$end = " LIMIT 0,".$_SESSION["wpsqt"][$quizName]["sections"][$sectionKey]['limit'];
		} else {
			$end = '';
		}

		$rawQuestions = $wpdb->get_results(
							$wpdb->prepare("SELECT * FROM `".WPSQT_TABLE_QUESTIONS.
										   "` WHERE section_id = %d ORDER BY ".$orderBy.$end,
										  array($section["id"])),ARRAY_A
								);

		foreach ( $rawQuestions as $rawQuestion ){
			$_SESSION["wpsqt"][$quizName]["sections"][$sectionKey]["questions"][] = Wpsqt_System::unserializeQuestion($rawQuestion, $this->_type);
		}

		if ($show) {
			require Wpsqt_Core::pageView('site/'.$this->_type.'/section.php');
		}

	}

	/**
	 * Handles the end of the quiz/survey.
	 *
	 * @since 2.0
	 */
	public function finishQuiz(){

		global $wpdb;

		$quizName = $_SESSION['wpsqt']['current_id'];

		if (isset($_SESSION['wpsqt'][$quizName]['details']['timer']) && $_SESSION['wpsqt'][$quizName]['details']['timer'] != '0' && $_SESSION['wpsqt'][$quizName]['details']['timer'] != "") {
				?>
					<script type="text/javascript">
						jQuery(document).ready( function(){
							jQuery(".timer").hide();
						});
					</script>
				<?php
			$time_allowed = $_SESSION['wpsqt'][$quizName]['details']['timer'] * 60;
			$start_time = $_SESSION['wpsqt'][$quizName]['start_time'];
			// Allow an extra 5 seconds per section for loading
			$loading_allowance = count($_SESSION['wpsqt'][$quizName]['sections']) * 5;

			if (($start_time + $time_allowed + $loading_allowance) < time()) {
				_e('You have taken longer than the allowed time.', 'wp-survey-and-quiz-tool');
				return;
			}
		}

		if ( isset($_SESSION['wpsqt'][$quizName]['details']['use_wp']) && $_SESSION['wpsqt'][$quizName]['details']['use_wp'] == 'yes'){
			$objUser = wp_get_current_user();
			if ($objUser->data != NULL) {
				$_SESSION['wpsqt'][$quizName]['person']['name'] = $objUser->user_login;
				$_SESSION['wpsqt'][$quizName]['person']['fname'] = $objUser->first_name;
				$_SESSION['wpsqt'][$quizName]['person']['lname'] = $objUser->last_name;
				$_SESSION['wpsqt'][$quizName]['person']['email'] = $objUser->user_email;
			} else {
				$_SESSION['wpsqt'][$quizName]['person']['name'] = 'Anonymous';
			}
		}

		$personName = (isset($_SESSION['wpsqt'][$quizName]['person']['name'])) ? $_SESSION['wpsqt'][$quizName]['person']['name'] :  'Anonymous';
		$timeTaken = microtime(true) - $_SESSION['wpsqt'][$quizName]['start_time'];



		$totalPoints = 0;
		$correctAnswers = 0;
		$canAutoMark = true;

		if ($_SESSION['wpsqt'][$quizName]['details']['type'] == 'quiz') {
			$passMark = (int)$_SESSION['wpsqt'][$quizName]['details']['pass_mark'];
			// Set $AutoMarkWhenFreetext
			if ( isset($_SESSION['wpsqt'][$quizName]['details']['automark_whenfreetxt']) ) {
				$AutoMarkWhenFreetxt = $_SESSION['wpsqt'][$quizName]['details']['automark_whenfreetxt'];
			} else {
				$AutoMarkWhenFreetxt = "no";
			}
		} else {
			$AutoMarkWhenFreetxt = false;
		}

		foreach ( $_SESSION['wpsqt'][$quizName]['sections'] as $quizSection ){
			if ( $this->_type != "quiz" || ( isset($quizSection['can_automark']) && $quizSection['can_automark'] == false) ){
				// Only if AutoMarkWhenFreetext is set to 'yes' will $canAutoMark be ignored
				if (  preg_match( "/yes/" , $AutoMarkWhenFreetxt) !== 1 ) {
					$canAutoMark = false;
					break;
				}
			}

			foreach ( $quizSection['questions'] as $key => $question ){
				//  AutoMarkWhenFreetext: 'no' and 'include' will mark freetext questions as 'incorrect',
				// 'exclude will ignore the freetext questions' and not add them to the $totalPoints
				if (  ! (  preg_match( "/exclude/" , $AutoMarkWhenFreetxt) == 1  && ($question['type'] == "Free Text"))   ){
					$totalPoints += $question['points'];
				}
			}

			if ( !isset($quizSection['stats']) ) {
				continue;
			}

			if ( isset($quizSection['stats']['correct']) ){
				$correctAnswers += $quizSection['stats']['correct'];
			}

		}

		if ( $canAutoMark === true ){
			$_SESSION['wpsqt']['current_score'] = $correctAnswers." correct out of ".$totalPoints;
		} else {
			$_SESSION['wpsqt']['current_score'] = __('Quiz can\'t be auto marked', 'wp-survey-and-quiz-tool');
		}

		if ( $correctAnswers !== 0 ){
			$percentRight = ( $correctAnswers / $totalPoints ) * 100;
		} else {
			$percentRight = 0;
		}

		$status = 'unviewed';
		$pass = '0';

		if ($_SESSION['wpsqt'][$quizName]['details']['type'] == 'quiz') {
			// Check if pass
			if ($percentRight >= $passMark)
				$pass = '1';

			if ($pass == '1') {
				$status = 'Accepted';
			} else {
				$status = 'unviewed';
			}
		}

		if ( !isset($_SESSION['wpsqt'][$quizName]['details']['store_results']) ||  $_SESSION['wpsqt'][$quizName]['details']['store_results'] !== "no" ){
			$wpdb->query(
				$wpdb->prepare("INSERT INTO `".WPSQT_TABLE_RESULTS."` (datetaken,timetaken,person,sections,item_id,person_name,ipaddress,score,total,percentage,status,pass)
								VALUES (%s,%d,%s,%s,%d,%s,%s,%d,%d,%d,%s,%d)",
								   array($_SESSION['wpsqt'][$quizName]['start_time'],
							   		 $timeTaken,
							   		 serialize($_SESSION['wpsqt'][$quizName]['person']),
							   		 serialize($_SESSION['wpsqt'][$quizName]['sections']),
							   		 $_SESSION['wpsqt'][$quizName]['details']['id'],
							   		 $personName,$_SERVER['REMOTE_ADDR'],$correctAnswers,$totalPoints,$percentRight,$status,$pass ) )
					);

			$_SESSION['wpsqt']['result_id'] = $wpdb->insert_id;
		} else {
			$_SESSION['wpsqt']['result_id'] = null;
		}
		$emailAddress = get_option('wpsqt_contact_email');

		if ( isset($_SESSION['wpsqt'][$quizName]['details']['notificaton_type']) && $_SESSION['wpsqt'][$quizName]['details']['notificaton_type'] == 'instant' ){
			$emailTrue = true;
		} elseif ( isset($_SESSION['wpsqt'][$quizName]['details']['notificaton_type']) && $_SESSION['wpsqt'][$quizName]['details']['notificaton_type'] == 'instant-100'
					&& $percentRight == 100 ) {
			$emailTrue = true;
		} elseif ( isset($_SESSION['wpsqt'][$quizName]['details']['notificaton_type']) && $_SESSION['wpsqt'][$quizName]['details']['notificaton_type'] == 'instant-75'
					 && $percentRight > 75 ){
			$emailTrue = true;
		} elseif ( isset($_SESSION['wpsqt'][$quizName]['details']['notificaton_type']) && $_SESSION['wpsqt'][$quizName]['details']['notificaton_type'] == 'instant-50'
					&& $percentRight > 50 ){
			$emailTrue = true;
		} elseif ( isset($_SESSION['wpsqt'][$quizName]['details']['notificaton_type']) && isset($_SESSION['wpsqt'][$quizName]['details']['send_user']) && $_SESSION['wpsqt'][$quizName]['details']['send_user'] == 'yes' ) {
			$emailTrue = true;
		}

		if ( isset($emailTrue) ){
			Wpsqt_Mail::sendMail();
		}

		if ( $this->_type == "survey" || $this->_type == "poll" ){
			$this->_cacheSurveys();
		}

		if ( isset($_SESSION['wpsqt'][$quizName]['details']['limit_one_cookie']) && $_SESSION['wpsqt'][$quizName]['details']['limit_one_cookie'] == 'yes' ){
			// Create the cookie
			?>
			<script type="text/javascript">
			var c_name = "wpsqt_<?php echo $quizName; ?>_taken";
			var value = "yes"
			var exdays = 365;
			var exdate = new Date();
			exdate.setDate(exdate.getDate() + exdays);
			var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
			document.cookie=c_name + "=" + c_value;
			</script>
			<?php
		}

		require_once Wpsqt_Core::pageView('site/'.$this->_type.'/finished.php');
		unset($_SESSION['wpsqt']['result_id']);
	}

	/**
	 * Handles creating a cache of the survey total results so results
	 * can still be viewed even while a massive survey polling is on
	 * going.
	 *
	 * @todo look into optimizations and possible better ways.
	 *
	 * @since 2.0
	 */
	protected function _cacheSurveys(){

		global $wpdb;

		$quizName = $_SESSION['wpsqt']['current_id'];

		$surveyResults = $wpdb->get_row(
							$wpdb->prepare("SELECT * FROM `".WPSQT_TABLE_SURVEY_CACHE."` WHERE item_id = %d",
											array($_SESSION['wpsqt'][$quizName]['details']['id']) ),ARRAY_A
									);
		if ( !empty($surveyResults) ){
			$cachedSections = unserialize($surveyResults['sections']);
		} else {
			$cachedSections = array();
		}

		foreach ( $_SESSION['wpsqt'][$quizName]['sections'] as $sectionKey => $section ) {

			if ( !array_key_exists($sectionKey,$cachedSections) ){
				$cachedSections[$sectionKey] = array();
				$cachedSections[$sectionKey]['questions'] = array();
			}
			foreach ( $section['questions'] as $questionKey => $question ) {

				if ( !array_key_exists($question['id'], $cachedSections[$sectionKey]['questions']) ) {
					$cachedSections[$sectionKey]['questions'][$question['id']] = array();
					$cachedSections[$sectionKey]['questions'][$question['id']]['name'] = $question['name'];
					$cachedSections[$sectionKey]['questions'][$question['id']]['type'] = $question['type'];
					$cachedSections[$sectionKey]['questions'][$question['id']]['answers'] = array();
				}
				if ( $cachedSections[$sectionKey]['questions'][$question['id']]['type'] == "Multiple Choice" ||
					 $cachedSections[$sectionKey]['questions'][$question['id']]['type'] == "Dropdown" ||
					 $cachedSections[$sectionKey]['questions'][$question['id']]['type'] == 'Single' ||
					 $cachedSections[$sectionKey]['questions'][$question['id']]['type'] == 'Multiple') {
					if ( empty($cachedSections[$sectionKey]['questions'][$question['id']]['answers']) ) {
						foreach ( $question['answers'] as $answerKey => $answers ){
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers'][$answerKey] = array("text" => $answers['text'],"count" => 0);
						}
					 }
				} elseif ($cachedSections[$sectionKey]['questions'][$question['id']]['type'] == "Likert Matrix") {
					// Enables the results script to have access to the scale of the likert matrix
					if (isset($_SESSION['wpsqt'][$quizName]['sections'][$sectionKey]['questions'][$questionKey]['likertmatrixscale']) && $_SESSION['wpsqt'][$quizName]['sections'][$sectionKey]['questions'][$questionKey]['likertmatrixscale'] == 'Disagree/Agree') {
						$cachedSections[$sectionKey]['questions'][$question['id']]['scale'] = 'disagree/agree';
					} else {
						$cachedSections[$sectionKey]['questions'][$question['id']]['scale'] = '1-5';
					}

					if (empty($cachedSections[$sectionKey]['questions'][$question['id']]['answers'])) {
						foreach ($question['answers'] as $key => $answer) {
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers'][$answer['text']]['1'] = array('count' => 0);
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers'][$answer['text']]['2'] = array('count' => 0);
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers'][$answer['text']]['3'] = array('count' => 0);
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers'][$answer['text']]['4'] = array('count' => 0);
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers'][$answer['text']]['5'] = array('count' => 0);
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers']['other']['1'] = array('count' => 0);
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers']['other']['2'] = array('count' => 0);
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers']['other']['3'] = array('count' => 0);
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers']['other']['4'] = array('count' => 0);
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers']['other']['5'] = array('count' => 0);
						}
					}
				} elseif ( $cachedSections[$sectionKey]['questions'][$question['id']]['type'] == "Likert" ||
						   $cachedSections[$sectionKey]['questions'][$question['id']]['type'] == "Scale" ){
				 	if ( empty($cachedSections[$sectionKey]['questions'][$question['id']]['answers']) ) {
				 		if ($question['likertscale'] != 'Agree/Disagree') {
				 			$scale = (int) $question['likertscale'];
							for ( $i = 1; $i <= $scale; ++$i ){
								$cachedSections[$sectionKey]['questions'][$question['id']]['answers'][$i] = array('count' => 0);
							}
						} else {
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers']['Strongly Disagree'] = array('count' => 0);
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers']['Disagree'] = array('count' => 0);
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers']['No Opinion'] = array('count' => 0);
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers']['Agree'] = array('count' => 0);
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers']['Strongly Agree'] = array('count' => 0);
						}
					}
				} elseif ( $cachedSections[$sectionKey]['questions'][$question['id']]['type'] == "Free Text" ){
					if ( empty($cachedSections[$sectionKey]['questions'][$question['id']]['answers']) ) {
						$cachedSections[$sectionKey]['questions'][$question['id']]['answers'] = 'None Cached - Free Text Result';
					}
					continue;
				} else {
					if ( empty($cachedSections[$sectionKey]['questions'][$question['id']]['answers']) && $cachedSections[$sectionKey]['questions'][$question['id']]['type'] != "Likert Matrix" ) {
						$cachedSections[$sectionKey]['questions'][$question['id']]['answers'] = 'None Cached - Not a default question type.';
					}
					continue;
				}
				if ($cachedSections[$sectionKey]['questions'][$question['id']]['type'] == "Likert") {
					if(isset($section['answers'][$question['id']])) {
						$givenAnswer = $section['answers'][$question['id']]['given'];
					} else {
						$givenAnswer = NULL;
					}
				} else {
					if(isset($section['answers'][$question['id']])) {
						if (is_array($section['answers'][$question['id']]['given']) && count($section['answers'][$question['id']]['given']) > 1) {
							$givenAnswer = $section['answers'][$question['id']]['given'];
						} else {
							$givenAnswer = (int) current($section['answers'][$question['id']]['given']);
						}
					} else {
						$givenAnswer = NULL;
					}
				}
				// This is only run on a poll multiple question.
				if ($cachedSections[$sectionKey]['questions'][$question['id']]['type'] == "Multiple") {
					if(isset($section['answers'][$question['id']])) {
						$givenAnswer = array();
						foreach( $section['answers'][$question['id']]['given'] as $gAnswer) {
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers'][$gAnswer]["count"]++;
						}
					} else {
						$givenAnswer = NULL;
					}
				}
				if ($cachedSections[$sectionKey]['questions'][$question['id']]['type'] == "Likert Matrix") {
					if (isset($section['answers'][$question['id']]['given'])) {
						foreach ($section['answers'][$question['id']]['given'] as $givenAnswerData) {
							if (is_array($givenAnswerData)) {
								// Other field:
								$otherText = $givenAnswerData['text'];
								$givenAnswerData = explode("_", $givenAnswerData[0]);
								$cachedSections[$sectionKey]['questions'][$question['id']]['answers'][$givenAnswerData[0]][$givenAnswerData[1]]['count'] += 1;
							} else {
								$givenAnswerData = explode("_", $givenAnswerData);
								$cachedSections[$sectionKey]['questions'][$question['id']]['answers'][$givenAnswerData[0]][$givenAnswerData[1]]['count'] += 1;
							}
						}
					}
				}
				if ($cachedSections[$sectionKey]['questions'][$question['id']]['type'] == "Likert") {
					$cachedSections[$sectionKey]['questions'][$question['id']]['answers'][$givenAnswer]['count']++;
				}
				if (isset($question['likertscale']) && $question['likertscale'] == 'Agree/Disagree') {
				 	if(isset($section['answers'][$question['id']])) {
						$givenAnswer = $section['answers'][$question['id']]['given'];
					} else {
						$givenAnswer = NULL;
					}
				}
				$type = $cachedSections[$sectionKey]['questions'][$question['id']]['type'];
				if (isset($type) && $type != "Multiple" && $type != "Likert" && $type != "Likert Matrix" && isset($givenAnswer)) {
					if (is_array($givenAnswer)) {
						foreach ($givenAnswer as $answer) {
							$cachedSections[$sectionKey]['questions'][$question['id']]['answers'][$answer]["count"]++;
						}
					} else {
						$cachedSections[$sectionKey]['questions'][$question['id']]['answers'][$givenAnswer]["count"]++;
					}
				}
			}
		}
		if ( !empty($surveyResults) ){
			$wpdb->query(
				$wpdb->prepare("UPDATE `".WPSQT_TABLE_SURVEY_CACHE."` SET sections=%s,total=total+1 WHERE item_id = %d",
						 array(serialize($cachedSections),$_SESSION['wpsqt'][$quizName]['details']['id']) )
					);
		} else {
			$wpdb->query(
				$wpdb->prepare("INSERT INTO `".WPSQT_TABLE_SURVEY_CACHE."` (sections,item_id,total) VALUES (%s,%d,1)",
								 array(serialize($cachedSections),$_SESSION['wpsqt'][$quizName]['details']['id']) )
					);
		}
		if (!isset($_SESSION['wpsqt']['result_id']) || $_SESSION['wpsqt']['result_id'] == null) {
			$resultId = $_SESSION['wpsqt']['current_result_id'];
		} else {
			$resultId = $_SESSION['wpsqt']['result_id'];
		}
		$wpdb->query(
				$wpdb->prepare("UPDATE `".WPSQT_TABLE_RESULTS."` SET cached=1 WHERE `id` = %d", $resultId)
					);

	}

	/**
	 * Alias to the cache surveys function for polls
	 * so it can be ran from upgrade script.
	 *
	 * @author Ollie Armstrong
	 */
	public function cachePoll() {
		$this->_cacheSurveys();
	}

}
