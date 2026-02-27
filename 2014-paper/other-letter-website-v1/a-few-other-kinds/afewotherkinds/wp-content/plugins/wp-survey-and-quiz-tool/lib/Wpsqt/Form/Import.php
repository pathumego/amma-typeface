<?php

require_once WPSQT_DIR."lib/Wpsqt/Form.php";
	/**
	 * 
	 * @author Iain Cambridge#
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Form_Import extends Wpsqt_Form {
	
	public function __construct( array $options = array() ){
	
		if ( empty($options) ){
			$options = array('type' => false,
							'content' => false);
		}
		
		$this->addOption("wpsqt_type", "Type", "select", $options['type'], "The format the data is to be outputted in.",array("SQL") )
			 ->addOption("wpsqt_content", "Content", "textarea", $options['content'], "The data that is to be imported" );
			 
		apply_filters("wpsqt_form_export",$this);
			
	}
}