<?php

	/**
	 * Central class for the Create Read Update Delete
	 * of the quizzes and surveys.
	 *
	 * @author Iain Cambridge
	 * @copyright All rights reserved 2010-2011 (c)
	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
	 * @package WP Survey and Quiz Tool
	 * @since 2.0
	 */ 

class Wpsqt_System {

	/**
	 * Fetches a quiz or survvey from the database. Then
	 * runs it through unserializeDetails to return a
	 * usable array.  
	 * 
	 * @param integer|string $id The ID or name for the quiz or survey in the database.
	 * @param string $type The type of item, generally quiz or survey.
	 * @return array
	 * @since 2.0
	 */
	
	public static function getItemDetails($id,$type){
		
		global $wpdb;
		
		if ( is_int($id) || ctype_digit($id) ){
			$quizRow = $wpdb->get_row( 
								$wpdb->prepare("SELECT * FROM ".WPSQT_TABLE_QUIZ_SURVEYS." WHERE id = %d", array($id) ), ARRAY_A
								);
		} else {
			$quizRow = $wpdb->get_row( 
								$wpdb->prepare("SELECT * FROM ".WPSQT_TABLE_QUIZ_SURVEYS." WHERE name = %s", array($id) ), ARRAY_A
								);
		}
		
		if ( empty($quizRow) ){
			return null;
		}
		
		$quizDetails = self::_unserializeDetails($quizRow,$type);
		
		return $quizDetails;
		
	}

	/**
	 * Fetchs all the items or all the items of a certain 
	 * type. And runs them through self::_unserializeDetails 
	 * to retrive usable arrays. 
	 * 
	 * @param string|boolean $type The type of items to fetch if boolean false then it will fetch all the items in the database.
	 * @return array
	 * @since 2.0
	 */
	public static function getAllItemDetails($type = false){
		
		global $wpdb;
	
		if ( empty($type) ){
			$sql = "SELECT wpsq.*,COUNT(wpar.id) as results
					FROM `".WPSQT_TABLE_QUIZ_SURVEYS."` as wpsq
					LEFT JOIN `".WPSQT_TABLE_RESULTS."` as wpar ON wpar.item_id = wpsq.id
					GROUP BY wpsq.id";
		} else {
			$sql = $wpdb->prepare("SELECT wpsq.*,COUNT(wpar.id) as results
									FROM `".WPSQT_TABLE_QUIZ_SURVEYS."` as wpsq
									LEFT JOIN `".WPSQT_TABLE_RESULTS."` as wpar ON wpar.item_id = wpsq.id
									WHERE wpsq.type = %s
									GROUP BY wpsq.id",
								  array($type) );
		}
		
		$quizRowList = $wpdb->get_results($sql, ARRAY_A); 
		
		$quizList = array();
		
		foreach ($quizRowList as $quizRow ){
			$quizList[] = self::_unserializeDetails($quizRow,$type);
		}
		
		return $quizList;
	}
	
	/**
	 * Updates the items database. Starts off with
	 * turnin $itemsDetails into an savable format.
	 * 
	 * @param array $itemDetails
	 * @param string $type
	 * @return integer
	 * @since 2.0
	 */
	public static function updateItemDetails($itemDetails,$type){
		
		global $wpdb;
		
		list($itemName,$itemId,$itemSettings) =  self::_serializeDetails($itemDetails,$type);
		
		return $wpdb->query( 
				$wpdb->prepare("UPDATE `".WPSQT_TABLE_QUIZ_SURVEYS."` SET `name`=%s,`settings`=%s WHERE `id`=%d", 
								array($itemName,$itemSettings,$itemId) )
		);
		
	}
		
	/**
	 * Inserts the item into the database. Runs them
	 * through self::_serializeDetails to turn $itemDetails 
	 * into a savable format. 
	 * 
	 * @param arrray $itemDetails
	 * @param string $type
	 * @since 2.0
	 */
	public static function insertItemDetails($itemDetails, $type){
	
		global $wpdb;
		
		list($itemName,$itemId,$itemSettings) = self::_serializeDetails($itemDetails,$type);
	
		$wpdb->query(
			$wpdb->prepare("INSERT INTO `".WPSQT_TABLE_QUIZ_SURVEYS."` (name,settings,type) VALUES (%s,%s,%s)",
						   array($itemName,$itemSettings,$type)
			)
		);
		
		return $wpdb->insert_id;
	}
	
	/**
	 * Unseralizes the settings and returns an array with all the
	 * quiz details in a single dimensional array. Runs through 
	 * the wpsqt_fetch_{survey|quiz}_details filter before returning.
	 * 
	 * @param array $details The original SQL result/
	 * @param string $type The type of details, 'quiz' or 'survey'
	 * @return array The details unseralized.
	 * @since 2.0
	 */
	public static function _unserializeDetails($row, $type = false){
		
		$details = array(
						'id' => $row['id'],
						'name' => $row['name'],
						);
						
		if ( isset($row['results']) ){
			$details['results'] = $row['results'];	
		}		
							
		if ( !empty($row['settings']) 
			&& is_array($settings = unserialize($row['settings'])) ){
				$details = array_merge($details,$settings);
		}					
		$details['type'] = $type;
		if ( !is_bool($type) ){
			$details = apply_filters( 'wpsqt_fetch_'.$type.'_details' , $details );
		}
		
		return $details;
		
	}
	
