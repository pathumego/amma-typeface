<?php
require_once WPSQT_DIR.'lib/Wpsqt/Page.php';
	/**
	 * Duplicates quiz and surveys.
	 * 
	 * @author Ollie Armstrong
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Duplicate extends Wpsqt_Page {
		
	public function process(){
		global $wpdb;

		// Duplicate quiz
		$rowToDuplicate = $wpdb->get_row("SELECT `id`, `name`, `settings`, `type` FROM `".WPSQT_TABLE_QUIZ_SURVEYS."` WHERE `id` = '".$_GET['id']."'", ARRAY_A);

		$insert = $wpdb->insert(
			WPSQT_TABLE_QUIZ_SURVEYS,
			array(
				'name' => $rowToDuplicate['name'],
				'settings' => $rowToDuplicate['settings'],
				'type' => $rowToDuplicate['type'],
				'timestamp' => date("Y-m-d H:i:s")
			)
		);

		$newSectionIds = array();

		if ($insert == 1) {
			$itemId = $wpdb->insert_id;

			// Duplicate sections
			$sectionInfos = $wpdb->get_results("SELECT `id`, `name`, `limit`, `order`, `difficulty` FROM `".WPSQT_TABLE_SECTIONS."` WHERE `item_id` = '".$rowToDuplicate['id']."'", ARRAY_A);

			if (isset($sectionInfos) && !empty($sectionInfos) && $sectionInfos != NULL) {
				foreach ($sectionInfos as $sectionInfo) {
					$insert = $wpdb->insert(
						WPSQT_TABLE_SECTIONS,
						array(
							'item_id' => $itemId,
							'name' => $sectionInfo['name'],
							'limit' => $sectionInfo['limit'],
							'order' => $sectionInfo['order'],
							'difficulty' => $sectionInfo['difficulty'],
							'timestamp' => date("Y-m-d H:i:s")
						)
					);
					$newSectionIds[$sectionInfo['id']] = $wpdb->insert_id;
					if ($insert != 1) {
						echo 'Error duplicating quiz';
						exit;
					}
				}
			}

			// Duplicate questions
			$questionInfos = $wpdb->get_results("SELECT `name`, `type`, `section_id`, `difficulty`, `meta` FROM `".WPSQT_TABLE_QUESTIONS."` WHERE `item_id` = '".$rowToDuplicate['id']."'", ARRAY_A);
			
			if (isset($questionInfos) && !empty($questionInfos) && $questionInfos != NULL) {
				foreach ($questionInfos as $questionInfo) {
					$insert = $wpdb->insert(
						WPSQT_TABLE_QUESTIONS,
						array(
							'item_id' => $itemId,
							'name' => $questionInfo['name'],
							'type' => $questionInfo['type'],
							'section_id' => $newSectionIds[$questionInfo['section_id']],
							'difficulty' => $questionInfo['difficulty'],
							'meta' => $questionInfo['meta'],
							'timestamp' => date("Y-m-d H:i:s")
						)
					);
					if ($insert != 1) {
						echo 'Error duplicating quiz';
						exit;
					}
				}
			}

			// Duplicate form fields
			$formInfos = $wpdb->get_results("SELECT `name`, `type`, `required`, `validation` FROM `".WPSQT_TABLE_FORMS."` WHERE `item_id` = '".$rowToDuplicate['id']."'", ARRAY_A);

			if (isset($formInfos) && !empty($formInfos) && $formInfos != NULL) {
				foreach ($formInfos as $formInfo) {
					$insert = $wpdb->insert(
						WPSQT_TABLE_FORMS,
						array(
							'item_id' => $itemId,
							'name' => $formInfo['name'],
							'type' => $formInfo['type'],
							'required' => $formInfo['required'],
							'validation' => $formInfo['validation'],
							'timestamp' => date("Y-m-d H:i:s")
						)
					);
					if ($insert != 1) {
						echo 'Error duplicating quiz';
						exit;
					}
				}
			}

			parent::redirect(WPSQT_URL_MAIN);
		} else {
			echo 'Error duplicating quiz';
			exit;
		}
		
	}
	
}
