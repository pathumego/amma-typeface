<?php
require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Addnew.php';
require_once WPSQT_DIR.'lib/Wpsqt/Form/Survey.php';
require_once WPSQT_DIR.'lib/Wpsqt/Tokens.php';

	/**
	 * Handles adding new surveys to the database.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Addnew_Survey extends Wpsqt_Page_Main_Addnew {
	
	/**
	 * (non-PHPdoc)
	 * @see Wpsqt_Page::process()
	 */
	public function process(){
		
		$this->_subsection = "Survey";
		$this->_pageView = "admin/surveys/create.php";
		$this->_doInsert();
		
	}
	
}