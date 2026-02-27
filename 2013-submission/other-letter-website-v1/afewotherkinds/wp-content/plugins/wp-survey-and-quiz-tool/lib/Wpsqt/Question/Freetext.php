<?php

	/**
	 * Handles displaying the the form and quiz/survey display 
	 * of the free text question type.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
	 * @package WPSQT
	 */

class Wpsqt_Question_Freetext extends Wpsqt_Question {

	public function __construct( array $value = array() ){
		
		$this->_questionVars = $value;
		$this->_id = "freetext";
		$this->_formView = WPSQT_DIR."pages/admin/forms/question.freetext.php";
		$this->_displayView = WPSQT_DIR."pages/site/questions/textarea.php";
		
	}
	
	public function processValues( array $input ){
		
		if ( isset($input['wpsqt_hint']) ) {
			$this->_questionVars['hint'] = $input['wpsqt_hint'];
		}
		
	 	return $this;
	}
		
	
}