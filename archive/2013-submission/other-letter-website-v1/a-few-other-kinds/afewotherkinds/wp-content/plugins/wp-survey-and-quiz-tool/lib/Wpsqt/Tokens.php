<?php

	/**
	 * Holds and manages all the token replacements.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, All rights reserved.
	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
	 * @package WP Survey And Quiz Tool
	 */

class Wpsqt_Tokens {

	/**
	 * Holds a copy of the tokens object for use with the singleton method.
	 * @var Wpsqt_Tokens
	 * @since 2.0
	 */
	
	protected static $instance;
	
	/**
	 * Singleton method to provide a token object 
	 * with the default tokens and descriptions.
	 * 
	 * @since 2.0
	 */
	public static function getTokenObject(){

		if ( !is_a(self::$instance,"Wpsqt_Tokens") ){
			
			self::$instance = new Wpsqt_Tokens();
			self::$instance->addToken("USER_NAME", "The name of the user who has taken the quiz or survey.")
					  	   ->addToken("QUIZ_NAME", "The name of the quiz that has been taken, <strong>same as %SURVEY_NAME%</strong>.")
					  	   ->addToken("SURVEY_NAME", "The name of the survey that has been taken, <strong>same as %QUIZ_NAME%</strong>.")
					  	   ->addToken("DATE_EU", "The date the quiz or survey was taken in EU format.")
					  	   ->addToken("DATE_US", "The date the quiz or survey was taken in US format.")
						   ->addToken("SCORE", "Score gained in quiz, only works if automarking is enabled.")
						   ->addToken("SCORE_PERCENTAGE", "Score gained in quiz, in a percentage.")
						   ->addToken("SCORE_PASSFAIL","Shows either 'Pass' or 'Fail' depending on score.")
						   ->addToken("SCORE_COMPETENT","Shows either 'Competent' or 'Not yet competent' depending on pass or fail.")
						   ->addToken("RESULT_URL", "A link to mark the results in the dashboard.")
						   ->addToken("RESULT_VIEW_URL", "A link to view the results in the dashboard.")
						   ->addToken("DATETIME_EU", "The date and time the quiz or survey was taken in EU format.")
						   ->addToken("DATETIME_US", "The date and time the quiz or survey was taken in US format.")
						   ->addToken("IP_ADDRESS", "The IP address of the user who has taken the quiz or survey.")
						   ->addToken("HOSTNAME", "The hostname of the IP address of the user who has taken the quiz or survey.")
						   ->addToken("USER_AGENT", "The user agent of the user who has taken the quiz or survey.")
						   ->addToken("USER_EMAIL", "The email address of the user who has taken the quiz or survey.")
						   ->addToken("USER_FNAME", "The first name of the user")
						   ->addToken("USER_LNAME", "The last name of the user")
						   ->addToken("TB_B", "Toggle block of information after this tag") 
						   ->addToken("TB_E", "End of block of information to be toggled"); 
			
		}
		
		return apply_filters( "wpsqt_replacement_tokens" , self::$instance );
	}
	
	/**
	 * the tokens that are to be used for replacement.
	 * @var array
	 */	
	protected $_tokens = array();
	
	/**
	 * Adds a token to the tokens array. 
	 *
	 * @param string $token
	 * @param string $description
	 * @param string|boolean $value
	 */
	public function addToken ( $token, $description, $value = false ){
		
		$this->_tokens[$token] = array("description" => $description, "value" => $value);
		
		return $this;
	
	}
	
	/**
	 * Finish Display	
	 * Sets the token value
	 * 
	 * @param string $token
	 * @param string $value
	 */
	public function setTokenValue( $token, $value ){
		
		if ( array_key_exists($token, $this->_tokens) ){
			$this->_tokens[$token]["value"] = $value;
		}
		
		return $this;
	}
	
	/**
	 * Allows you to set multiple token values in one call.
	 * 
	 * @param array $tokens
	 * @return Wpsqt_Tokens
	 * @since 2.0
	 */
	public function setTokensValue( array $tokens ){
		
		foreach ($tokens as $token => $value ){
			$this->setTokenValue($token, $value);
		}
		
		
		return $this;
	}
	
