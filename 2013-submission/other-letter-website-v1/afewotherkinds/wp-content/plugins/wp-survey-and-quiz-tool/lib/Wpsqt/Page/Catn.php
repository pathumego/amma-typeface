<?php

	/**
	 * Shows a page advertising CatN to users of the plugin. 
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Catn extends Wpsqt_Page {
	
	public function process(){
		$this->_pageView = "admin/misc/catn.php";	
		return;
	}	
	
}	 