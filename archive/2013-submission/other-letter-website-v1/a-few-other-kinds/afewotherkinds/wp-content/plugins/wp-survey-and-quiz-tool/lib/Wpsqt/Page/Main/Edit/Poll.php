<?php
require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Edit.php';
require_once WPSQT_DIR.'lib/Wpsqt/Form/Poll.php';

	/**
	 * Handles the editing of the polls.
	 * 
	 * @author Ollie Armstrong
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Edit_Poll extends Wpsqt_Page_Main_Edit {
	
	public function process(){
		
		$this->_pageView = "admin/poll/create.php";
		$this->_subsection = "Poll";
		$this->_doUpdate();
		
		return;
	}
	
}