<?php 

	/**
	 * The class handling displaying the Sub Form and Question
	 * displays for the multiple choice multiple answers.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
	 * @package WPSQT
	 */
class Wpsqt_Question_Multiple extends Wpsqt_Question {

	public function __construct( array $values = array() ){
		
		global $wpdb;
		
		$this->_questionVars['answers'] = array( array( "text" => false, "correct" => false) );									
		$this->_id = "multiple";										
		$this->_formView = WPSQT_DIR."pages/admin/forms/question.multiple.php";
		$this->_displayView = WPSQT_DIR."pages/site/questions/multiple.php";
	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Wpsqt_Question::process()
	 */
	public function processValues( array $input ){
		
		if ( isset($input['wpsqt_answers']) ) {
			$this->_questionVars['answers'] = $input['wpsqt_answers'];
		}
		
	 	return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Wpsqt_Question::processForm()
	 */
	public function processForm($postData){
		
		if ( !isset($_POST['multiple_name']) && !isset($_POST['multiple_correct']) && !isset($_POST['multiple_delete']) ){
		  	false;
		}
		
		
		$output = array('errors' => array(),"content" => array(), "name" => "answers");
		for ( $row = 0; $row < sizeof($_POST["multiple_name"]); $row++ ){
			
			if ( isset($_POST['multiple_delete']) && $_POST['multiple_delete'][$row] == "yes" ){
				continue;
			}
			
			if ( $_POST["multiple_name"][$row] ==  "" ){
				$output['errors'][] = "Question text can't be empty";
				continue;
			}
			
			$default = ( isset($_POST['multiple_default']) && $_POST['multiple_default'] == $row ) ? 'yes' : 'no';	
			$correct = ( isset($_POST["multiple_correct"][$row]) && $_POST["multiple_correct"][$row] != "" ) ? $_POST["multiple_correct"][$row] : 'no';
					
			$output["content"][] = array( "text" => stripslashes($_POST["multiple_name"][$row]) , "correct" => $correct, "default" => $default );
		 			
		}
		
		return $output;
		
	}
}
