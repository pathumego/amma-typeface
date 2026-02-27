<?php
	/**
	 * Handles the management of quiz and survey sections.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

abstract class Wpsqt_Page_Main_Sections extends Wpsqt_Page {
	
	/**
	 * Handles the sections for 
	 * both quizzes and surveys.
	 * 
	 * @since 2.0
	 */
	public function _doSections(){

		if ( $_SERVER['REQUEST_METHOD'] == "POST" ){
			$nameNeeded = array();
			for ($row = 0; $row < intval($_POST['row_count']); $row++ ){
				if ( !isset($_POST['section_name'][$row]) 
				  || $_POST['section_name'][$row] == "" ){
					$nameNeeded[] = $row;
					continue;
				}
				$sectionName = wp_kses_stripslashes($_POST['section_name'][$row]);
				
				if ( !isset($_POST['number'][$row]) 
				  || $_POST['number'][$row] == "" ){
					$_POST['number'][$row] = 0;			
				}
				
				if ( !isset($_POST['sectionid'][$row]) 
				   || empty($_POST['sectionid'][$row]) ){
					$difficulty = ( isset($_POST['difficulty'][$row]) ) ? $_POST['difficulty'][$row] : false;
					Wpsqt_System::insertSection( $_GET['id'] , $sectionName, 
												 $_POST['number'][$row], $_POST['order'][$row],
												 $difficulty);
					continue;
				}
				
				if (  isset($_POST['delete'][$row]) 
				  && !empty($_POST['delete'][$row]) ){
					Wpsqt_System::deleteSection($_POST['sectionid'][$row]);
				} else {
					$difficulty = ( isset($_POST['difficulty'][$row]) ) ? $_POST['difficulty'][$row] : false;
					Wpsqt_System::updateSection($_POST['sectionid'][$row], $sectionName, 
												$_POST['number'][$row], $_POST['order'][$row],
												$difficulty);
				}				
			}
			$this->_pageVars['successMessage'] = "Sections updated";		
		} 		
		
		$validData = Wpsqt_System::fetchSections($_GET['id']);
		if ( !empty($validData) ){
			$this->_pageVars['validData'] = $validData;
		}
		
	}
	
}
