<?php
require_once WPSQT_DIR.'lib/Wpsqt/Form/Question.php';
require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Questionadd.php';
require_once WPSQT_DIR.'lib/Wpsqt/Question.php';
	/**
	 * Handles the adding of the questions to the survey
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Questionadd_Survey extends Wpsqt_Page_Main_Questionadd {
	
	 public function init(){
		$this->_type = "survey";
	}

}