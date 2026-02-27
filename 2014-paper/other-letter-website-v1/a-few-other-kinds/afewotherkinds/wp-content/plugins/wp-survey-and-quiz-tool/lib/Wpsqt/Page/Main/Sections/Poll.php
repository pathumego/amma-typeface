<?php
require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Sections.php';

	/**
	 * Handles poll sections management.
	 * 
	 * @author Ollie Armstrong
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Sections_Poll extends Wpsqt_Page_Main_Sections {

	/**
	 * (non-PHPdoc)
	 * @see Wpsqt_Page::process()
	 */
	public function process(){
		
		$this->_pageView = "admin/poll/sections.php";		
		$this->_doSections();
				
	}
	
}