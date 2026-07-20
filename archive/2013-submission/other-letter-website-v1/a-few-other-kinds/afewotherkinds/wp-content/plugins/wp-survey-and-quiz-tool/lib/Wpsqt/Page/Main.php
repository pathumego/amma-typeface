<?php
	
	/**
	 * Displays the list of the quizzes and surveys
	 * if the list is empty it advises the user to
	 * create one or the other.
	 * 
	 * @author Iain Cambridge
	 * @copyright All rights reserved, Fubra Limited 2010-2011 (C)
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main extends Wpsqt_Page {
	
	/**
	 * (non-PHPdoc)
	 * @see Wpsqt_Page::process()
	 */
	public function process(){
	
		$itemsPerPage = get_option("wpsqt_number_of_items");	
		$quizResults = Wpsqt_System::getAllItemDetails('quiz');
		$surveyResults = Wpsqt_System::getAllItemDetails('survey');
		$pollResults = Wpsqt_System::getAllItemDetails('poll');
			
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$currentPage = isset($_GET['pageno'] )? $_GET['pageno'] : 1;
		$startNumber = ( ($currentPage - 1) * $itemsPerPage );	
		$quizNo   = sizeof($quizResults);
		$surveyNo = sizeof($surveyResults);
		$pollNo	  = sizeof($pollResults);
		$totalNo  = $quizNo + $surveyNo + $pollNo;
		
		switch ($type){		
			case 'quiz':
				$results = $quizResults;
				break;
			case 'survey':
				$results = $surveyResults;
				break;
			case 'poll':
				$results = $pollResults;
				break;
			default:
				$results = array_merge($quizResults,$surveyResults,$pollResults);
				break;	
		}
		
		$results = array_slice($results , $startNumber , $itemsPerPage );
		foreach( $results as &$result ){
			//$result = 
		}
		$numberOfPages = Wpsqt_Core::getPaginationCount($totalNo, $itemsPerPage);
		
		$this->_pageVars = array( 'results' =>$results,
								  'numberOfPages' => $numberOfPages,
								  'startNumber' => $startNumber,
								  'currentPage' => $currentPage,
								  'quizNo' => $quizNo,
								  'surveyNo' => $surveyNo,
								  'pollNo' => $pollNo,
								  'totalNo' => $totalNo,
								  'type' => $type );
		
		if ( empty($results) && $type == 'all' ){		
			$this->_pageView = 'admin/main/empty.php';
		} else {	
			$this->_pageView = 'admin/main/list.php';
		}
		
	}
	
}