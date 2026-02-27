<?php

	/**
	 * Handles the deletion of questions.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Questiondelete extends Wpsqt_Page {
	
	public function process(){
				
		global $wpdb;
		
		if ( $_SERVER['REQUEST_METHOD'] != "POST" ){
			$this->_pageVars['question'] = $wpdb->get_row(
							$wpdb->prepare("SELECT * FROM `".WPSQT_TABLE_QUESTIONS."` WHERE id = %d", 
										   array($_GET['questionid'])),ARRAY_A
								   );
			$this->_pageView = "admin/questions/delete.php";
			return;
		}
		
		$wpdb->query(
			$wpdb->prepare("DELETE FROM `".WPSQT_TABLE_QUESTIONS."` WHERE id = %d", array($_GET['questionid']))
					);
		
		$this->_pageVars['redirectLocation'] = WPSQT_URL_MAIN."&section=questions&subsection=".
													   strtolower($_GET['subsection'])."&id="
													   .$_GET['id']."&delete=true";		
		$this->_pageView = "admin/misc/redirect.php";
		
	}
	
}