<?php

	/**
	 * Displays the help page. 
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Help extends Wpsqt_Page {
	
	public function process(){
		$this->_pageView = "admin/misc/help.php";
	}	
	
}	