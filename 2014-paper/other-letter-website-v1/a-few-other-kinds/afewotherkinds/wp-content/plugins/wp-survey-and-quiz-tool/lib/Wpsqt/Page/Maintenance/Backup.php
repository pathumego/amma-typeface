<?php


	/**
	 * Handles the backup of all of the tables.
	 * 
	 * 
	 * @author Ollie Armstrong
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Maintenance_Backup extends Wpsqt_Page {
	
		
	public function process(){
		if (!is_writable(WPSQT_DIR.'db-backups')) {
			echo '<div class="error">The backup folder <strong>wp-content/plugins/wp-survey-and-quiz-tool/db-backups</strong> is not writable or doesn\'t exist, please create this folder or change it\'s permissions to <strong>777</strong>.</div>';
			$this->_pageVars['dirwriteable'] = false;
		}
		if ( $_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['host'])&& !empty($_POST['user'])&& !empty($_POST['pass'])&& !empty($_POST['database']) ) {
			$tables = array(WPSQT_TABLE_QUIZ_SURVEYS,WPSQT_TABLE_SECTIONS,WPSQT_TABLE_QUESTIONS,WPSQT_TABLE_FORMS,WPSQT_TABLE_RESULTS,WPSQT_TABLE_SURVEY_CACHE);
			require_once('backupfunction.php');
			$sql = backup_tables($_POST['host'],$_POST['user'],$_POST['pass'],$_POST['database'],$tables);			
			file_put_contents(WPSQT_DIR.'db-backups/db-'.date('His-dmy').'.sql', $sql);
			$this->_pageView = "admin/maintenance/backupdone.php";
		} else {
			$this->_pageView = "admin/maintenance/backup.php";
		}
		
	}
		
}