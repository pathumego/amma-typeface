<?php 

	/**
	 * The class for the likert matrix questions
	 * 
	 * @author Ollie Armstrong
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
	 * @package WPSQT
	 */

class Wpsqt_Question_Likertmatrix extends Wpsqt_Question {

	public function __construct(array $values = array()){
										
		$this->_id = "likertmatrix";										
		$this->_questionVars['answers'] = array('text' => false);
		$this->_formView = WPSQT_DIR."pages/admin/forms/question.likertmatrix.php";
		$this->_displayView = WPSQT_DIR."pages/site/questions/likertmatrix.php";
	
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
		
		if ( !isset($_POST['likertmatrix_name']) ){
		  	false;
		}
		
		
		$output = array('errors' => array(),"content" => array(), "name" => "answers");
		for ( $row = 0; $row < sizeof($_POST["likertmatrix_name"]); $row++ ){
			
			if ( isset($_POST['likertmatrix_delete']) && $_POST['likertmatrix_delete'][$row] == "yes" ){
				continue;
			}
			
			if ( $_POST["likertmatrix_name"][$row] ==  "" ){
				$output['errors'][] = "Question text can't be empty";
				continue;
			}
					
			$output["content"][] = array( "text" => stripslashes($_POST["likertmatrix_name"][$row]));
		 			
		}
		
		return $output;
		
	}
	
	
}