	/**
	 * Serializes the detials for a quiz or survey so they
	 * can be saved into the database. Runs through 
	 * wpsqt_pre_save_{survey|quiz}_details filter before 
	 * serializing the array.
	 * 
	 * @return array Contains a numerical array containing the name, the ID then the settings value.
	 * @since 2.0
	 */
	
	public static function _serializeDetails($details,$type){
		
		if ( !is_bool($type) ){
			$details = apply_filters ( 'wpsqt_pre_save_'.$type.'_details' , $details );
		}
		
		$quizName = $details['name'];
		$quizId = (isset($details['id'])) ? $details['id'] : 0;
		
		unset($details['type']);
		unset($details['id']);
		unset($details['name']);
		
		$quizSettings = serialize($details);
	
		return array($quizName,$quizId,$quizSettings);
	
	}
	
	/**
	 * Handles inserting the section 
	 *  
	 * @param integer $itemId
	 * @param string $sectionName
	 * @param integer $sectionCount
	 * @param string $sectionOrder
	 * @uses wpdb
	 * @since 2.0
	 */
	public static function insertSection($itemId, $sectionName, $sectionCount, $sectionOrder, $difficulty ){

		global $wpdb;
		
		$wpdb->query(
			$wpdb->prepare("INSERT INTO `".WPSQT_TABLE_SECTIONS."` (`item_id`,`name`,`limit`,`order`,`difficulty`) VALUES (%d,%s,%d,%s,%s)",
						   array($itemId,$sectionName,$sectionCount,$sectionOrder,$difficulty)	 )
					);
		
		do_action("wpsqt_insert_section",$itemId);
		
		return $wpdb->insert_id;
		
	}
	
	/**
	 * Updates the section with the id $sectionId.
	 * 
	 * @param integer $sectionId
	 * @param string $sectionName
	 * @param integer $sectionCount
	 * @param string $sectionOrder
	 */
	public static function updateSection($sectionId, $sectionName, $sectionCount, $sectionOrder, $difficulty ){
		
		global $wpdb;
				
		$wpdb->query(
			$wpdb->prepare("UPDATE `".WPSQT_TABLE_SECTIONS."` SET `name`=%s,`limit`=%s,`order`=%s,`difficulty`=%s WHERE `id` = %d",
						 	array($sectionName,$sectionCount,$sectionOrder,$difficulty,$sectionId) )
				);
		
		do_action("wpsqt_update_section",$sectionId);		
	}
	
	/**
	 * Delete the section with the id $sectionId.
	 * 
	 * @param integer $sectionId
	 */
	public static function deleteSection($sectionId){
		
		global $wpdb;
		
		$wpdb->query(
			$wpdb->prepare("DELETE FROM `".WPSQT_TABLE_SECTIONS."` WHERE `id` = %d", array($sectionId))
				);
		
		do_action("wpsqt_delete_section",$sectionId);		
	}
	
	/**
	 * Fetchs all the sections for an 
	 * 
	 * @param integer $itemId
	 * @since 2.0
	 */
	public static function fetchSections($itemId){
		
		global $wpdb;	
	
		$sections = $wpdb->get_results(
						$wpdb->prepare("SELECT * FROM `".WPSQT_TABLE_SECTIONS."` WHERE `item_id` = %d",
									    array($itemId)),ARRAY_A
					);
		
		if ( empty($sections) ){
			$sections = array(array('id' => false,'difficulty' => false,'order' => false,'name' => false,'limit' => false));
		}	
		
		$sections = apply_filters("wpsqt_fetch_sections",$sections);			
					
		return $sections;
		
	}
	
	/**
	 * Handles inserting new form items. 
	 * 
	 * @param integer $itemId The id for the quiz or survey.
	 * @param string $name The name/label for the form item.
	 * @param string $type The type of form item it will be.
	 * @param string $required If the form item is required for moving on to actually do the quiz or survey.
	 * @param string $validation The type if any of validation to be used of the form item.
	 * @since 2.0
	 */
	
	public static function insertFormItem($itemId,$name,$type,$required,$validation){
		
		global $wpdb;
		
		$wpdb->query(
				$wpdb->prepare("INSERT INTO `".WPSQT_TABLE_FORMS."` (item_id,name,type,required,validation) 
								VALUES (%d,%s,%s,%s,%s)", 
							    array($itemId,$name,$type,$required,$validation))
				);

		do_action("wpsqt_insert_form",$itemId);		
				
		return $wpdb->insert_id;
	} 
	
