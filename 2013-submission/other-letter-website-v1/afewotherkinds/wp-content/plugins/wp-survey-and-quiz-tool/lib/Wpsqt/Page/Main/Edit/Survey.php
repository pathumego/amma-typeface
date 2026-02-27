<?php
require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Edit.php';
require_once WPSQT_DIR.'lib/Wpsqt/Form/Survey.php';
require_once WPSQT_DIR.'lib/Wpsqt/Tokens.php';
	
	/**
	 * Handles the editing of the surveys.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, All rights reserved. 
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Edit_Survey extends Wpsqt_Page_Main_Edit {
	
	public function process(){
		
		$this->_pageView = "admin/surveys/create.php";
		$this->_subsection = "Survey";
		$this->_doUpdate();
		
		return;
	}	
	
}