<?php

	/**
	 * Handles complete uninstalling of the plugin. Also handles 
	 * upgrades and imports/exports.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Maintenance extends Wpsqt_Page {

	public function process(){
		$page = wp_remote_get('http://wordpress.org/extend/plugins/wp-survey-and-quiz-tool/');
		if (!is_wp_error($page)) {
			preg_match_all('$download\sversion\s((\d|\.)*)$i', $page['body'], $version);
			$this->_pageVars['version'] = $version[1][0];
		} else {
			$this->_pageVars['version'] = "Unable to get version number";
		}

		if(get_option('wpsqt_update_required') == '1') {
			$update = true;
			$this->_pageVars['update'] = true;
		}
		$this->_pageView = "admin/maintenance/index.php";
			
	}

}
