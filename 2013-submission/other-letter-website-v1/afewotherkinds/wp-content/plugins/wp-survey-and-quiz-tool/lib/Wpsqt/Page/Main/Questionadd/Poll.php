<?php
require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Questionadd.php';
	/**
	 * Handles the adding of the questions.
	 * 
	 * @author Ollie Armstrong
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Questionadd_Poll extends Wpsqt_Page_Main_Questionadd {
		
	public function init(){
		$this->_questionTypes = array('Single' => 'Multiple choice question with a single correct answer.');
		$this->_type = "poll";
	}
	
}