	public function setDefaultValues(){
		
		$quizName = $_SESSION['wpsqt']['current_id'];
		
		foreach ( array("QUIZ_NAME","SURVEY_NAME") as $token ) {
			$this->setTokenValue($token,$_SESSION['wpsqt'][$quizName]['details']['name']);
		}

		if ($_SESSION['wpsqt']['current_type'] == 'quiz' && isset($_SESSION['wpsqt']['current_score'])) {
			// Calculate percentage
			preg_match('$(\d*)\scorrect\sout\sof\s(\d*)$', $_SESSION['wpsqt']['current_score'], $score);
			if (isset($score) && is_array($score) && isset($score[2]) && $score[2] != 0) {
				$percentage = $score[1] / $score[2] * 100;
				$percentage = number_format($percentage, 1) . '%';
			} else {
				$percentage = '?%';
			}
		} else {
			$percentage = '?%';
		}
		
		$this->setTokenValue('DATE_EU'     , date('d-m-Y') );
		$this->setTokenValue('DATE_US'     , date('m-d-Y') );
		$this->setTokenValue('DATETIME_EU' , date('d-m-Y H:i:s') );
		$this->setTokenValue('DATETIME_US' , date('m-d-Y H:i:s') );
		$this->setTokenValue('IP_ADDRESS'  , $_SERVER['REMOTE_ADDR'] );
		$this->setTokenValue('HOSTNAME'    , gethostbyaddr($_SERVER['REMOTE_ADDR']) );
		$this->setTokenValue('USER_AGENT'  , $_SERVER['HTTP_USER_AGENT'] );		
		$this->setTokenValue('SCORE'       , ( isset($_SESSION['wpsqt']['current_score']) ) ? $_SESSION['wpsqt']['current_score'] : '');
		$this->setTokenValue('SCORE_PERCENTAGE' , ( isset($percentage) ) ? $percentage : '');
		$this->setTokenValue('SCORE_PASSFAIL', (isset($_SESSION['wpsqt'][$quizName]['details']['pass_mark']) && $_SESSION['wpsqt'][$quizName]['details']['pass_mark'] > (int)rtrim($percentage, "%")) ? 'Fail' : 'Pass');
		$this->setTokenValue('SCORE_COMPETENT', (isset($_SESSION['wpsqt'][$quizName]['details']['pass_mark']) && $_SESSION['wpsqt'][$quizName]['details']['pass_mark'] > (int)rtrim($percentage, "%")) ? 'Not yet competent' : 'Competent');

		if (isset($_SESSION['wpsqt']['result_id'])) {
			$this->setTokenValue('RESULT_URL'  , WPSQT_URL_MAIN."&section=results&subsection=mark&id=".$_SESSION['wpsqt']['item_id']."&resultid=".$_SESSION['wpsqt']['result_id'] );
			$this->setTokenValue('RESULT_VIEW_URL'  , WPSQT_URL_MAIN."&section=results&subsection=view&id=".$_SESSION['wpsqt']['item_id']."&resultid=".$_SESSION['wpsqt']['result_id'] );
		}

		$this->setTokenValue('USER_EMAIL'  , ( isset($_SESSION['wpsqt'][$quizName]['person']['email']) ) ? $_SESSION['wpsqt'][$quizName]['person']['email'] : '');
		$this->setTokenValue('USER_NAME'   , ( isset($_SESSION['wpsqt'][$quizName]['person']['name']) ) ? $_SESSION['wpsqt'][$quizName]['person']['name'] : 'Anonymous User');
		$this->setTokenValue('USER_FNAME'   , ( isset($_SESSION['wpsqt'][$quizName]['person']['fname']) ) ? $_SESSION['wpsqt'][$quizName]['person']['fname'] : 'Anonymous');
		$this->setTokenValue('USER_LNAME'   , ( isset($_SESSION['wpsqt'][$quizName]['person']['lname']) ) ? $_SESSION['wpsqt'][$quizName]['person']['lname'] : 'User');
		// Toggle a block of information
		$this->setTokenValue('TB_B'   , '<div class="wpsqt-toggle"><div class="wpsqt-show-toggle"> <a href="#">[ '.__('More', 'wp-survey-and-quiz-tool').' >> ]</a></div><div class="wpsqt-toggle-block" style="display:none;">');
		$this->setTokenValue('TB_E'   , '</div><div class="wpsqt-hide-toggle" style="display:none;"><a href="#">[ << '.__('Less', 'wp-survey-and-quiz-tool').']</a></div></div>' );
		
		apply_filters("wpsqt_set_token_values", $this);
		
	}
	
	/**
	 * Does the replacements and returns the results.
	 * 
	 * @param string $string
	 */
	public function doReplacement($string){
						
		foreach( $this->_tokens as $token => $data ){
			$string = str_ireplace("%".$token."%", $data['value'], $string);	
		}
		
		return $string;
	}
	
	
	/**
	 * Returns the html list explaining what each
	 * token is for.
	 * 
	 * @return string
	 * @since 2.0
	 */
	public function getDescriptions(){
		$html = "<ul>";
		foreach( $this->_tokens as $token => $data ){
			$html .= "<li><strong>%".strtoupper($token)."%</strong> - ".$data['description']."</li>";
		}
		$html .= "</ul>";
		
		return $html;
	}
	
}
