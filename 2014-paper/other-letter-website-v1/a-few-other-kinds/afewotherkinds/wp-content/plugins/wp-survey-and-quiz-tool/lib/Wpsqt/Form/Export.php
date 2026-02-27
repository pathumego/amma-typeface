<?php
require_once WPSQT_DIR.'lib/Wpsqt/Form.php';

	/**
	 * Handles displaying and processing the form
	 * for exporting settings,data,etc.
	 * 
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Form_Export extends Wpsqt_Form {
		
	public function __construct( array $options = array() ){
	
		if ( empty($options) ){
			$options = array('type' => false,
							'data' => false);
		}
		
		$this->addOption("wpsqt_type", "Type", "select", $options['type'], "The format the data is to be outputted in.",array("SQL","CSV") )
			 ->addOption("wpsqt_data", "Data", "select", $options['data'], "The data that is to be exported", array( "Results","Quizzes and Surveys" ) );
			 
		apply_filters("wpsqt_form_export",$this);
			
	}
		
}