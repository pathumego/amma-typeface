<?php

	/**
	 * The page class to handle custom forms
	 *
	 * @author Iain Cambirdge
	 * @copyright Fubra Limited 2010-2011 (c)
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */
class Wpsqt_Page_Main_Form extends Wpsqt_Page {
	
	public function process(){
		
		global $wpdb;
		
		if ( $_SERVER['REQUEST_METHOD'] == "POST" ){
			
			for ( $row = 0; $row < intval($_POST['row_count']); $row++ ){
				
				if ( empty($_POST['formitemid'][$row]) ){
					Wpsqt_System::insertFormItem($_GET['id'], $_POST['field_name'][$row], $_POST['type'][$row], 
												 $_POST['required'][$row], $_POST['validation'][$row]);
					continue;
				}
				
				if ( isset($_POST['delete'][$row]) && $_POST['delete'][$row] == "yes" ){
					Wpsqt_System::deleteFormItem($_POST['formitemid'][$row]);
				} else {
					Wpsqt_System::updateFormItem($_POST['formitemid'][$row], $_POST['field_name'][$row], 
												 $_POST['type'][$row], $_POST['required'][$row], 
												 $_POST['validation'][$row]);
				}
			}
			$this->_pageVars['updated'] = "Form has successfully been updated";
			
		}
				
		$fields = $wpdb->get_results(
					$wpdb->prepare("SELECT * FROM `".WPSQT_TABLE_FORMS."` WHERE item_id = %s", array($_GET['id']) ), ARRAY_A
				  );
		
		if ( empty($fields) ){
			$fields[] =  array( "id" => false, "name" => false, "required" => false, "validation" => false, 'type' => false ) ;
		}
		
		$this->_pageView = 'admin/shared/form.php';
		$this->_pageVars['fields'] = $fields;
		$this->_pageVars['validators'] = Wpsqt_System::fetchValidators();
	}
	
}