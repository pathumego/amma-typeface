<?php
require_once WPSQT_DIR.'lib/Wpsqt/Tokens.php';

	/**
	 * Handles editing the global options for the plugin.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Options extends Wpsqt_Page {
	
	public function process(){
		
		if ( $_SERVER['REQUEST_METHOD'] == "POST" ){
			
			update_option("wpsqt_number_of_items",$_POST['wpsqt_items']);
			update_option("wpsqt_email_role",$_POST['wpsqt_email_role']);
			update_option("wpsqt_required_role", $_POST['wpsqt_required_role']);
			update_option("wpsqt_email_template",$_POST['wpsqt_email_template']);
			update_option("wpsqt_chart_bg", $_POST['wpsqt_chart_bg']);
			update_option("wpsqt_chart_colour", $_POST['wpsqt_chart_colour']);
			update_option("wpsqt_chart_width", $_POST['wpsqt_chart_width']);
			update_option("wpsqt_chart_height", $_POST['wpsqt_chart_height']);
			update_option("wpsqt_chart_text_colour", $_POST['wpsqt_chart_text_colour']);
			update_option("wpsqt_chart_text_size", $_POST['wpsqt_chart_text_size']);
			update_option("wpsqt_chart_abbreviation", $_POST['wpsqt_chart_abbreviation']);
			update_option("wpsqt_support_us",$_POST['wpsqt_support_us']);
			update_option("wpsqt_from_email",$_POST['wpsqt_from_email']);
			update_option("wpsqt_contact_email",$_POST['wpsqt_email']);
			update_option("wpsqt_docraptor_api",$_POST['wpsqt_docraptor_api']);
			update_option("wpsqt_pdf_template",$_POST['wpsqt_pdf_template']);
			
			// Update the capabilities to all the roles that are allowed
			// Remove the cap from all roles
			global $wp_roles;
			foreach($wp_roles->role_names as $role => $name){
				$roleDef = get_role($role);
				$roleDef->remove_cap('wpsqt-manage');
			}
			// Apply the cap only to roles allowed
			switch ($_POST['wpsqt_required_role']) {
				case 'subscriber':
					$role = get_role('subscriber');
					$role->add_cap('wpsqt-manage');
				case 'contributor':
					$role = get_role('contributor');
					$role->add_cap('wpsqt-manage');
				case 'author':
					$role = get_role('author');
					$role->add_cap('wpsqt-manage');
				case 'editor':
					$role = get_role('editor');
					$role->add_cap('wpsqt-manage');
				case 'administrator':
					$role = get_role('administrator');
					$role->add_cap('wpsqt-manage');
			}
		}	
		
		$this->_pageVars['objTokens'] = Wpsqt_Tokens::getTokenObject();
		$this->_pageVars['numberOfItems'] = get_option("wpsqt_number_of_items");
		$this->_pageVars['emailRole'] = get_option("wpsqt_email_role");
		$this->_pageVars['requiredRole'] = get_option("wpsqt_required_role");
		$this->_pageVars['emailTemplate'] = get_option("wpsqt_email_template");
		$this->_pageVars['chartBg'] = get_option("wpsqt_chart_bg");
		$this->_pageVars['chartColour'] = get_option("wpsqt_chart_colour");
		$this->_pageVars['chartWidth'] = get_option("wpsqt_chart_width");
		$this->_pageVars['chartHeight'] = get_option("wpsqt_chart_height");
		$this->_pageVars['chartTextColour'] = get_option("wpsqt_chart_text_colour");
		$this->_pageVars['chartTextSize'] = get_option("wpsqt_chart_text_size");
		$this->_pageVars['chartAbbreviation'] = get_option("wpsqt_chart_abbreviation");
		$this->_pageVars['supportUs'] = get_option("wpsqt_support_us");
		$this->_pageVars['fromEmail'] = get_option("wpsqt_from_email");
		$this->_pageVars['email'] = get_option("wpsqt_contact_email");
		$this->_pageVars['docraptorApi'] = get_option("wpsqt_docraptor_api");
		$this->_pageVars['pdfTemplate'] = get_option("wpsqt_pdf_template");
		
		$this->_pageView = "admin/misc/options.php";
	}
	
}
