<?php
	/**
	 * Handles doing the inserting 
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */ 

abstract class Wpsqt_Page_Main_Addnew extends Wpsqt_Page {
	
	/**
	 * Handles doing quiz and survey insertions into 
	 * the database. Starts of creating the form object
	 * using either Wpsqt_Form_Quiz or Wpsqt_Form_Survey
	 * then it moves on to check and see if 
	 * 
	 * 
	 * @since 2.0
	 */
	
	protected function _doInsert(){
		
		$className = "Wpsqt_Form_".ucfirst($this->_subsection);
		$objForm = new $className();
		$this->_pageVars = array('objForm' => $objForm,'objTokens' => Wpsqt_Tokens::getTokenObject() );
		
		if ( $_SERVER['REQUEST_METHOD'] == "POST" ){
			
			$errorMessages = $objForm->getMessages($_POST);
			
			$details = $_POST;
			unset($details['wpsqt_nonce']);
			
			if ( empty($errorMessages) ){
				
				$details = Wpsqt_Form::getSavableArray($details);
				
				$this->_pageVars['id'] = Wpsqt_System::insertItemDetails($details, strtolower($this->_subsection));
				do_action('wpsqt_'.strtolower($this->_subsection).'_addnew');
				$this->_pageView ="admin/misc/redirect.php";	
				
				$this->_pageVars['redirectLocation'] = WPSQT_URL_MAIN."&section=sections&subsection=".
													   strtolower($this->_subsection)."&id=".$this->_pageVars['id'].
													   "&new=1";
			} else {
				$objForm->setValues($details);
				$this->_pageVars['errorArray'] = $errorMessages;
			}
			
		}
		
	}
	
	
}