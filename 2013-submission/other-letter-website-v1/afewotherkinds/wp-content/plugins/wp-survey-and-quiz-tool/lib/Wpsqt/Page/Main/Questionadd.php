<?php

require_once WPSQT_DIR.'lib/Wpsqt/Form/Question.php';
require_once WPSQT_DIR.'lib/Wpsqt/Question.php';

	/**
	 * Handles the adding of new 
	 * questions into the database.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

abstract class Wpsqt_Page_Main_Questionadd extends Wpsqt_Page {
	
	/**
	 * Holds the data relating to the current question.
	 * 
	 * @var array
	 * @since 2.0
	 */
	protected $_question = array();
	/**
	 * Tells is if we're adding or editing a question.
	 * 
	 * @var string
	 * @since 2.0
	 */
	protected $_action = "add";
	/**
	 * Holds the question types along with the description of what they do.
	 *  
	 * @var array
	 * @since 2.0
	 */
	protected $_questionTypes;
	/**
	 * Tells is if it's a quiz or survey question.
	 * 
	 * @var string
	 * @since 2.0
	 */
	protected $_type;	
	
	/**
	 * (non-PHPdoc)
	 * @see Wpsqt_Page::process()
	 */
	public function process(){
		
		global $wpdb;
		
		if ( $this->_type == "survey" ) {
			$questionTypes = Wpsqt_System::getSurveyQuestionTypes();
		} else if ($this->_type == "poll") {
			$questionTypes = Wpsqt_System::getPollQuestionTypes();
		} else {
			$questionTypes = Wpsqt_System::getQuizQuestionTypes();
		}
		
		
		$rawSections = Wpsqt_System::fetchSections($_GET['id']);
		$sections = array();
		foreach( $rawSections as $section ){
			if ( $section['name'] !== false ){
				$sections[] = $section['name'];
				if ( isset($this->_question['wpsqt_section_id']) && $section['id'] == $this->_question['wpsqt_section_id'] ){
					$this->_question['wpsqt_section'] = $section['name'];
				}
			}
		}
		$this->_pageVars['objForm'] = new Wpsqt_Form_Question($questionTypes, $sections);
		$this->_pageVars['objForm']->setValues($this->_question);
		$this->_pageVars['sections'] = $sections;
		$this->_pageVars['subForm'] = "";
		$questionObjects = array();
		foreach ( $questionTypes as $type => $description ){
			$objQuestion =  Wpsqt_Question::getObject($type);
			$questionObjects[$type] = $objQuestion;
			$this->_pageVars['subForm'] .= $objQuestion->processValues($this->_question)->form();
		};
		
		if ($this->_type == "poll") {
			$this->_pageView = "admin/questions/pollform.php";
		} else {
			$this->_pageView = "admin/questions/form.php";
		}
		if ( $_SERVER['REQUEST_METHOD'] == "POST" ){

			$this->_pageVars['errorArray'] = $this->_pageVars['objForm']->getMessages($_POST);

			$question = array();
			
			foreach ( $questionObjects as $type => $objQuestion ) {	
				
				if ( $type != $_POST['wpsqt_type'] ){
					continue;
				}			
				$result = $objQuestion->processForm($_POST);
				
				if ( !is_array($result) ){
					continue;
				}
				
				$question[$result['name']] = $result['content'];
				$this->_pageVars['errorArray'] = array_merge($this->_pageVars['errorArray'],$result['errors']);
				
			}
			
			if ( !empty($this->_pageVars['errorArray']) ){
				return;
			}
			
			foreach ( $_POST as $key => $value ){
				$question[ str_ireplace("wpsqt_", "",$key) ] = $value;
			}
			
			list($questionText,$questionType, $questionDifficulty,
				$questionSection,$questionMeta) = Wpsqt_System::serializeQuestion($question,$_GET['subsection']);
			
			foreach( $rawSections as $section ){
				if ( $section['name'] == $_POST['wpsqt_section'] ){
					$sectionId = $section['id'];
					break;
				}
			}
			
			if ( $this->_action == "add" ){
				$wpdb->query( 
					$wpdb->prepare("INSERT INTO `".WPSQT_TABLE_QUESTIONS."` 
									(name,type,item_id,section_id,difficulty,meta) 
									VALUES (%s,%s,%d,%d,%s,%s)",
									array($questionText,$questionType,$_GET['id'],
										  $sectionId,$questionDifficulty,$questionMeta))
					);
				
				$this->_pageVars['redirectLocation'] = WPSQT_URL_MAIN."&section=questions&subsection=".
													   strtolower($_GET['subsection'])."&id="
													   .$_GET['id']."&new=true";
			} else {
				$wpdb->query( 
					$wpdb->prepare("UPDATE `".WPSQT_TABLE_QUESTIONS."` SET
									name = %s, type = %s,section_id = %d,
									difficulty = %s,meta = %s WHERE id = %d",
									array($questionText,$questionType,
										  $sectionId,$questionDifficulty,
										  $questionMeta,$_GET['questionid']))
					);	
				$this->_pageVars['redirectLocation'] = WPSQT_URL_MAIN."&section=questions&subsection=".
													   strtolower($_GET['subsection'])."&id="
													   .$_GET['id']."&edit=true";
			}			 
			 
				 
													   
			$this->_pageView = "admin/misc/redirect.php";
			
		}
		
	}

}