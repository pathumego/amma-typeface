<?php 

require_once WPSQT_DIR.'lib/Wpsqt/Question/Multiple.php';

	/**
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
	 * @package WPSQT
	 */

class Wpsqt_Question_Dropdown extends Wpsqt_Question_Multiple { 

	public function __construct(){
		
		parent::__construct();
		$this->_displayView = WPSQT_DIR."pages/site/questions/dropdown.php";
	
	}
	
	
}