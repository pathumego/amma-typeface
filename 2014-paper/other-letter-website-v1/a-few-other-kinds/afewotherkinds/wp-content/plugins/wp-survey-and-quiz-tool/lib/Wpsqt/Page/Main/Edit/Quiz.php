<?php
require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Edit.php';
require_once WPSQT_DIR.'lib/Wpsqt/Form/Quiz.php';

	/**
	 * Handles the editing of the quizzes.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Edit_Quiz extends Wpsqt_Page_Main_Edit {
	
	public function process(){
		
		$this->_pageView = "admin/quiz/create.php";
		$this->_subsection = "Quiz";
		$this->_doUpdate();
		
		return;
	}
	
}