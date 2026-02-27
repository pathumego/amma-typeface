<?php
require_once WPSQT_DIR.'lib/Wpsqt/Upgrade/Interface.php';

	/**
	 * The factory class that will return the upgrade object.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Upgrade {
	
	/**
	 * The queries that are to be run throughout 
	 * the update.
	 * 
	 * @var array
	 */
	protected $queries = array();
	
	/**
	 * The objects to be run when the upgrade is happening.
	 * 
	 * @var array
	 */
	protected $objects = array();
	
	/**
	 * The factory method that returns the upgrade object with all 
	 * the queries and objects ready to roll. 
	 *
	 * @param string $verison
	 */
	public static function getUpdate( $version ){
		global $wpdb;
		$objUpgrade = new Wpsqt_Upgrade();
		
		$oldQuizTable = $wpdb->get_blog_prefix().'wpsqt_quiz';
		$oldQuizSectionTable = $wpdb->get_blog_prefix().'wpsqt_quiz_sections';
		$oldFormsTable = $wpdb->get_blog_prefix().'wpsqt_forms';
		$oldQuizQuestionTable = $wpdb->get_blog_prefix().'wpsqt_questions';
		$oldQuizAnswersTable = $wpdb->get_blog_prefix().'wpsqt_answer';
		$oldQuizResultsTable = $wpdb->get_blog_prefix().'wpsqt_results';
		$oldSurveyTable = $wpdb->get_blog_prefix().'wpsqt_survey';
		$oldSurveyQuestionsTable = $wpdb->get_blog_prefix().'wpsqt_questions';
		$oldSurveyAnswersTable = $wpdb->get_blog_prefix().'wpsqt_questions_answers';
		$oldSurveyResultsTable = $wpdb->get_blog_prefix().'wpsqt_survey_results';
		$oldSurveySingleResultsTable = $wpdb->get_blog_prefix().'wpsqt_survey_single_results';
		$oldSurveySectionsTable = $wpdb->get_blog_prefix().'wpsqt_survey_sections';		
		
		
		if ( version_compare($version, "1.3") < 0 ){
			$objUpgrade->addQuery("ALTER TABLE `".$oldQuizTable."` ADD `use_wp_user` VARCHAR( 3 ) NOT NULL DEFAULT 'no'");
			$objUpgrade->addQuery("ALTER TABLE `".$oldQuizSectionTable."` ADD `orderby` VARCHAR( 255 ) NOT NULL DEFAULT 'random'");
			$objUpgrade->addQuery("ALTER TABLE `".$oldSurveySectionsTable."` ADD `orderby` VARCHAR( 255 ) NOT NULL DEFAULT 'random'");
			$objUpgrade->addQuery("ALTER TABLE `".$oldQuizTable."` DROP `type` ");
			// 1.3	
			$objUpgrade->addQuery("ALTER TABLE `".$oldSurveyTable."` ADD `send_email` VARCHAR( 3 ) NOT NULL DEFAULT 'no'");
			$objUpgrade->addQuery("ALTER TABLE `".$oldQuizTable."` ADD `email_template` TEXT NULL DEFAULT NULL");
			$objUpgrade->addQuery("ALTER TABLE `".$oldSurveyTable."` ADD `email_template` TEXT NULL DEFAULT NULL");
		}
		
		if ( version_compare($version, "1.3.1") < 0 ){
			// 1.3.1
			$objUpgrade->addQuery("ALTER TABLE `".$oldSurveyQuestionsTable."` ADD `include_other` VARCHAR( 3 ) NOT NULL DEFAULT 'no'");
		}
		
		if ( version_compare($version, "1.3.2") < 0 ){
			// 1.3.2
			$objUpgrade->addQuery("ALTER TABLE `".$oldQuizTable."` ADD `display_review` VARCHAR( 3 ) NOT NULL DEFAULT 'no'");
		}
		
		if ( version_compare($version, "1.3.16") < 0 ){
			// 1.3.16
			$objUpgrade->addQuery("CREATE TABLE IF NOT EXISTS `".$oldSurveySingleResultsTable."` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `surveyid` int(11) NOT NULL,
						  `person` text NOT NULL,
						  `name` varchar(255) NOT NULL,
						  `results` text NOT NULL,
						  `ipaddress` varchar(255) NOT NULL,
						  `user_agent` varchar(255) NOT NULL,
						  PRIMARY KEY (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=latin1;");
		}
		
		if ( version_compare($version, "1.3.21") < 0 ){
			// 1.3.21
			
			foreach (array( $oldQuizTable,$oldQuizSectionTable,$oldQuizQuestionTable,
							$oldQuizAnswersTable,$oldFormsTable,$oldQuizResultsTable,
							$oldSurveyTable,$oldSurveySectionsTable,
							$oldSurveyQuestionsTable,$oldSurveyAnswersTable,
							$oldSurveyResultsTable,$oldSurveySingleResultsTable ) as $tableName){				
				$wpdb->query("ALTER TABLE  `".$tableName."` CHARACTER SET utf8 COLLATE utf8_general_ci");
			}
			
			$objUpgrade->addQuery("ALTER TABLE  `".$oldQuizQuestionTable."` 
						  CHANGE  `hint`  `hint` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `difficulty`  `difficulty` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `type`  `type` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `text`  `text` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `section_type`  `section_type` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'multiple'");
			$objUpgrade->addQuery("ALTER TABLE  `".$oldQuizAnswersTable."` 
						  CHANGE  `text`  `text` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `correct`  `correct` VARCHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
			$objUpgrade->addQuery("ALTER TABLE  `".$oldFormsTable."` 
						  CHANGE  `name`  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `type`  `type` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `required`  `required` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");	
			$objUpgrade->addQuery("ALTER TABLE  `".$oldQuizTable."` CHANGE  `name`  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `display_result`  `display_result` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'no',
						  CHANGE  `status`  `status` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'disabled',
						  CHANGE  `notification_type`  `notification_type` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'none',
						  CHANGE  `take_details`  `take_details` VARCHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'no',
						  CHANGE  `use_wp_user`  `use_wp_user` VARCHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'no',
						  CHANGE  `email_template`  `email_template` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
						  CHANGE  `display_review`  `display_review` VARCHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'no'");
			$objUpgrade->addQuery("ALTER TABLE  `".$oldQuizSectionTable."` 
						  CHANGE  `name`  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `type`  `type` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `difficulty`  `difficulty` VARCHAR( 11 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `orderby`  `orderby` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'random'");
			$objUpgrade->addQuery("ALTER TABLE  `".$oldQuizResultsTable."` 
						  CHANGE  `person`  `person` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
						  CHANGE  `sections`  `sections` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `status`  `status` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'Unviewed',
						  CHANGE  `person_name`  `person_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `ipaddress`  `ipaddress` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
			$objUpgrade->addQuery("ALTER TABLE  `".$oldSurveyTable."` 
						  CHANGE  `name`  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `take_details`  `take_details` VARCHAR( 11 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `status`  `status` VARCHAR( 11 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `send_email`  `send_email` VARCHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'no',
						  CHANGE  `email_template`  `email_template` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL");
			$objUpgrade->addQuery("ALTER TABLE  `".$oldSurveyQuestionsTable."` CHANGE  `text`  `text` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `type`  `type` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `include_other`  `include_other` VARCHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'no'");
			$objUpgrade->addQuery("ALTER TABLE  `".$oldSurveyAnswersTable."` 
						  CHANGE  `text`  `text` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
			$objUpgrade->addQuery("ALTER TABLE  `".$oldSurveyResultsTable."` 
						  CHANGE  `other`  `other` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `type`  `type` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT  'multiple'");
			$objUpgrade->addQuery("ALTER TABLE  `".$oldSurveySectionsTable."` 
								   CHANGE  `name`  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
								   CHANGE  `type`  `type` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
								   CHANGE  `orderby`  `orderby` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
			$objUpgrade->addQuery("ALTER TABLE  `".$oldSurveySingleResultsTable."` 
						  CHANGE  `person`  `person` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `name`  `name` VARCHAR( 255 ) CHARACTER SET ucs2 COLLATE ucs2_general_ci NOT NULL ,
						  CHANGE  `results`  `results` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `ipaddress`  `ipaddress` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
						  CHANGE  `user_agent`  `user_agent` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
		}
		
		if ( version_compare($version, "1.3.22") < 0 ){
			// 1.3.22
			$wpdb->query("ALTER TABLE `".$oldQuizResultsTable."` CHANGE `sections` `sections` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
		}
		
		if ( version_compare($version, "1.3.23") < 0 ){
			// 1.3.23
			$wpdb->query("ALTER TABLE `".$oldQuizTable."` ADD `email_wp_user` VARCHAR( 3 ) NOT NULL DEFAULT 'no'");
		}
	
		if ( version_compare($version, "1.3.24") < 0 ){
			$wpdb->query("ALTER TABLE `".$oldQuizTable."` CHANGE  `additional` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");		  
		}
		
		if ( version_compare($version, "1.3.27") < 0 ){
			$wpdb->query("ALTER TABLE  `".$oldQuizTable."` ADD  `limit_one` VARCHAR( 255 ) NULL DEFAULT NULL");		
		}
				
		if ( version_compare($version, '2.0.0') < 0 ){
			$objUpdate = Wpsqt_Core::getObject( 'Wpsqt_Upgrade_1322' );
			$objUpgrade->addObject( $objUpdate , 'Upgraded to 2.0' );
		}
		
		if ( version_compare($version, '2.0.0.3') < 0 ){
			$objUpgrade->addQuery("ALTER TABLE  `".WPSQT_TABLE_RESULTS."` ADD  `score` INT NULL , ADD  `total` INT  NULL , ADD  `percentage` INT NULL","Added scores columns to results");
		}
		apply_filters( 'wpsqt_upgrade_object', $objUpgrade, $version );
	
		return $objUpgrade;
		
	}	
	
	/**
	 * Adds queries to be run when executing the upgrade.
	 * 
	 * @param string $query
	 * @param string $message
	 * @since 2.0
	 */
	public function addQuery( $query , $message = false ){
		
		$this->queries[] = array(
							  'query' => $query, 
							  'message' => $message
						   );
		
		return $this;
	}
	
	/**
	 * Adds objects that are to be executed when the 
	 * upgrade object is executed.
	 * 
	 * @param Wpsqt_Upgrade_Interface $object
	 * @param string $message
	 * @since 2.0
	 */
	public function addObject( Wpsqt_Upgrade_Interface $object , $message = false){
		
		$this->objects[] = array(
								'object' => $object,
								'message' => $message
							);
		
		return $this;
	}
	
	/**
	 * Execution 
	 * 
	 * @since 2.0
	 */
	public function execute(){
		
		global $wpdb;
		flush();
		ob_flush();
		foreach ( $this->objects as $objectData ){
			
			$objectData['object']->execute();
			print $objectData['message'];
			print '<br />'.PHP_EOL;
			flush();
			
			if ( ob_get_level() ){
				ob_flush();
			}
			
		}
		
		foreach ( $this->queries as $queryData ){
			
			$wpdb->query( $queryData['query'] );
			print $queryData['message'];
			print '<br />'.PHP_EOL;			
			flush();
			
			if ( ob_get_level() ){
				ob_flush();
			}
			
		}
		
		update_option('wpsqt_update_required',false);
		
		return;
		
	}
}