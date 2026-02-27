<?php
require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Addnew.php';
require_once WPSQT_DIR.'lib/Wpsqt/Form/Poll.php';
require_once WPSQT_DIR.'lib/Wpsqt/Tokens.php';

	/**
	 * Handles adding new polls to the database.
	 * 
<<<<<<< HEAD
	 * @author Iain Cambridge
=======
	 * @author Ollie Armstrong
>>>>>>> b891531d5298cffecc4ce5666ca6def2cdde8959
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Addnew_Poll extends Wpsqt_Page_Main_Addnew {
	
	/**
	 * (non-PHPdoc)
	 * @see Wpsqt_Page::process()
	 */
	public function process(){
		
		$this->_subsection = "Poll";
		$this->_pageView = "admin/poll/create.php";
		$this->_doInsert();
		
	}
	
}