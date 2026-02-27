<?php

	/**
	 * Handles the upgrading of the plugin.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Maintenance_Upgrade extends Wpsqt_Page {

	public function process(){	
	
		global $wpdb;
		
		if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
			
			print "<h3>UPDATING</h3>".PHP_EOL;
			$oldVersion = get_option("wpsqt_old_version");
			$currentVersion = WPSQT_VERSION;
			$needUpdate = get_option("wpsqt_update_required");
			require_once WPSQT_DIR.'lib/Wpsqt/Upgrade.php';
			require_once WPSQT_DIR.'lib/Wpsqt/Page/Maintenance/upgradeScript.php';
			exit;
			
		} 

		$this->_pageView = "admin/maintenance/upgrade.php";
			
	}
}