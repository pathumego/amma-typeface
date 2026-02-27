<?php

	/**
	 * Handles the complete uninstalling of the plugin.
	 * 
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Maintenance_Uninstall extends Wpsqt_Page {
	
		
	public function process(){	
	
		global $wpdb;
		
		// If it's a post call then they have confirmed
		// they wish to uninstall so we shall promptly
		// remove all variables and MySQL tables.
		if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {			
			
			// Start of deleting the options.
			delete_option("wpsqt_contact_email");
			delete_option("wpsqt_email_from");
			delete_option("wpsqt_email_role");
			delete_option("wpsqt_email_template");
			delete_option("wpsqt_from_email");
			delete_option("wpsqt_number_of_items");
			delete_option("wpsqt_old_version");
			delete_option("wpsqt_support_us");
			delete_option("wpsqt_update_needed");
			delete_option("wpsqt_verison");
			
			$rawTables = $wpdb->get_results("SHOW TABLES LIKE  '".$wpdb->get_blog_prefix()."wpsqt_%'",ARRAY_N);
			$tables = array();
			foreach ($rawTables as $table ) {
				$tables[] = $table[0];				
			}
			
			$wpdb->query("DROP TABLE ".implode(",",$tables));	
			$this->_pageVars['message'] = "Plugin uninstalled";
		
		}
		
		$this->_pageView = "admin/maintenance/uninstall.php";
	}
		
}