	/**
	 * Handles updating the form items.
	 * 
	 * @param integer $formItemId The id that related to the form field.
	 * @param string $name The name/label for the form field.
	 * @param string $type The type of input field.
	 * @param string $required Yes or no if the field is required.
	 * @param string $validation The type of validation to be applied to the field.
	 * @since 2.0
	 */
	public static function updateFormItem($formItemId,$name,$type,$required,$validation){

		global $wpdb;
		
		$wpdb->query(
				$wpdb->prepare("UPDATE `".WPSQT_TABLE_FORMS."` SET name=%s,type=%s,required=%s,validation=%s WHERE id = %d",
							   array($name,$type,$required,$validation,$formItemId))
				);
		do_action("wpsqt_update_form",$formItemId);
				
		return true;
	}
	
	/**
	 * Handles deleting a form item.
	 * 
	 * @param integer $formItemId The id that relateds to the form field id.
	 * @since 2.0
	 */
	public static function deleteFormItem( $formItemId ){
		
		global $wpdb;
		
		$wpdb->query(
				$wpdb->prepare("DELETE FROM `".WPSQT_TABLE_FORMS."` WHERE id = %d", array($formItemId))
				);
		do_action("wpsqt_delete_form",$formItemId);
				
		return true;
	}
	
	/**
	 * Returns an array of validators for the form.
	 * 
	 * @since 2.0
	 */
	
	public static function fetchValidators(){
		
		$validators = array("None","Text","Number","Email"); 
		
		$validators = apply_filters("wpsqt_validators",$validators);
		
		return $validators;
	}
	
	/**
	 * Turns the question array into a savable format. Starts off 
	 * by applying the wpsqt_pre_save_{quiz|survey}_question Then goes
	 * through a foreach loop assigning variables into the output 
	 * array then unsets the it the question array. Then serializes
	 * everything that is lef for the meta data.
	 * 
	 * <code>
	 * list($questionText,$questionType, $questionPoints,
	 * 		$questiionDifficulty,$questionSection,
	 * 		$questionAdditional,$questionMeta) = Wpsqt_System::seralizeQuestion($question,'quiz');
	 * </code>
	 * 
	 * @param array $question
	 * @param string $type
	 * @since 2.0
	 */
	public static function serializeQuestion( $question , $type ){
		
		$question = apply_filters("wpsqt_pre_save_".$type."_question",$question);
		$output = array();
		
		foreach( array("name", "type",
			 		   "difficulty", "section") as $index ){
			$output[] = $question[$index];
			unset($question[$index]);
		}
		unset($question['id']);
		unset($question['nonce']);
		$output[] = serialize($question);
				
		return $output;
		
	}
	
	/**
	 * Turns the savable question data into a unserialized unsable verison,
	 * starts off by cloning the question array then unsetting the meta 
	 * column then does array_merge on the cloned question array and the 
	 * unserialized type. Before returning the value it runs it through the
	 * wpsqt_fetch_save_{survey|quiz}_question filter.
	 * 
	 * @param array $question The raw question data which is to be unserialized.
	 * @param string $type To be used when the filter is applied.
	 * @since 2.0
	 */
	
	public static function unserializeQuestion( $rawQuestion, $type ){
		
		unset($rawQuestion['nonce']);
		$question = $rawQuestion;
		unset($question['meta']);
		$question = array_merge($question,unserialize($rawQuestion['meta']));
		
		return apply_filters("wpsqt_fetch_save_".$type."_question",$question);
		
	}
	
	/**
	 * Returns the questions types that are related to 
	 * quizzes. Runs the filter wpsqt_quiz_question_types.
	 * 
	 * @since 2.0 
	 */
	public static function getQuizQuestionTypes(){
		
		$questions = array('Multiple' => 'Multiple choice question with mulitple correct answers.', 
									  	  'Single' => 'Multiple choice question with a signle correct answer.',
							 			  'Free Text' => 'Question where the user types in the answer into a textarea.' );
		
		return apply_filters('wpsqt_quiz_question_types', $questions );
	} 
	
	/**
	 * Returns the questions types that are related to
	 * surveys. Runs the filter wpsqt_survey_question_types.
	 * 
	 * @since 2.0
	 */	
	public static function getSurveyQuestionTypes(){
		
		$questions = array('Multiple Choice' => 'Multiple choice question with mulitple correct answers.',
									  'Dropdown' => 'Multiple choice question with mulitple correct answers.',
									  'Likert' => '',
									  'Likert Matrix' => 'Displays a matrix of likert scales from 1 to 5',
									  'Free Text' => '');
		
		return apply_filters('wpsqt_survey_question_types', $questions );
		
	}
	
	public static function getPollQuestionTypes(){
		
		$questions = array('Single' => 'Multiple choice question with a signle correct answer.','Multiple' => 'Multiple choice question with mulitple correct answers.');
		
		return apply_filters('wpsqt_survey_question_types', $questions );
		
	}

	/**
	 * Deletes all results from a survey/poll
	 *
	 */
	public static function deleteAllResults($id) {
		global $wpdb;

		$wpdb->query($wpdb->prepare("DELETE FROM `".WPSQT_TABLE_SURVEY_CACHE."` WHERE item_id = %d",
							array($id)));
		$wpdb->query($wpdb->prepare("DELETE FROM `".WPSQT_TABLE_RESULTS."` WHERE item_id = %d",
							array($id)));
	}
	
}
