<?php
require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Addnew.php';
require_once WPSQT_DIR.'lib/Wpsqt/Form/Quiz.php';
require_once WPSQT_DIR.'lib/Wpsqt/Tokens.php';

	/**
	 * Handles the creation of new quizzes.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited. All rights reserved 2010-2011 (C)
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Addnew_Quiz extends Wpsqt_Page_Main_Addnew {
	
	/**
	 * (non-PHPdoc)
	 * @see Wpsqt_Page::process()
	 */
	public function process(){
		
		$this->_subsection = "Quiz";
		$this->_pageView = "admin/quiz/create.php";
		$this->_doInsert();
		
	}
	
}