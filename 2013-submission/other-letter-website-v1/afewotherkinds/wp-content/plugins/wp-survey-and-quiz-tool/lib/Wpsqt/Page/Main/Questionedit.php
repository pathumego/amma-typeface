<?php
require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Questionadd.php';
	/**
	 * Handles editing the question.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Questionedit extends Wpsqt_Page_Main_Questionadd {
	
	public function init(){
		
		global $wpdb;
		
		$rawQuestion = $wpdb->get_row(
							$wpdb->prepare("SELECT * FROM `".WPSQT_TABLE_QUESTIONS."` WHERE id = %d",
										   array($_GET['questionid'])),ARRAY_A
							);
		$prepdQuestion = array();
		foreach( Wpsqt_System::unserializeQuestion($rawQuestion, $_GET['subsection']) as $key => $value ){
			$prepdQuestion["wpsqt_".$key] = $value;
		}
		
		$this->_action = "edit";
		$this->_question = $prepdQuestion;					
		
	}
	
}