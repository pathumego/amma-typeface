<?php
require_once WPSQT_DIR.'lib/Wpsqt/Page.php';
	/**
	 * Deletes quiz and surveys.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Delete extends Wpsqt_Page {
		
	public function process(){

		global $wpdb;
		
		if ( $_SERVER['REQUEST_METHOD'] != "POST" ){
			
			$this->_pageVars['quizName'] = $wpdb->get_var( 
												$wpdb->prepare("SELECT name FROM `".WPSQT_TABLE_QUIZ_SURVEYS."` WHERE id = %d", 
																array($_GET['id']))
														);
			$this->_pageView = "admin/quiz/delete.php";
			return;
		}
		
		$wpdb->query(
				$wpdb->prepare("DELETE FROM `".WPSQT_TABLE_QUIZ_SURVEYS."` WHERE id = %d", array($_GET['id']))
					);
		$wpdb->query(
				$wpdb->prepare("DELETE FROM `".WPSQT_TABLE_FORMS."` WHERE item_id = %d", array($_GET['id']))
					);
		$wpdb->query(
				$wpdb->prepare("DELETE FROM `".WPSQT_TABLE_QUESTIONS."` WHERE item_id = %d", array($_GET['id']))				
					);
		$wpdb->query(
				$wpdb->prepare("DELETE FROM `".WPSQT_TABLE_SECTIONS."` WHERE item_id = %d", array($_GET['id']))
					);
		
		$this->_pageVars['redirectLocation'] = WPSQT_URL_MAIN."&delete=true";	
		$this->_pageView = "admin/misc/redirect.php";	
		
	}
	
}