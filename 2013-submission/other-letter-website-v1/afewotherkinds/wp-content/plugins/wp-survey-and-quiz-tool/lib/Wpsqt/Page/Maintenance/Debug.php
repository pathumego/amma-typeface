<?php

	/**
	 * Handles the complete upgrading of the plugin.
	 * 
	 * 
	 * @author Ollie Armstrong
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Maintenance_Debug extends Wpsqt_Page {
	
		
	public function process(){	
	
		global $wpdb;
		
		if ( $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ManualDb']) ) {
			wpsqt_main_install();
			update_option('wpsqt_manual', '1');
		}
		
		if ( $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ResetSession']) ) {
			$_SESSION['wpsqt'] = array();
			echo '<pre>'; var_dump($_SESSION); echo '</pre>';
		}
		
		
		if ( $_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['AllUpgrades']) ) {
			
			print "<h3>Running all upgrades</h3>".PHP_EOL;
			require_once WPSQT_DIR.'lib/Wpsqt/Upgrade.php';
			$objUpgrade = new Wpsqt_Upgrade;
			$objUpgrade->getUpdate(0);
			$objUpgrade->execute();
			$needUpdate = 1;
			$oldVersion = '2.4.3';
			require_once WPSQT_DIR.'lib/Wpsqt/Page/Maintenance/upgradeScript.php';
			echo '<p>You are up to date.</p>';
			exit;
			
		} 

		
		$this->_pageView = "admin/maintenance/debug.php";
	}
		
}