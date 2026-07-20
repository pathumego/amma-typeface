<?php
require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Questionadd.php';
	/**
	 * Handles the adding of the questions.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Questionadd_Quiz extends Wpsqt_Page_Main_Questionadd {
		
	public function init(){
		$this->_questionTypes = array('Multiple' => 'Multiple choice question with mulitple correct answers.', 
							   'Single' => 'Multiple choice question with a signle correct answer.',
							   'Free Text' => 'Question where the user types in the answer into a textarea.' );
	}
	
}