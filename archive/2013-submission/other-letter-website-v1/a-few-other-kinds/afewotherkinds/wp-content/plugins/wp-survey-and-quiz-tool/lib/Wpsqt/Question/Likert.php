<?php 

	/**
	 * The class for the likert questions
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
	 * @package WPSQT
	 */

class Wpsqt_Question_Likert extends Wpsqt_Question {

	public function __construct(array $values = array()){
										
		$this->_id = "likert";										
		$this->_formView = WPSQT_DIR."pages/admin/forms/question.likert.php";
		$this->_displayView = WPSQT_DIR."pages/site/questions/likert.php";
	
	}
	
	
}
