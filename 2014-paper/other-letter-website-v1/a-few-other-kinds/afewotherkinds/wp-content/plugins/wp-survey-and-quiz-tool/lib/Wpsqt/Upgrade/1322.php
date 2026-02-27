<?php

	/**
	 * The upgrade class to upgrade from 1.3.x to 2.0
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
	 * @since 2.0
	 * @package WP Survey And Quiz Tool
	 */

class Wpsqt_Upgrade_1322 implements Wpsqt_Upgrade_Interface {
	
	public function execute(){
		
		global $wpdb;
						
			
		$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_TABLE_QUESTIONS."` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `name` varchar(255) NOT NULL,
					  `type` varchar(255) NOT NULL,
					  `item_id` int(11) NOT NULL,
					  `section_id` int(11) NOT NULL,
					  `difficulty` varchar(255) NOT NULL,
					  `meta` longtext NOT NULL,
					  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		");
	
		$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_TABLE_RESULTS."`(
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `item_id` int(11) NOT NULL,
					  `timetaken` int(11) NOT NULL,
					  `person` longtext NOT NULL,
					  `sections` longtext NOT NULL,
					  `person_name` varchar(255) NOT NULL,
					  `ipaddress` varchar(255) NOT NULL,
					  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
					  `status` varchar(255) NOT NULL DEFAULT 'unviewed',
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		");
	
		$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_TABLE_FORMS."` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `item_id` int(11) NOT NULL,
					  `name` varchar(255) NOT NULL,
					  `type` varchar(255) NOT NULL,
					  `required` varchar(255) NOT NULL,
					  `validation` varchar(355) NOT NULL,
					  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
			");
		$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_TABLE_QUIZ_SURVEYS."` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `name` varchar(255) NOT NULL,
					  `settings` longtext NOT NULL,
					  `type` varchar(266) NOT NULL,
					  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");	
	
		$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_TABLE_SECTIONS."` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `item_id` int(11) NOT NULL,
					  `name` varchar(255) NOT NULL,
					  `limit` varchar(255) NOT NULL,
					  `order` varchar(11) NOT NULL,
					  `difficulty` varchar(255) NOT NULL,
					  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					  UNIQUE KEY `id` (`id`)
					) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		");
	
		$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_TABLE_SURVEY_CACHE."` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `sections` longtext NOT NULL,
					  `total` int(11) NOT NULL,
					  `item_id` int(11) NOT NULL,
					  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
		");
		
		$quizzes = $wpdb->get_results("SELECT * FROM `".$wpdb->get_blog_prefix()."wpsqt_quiz`", ARRAY_A);
		
		foreach ( $quizzes as $quiz ){
			
			$sectionIds = array();
			$quiz['display'] = $quiz['display_result'];
			$quiz['finish_message'] = '';
			$quizId = Wpsqt_System::insertItemDetails( $quiz , 'quiz' );
			$questions = $wpdb->get_results( "SELECT * FROM `".$wpdb->get_blog_prefix()."wpsqt_questions` WHERE quizid = ".$quiz['id'], ARRAY_A );
			$sections  = $wpdb->get_results( "SELECT * FROM `".$wpdb->get_blog_prefix()."wpsqt_quiz_sections` WHERE quizid = ".$quiz['id'], ARRAY_A );
			$results   = $wpdb->get_results( "SELECT * FROM `".$wpdb->get_blog_prefix()."wpsqt_results` WHERE quizid = ".$quiz['id'], ARRAY_A );
			$forms      = $wpdb->get_results( "SELECT * FROM `".$wpdb->get_blog_prefix()."wpsqt_forms` WHERE quizid = ".$quiz['id'], ARRAY_A );
	
			if ( !empty($forms) ){
				foreach( $forms as $form ){
					Wpsqt_System::insertFormItem($quizId, $form['name'], $form['type'], 
							  							  $form['required'], 'none');
				}
			}
			
			foreach ( $sections as $section ) {
				// So we can relate the old sectionId with the new one.
				$sectionIds[ $section['id'] ] = Wpsqt_System::insertSection( $quizId , $section['name'], 
												 							$section['number'], $section['orderby'],
												 							$section['difficulty']);
				
			}
			
			foreach ( $questions as $question ){			
				
				$question['name'] = $question['text'];
				$question['section'] = $question['sectionid'];
				
				unset($question['text']);
				unset($question['sectionid']);
				
				$sectionId = $sectionIds[ $question['section'] ];
				
				$answers = $wpdb->get_results("SELECT * FROM `".$wpdb->get_blog_prefix()."wpsqt_answer` WHERE questionid = ".$question['id'], ARRAY_A );
				if ( !empty($answers) ){
					$question['answers'] = $answers;
				}
				
				list($questionText, $questionType, $questionDifficulty,
					 $questionSection, $questionMeta) = Wpsqt_System::serializeQuestion($question,'quiz');
				$wpdb->query( 
					$wpdb->prepare("INSERT INTO `".WPSQT_TABLE_QUESTIONS."` 
									(name,type,item_id,section_id,difficulty,meta) 
									VALUES (%s,%s,%d,%d,%s,%s)",
									array($questionText,$questionType,$quizId,
										  $sectionId,$questionDifficulty,$questionMeta))
					);
				
					 
			}
			
			foreach ( $results as $result ){
				
				$sections =  unserialize( $result['sections'] );
				
				foreach ( $sections as &$section ){
					
					foreach ( $section['questions'] as $key => &$value ){
						
						$value['name'] = $value['text'];
						unset($value['text']);
						
					}
					
				}
				$result['sections'] = serialize($sections);
				
				$wpdb->query(
					$wpdb->prepare("INSERT INTO `".WPSQT_TABLE_RESULTS."` (timetaken,person,sections,item_id,person_name,ipaddress,status) 
									VALUES (%d,%s,%s,%d,%s,%s,%s)",
									   array($result['timetaken'],
								   		 $result['person'],
								   		 $result['sections'],
								   		 $quizId,
								   		 $result['person_name'],
								   		 $result['ipaddress'],
								   		 $result['status'] ) )
						);
			
			}
		}
	
		
		$surveys = $wpdb->get_results("SELECT * FROM `".$wpdb->get_blog_prefix()."wpsqt_survey`", ARRAY_A);
		
		foreach ( $surveys as $survey ){
			
			$sectionIds = array();
			$surveyId = Wpsqt_System::insertItemDetails( $survey , 'survey' );
			$questions = $wpdb->get_results( "SELECT * FROM `".$wpdb->get_blog_prefix()."wpsqt_survey_questions` WHERE surveyid = ".$survey['id'], ARRAY_A );
			$sections  = $wpdb->get_results( "SELECT * FROM `".$wpdb->get_blog_prefix()."wpsqt_survey_sections` WHERE surveyid = ".$survey['id'], ARRAY_A );
			$results   = $wpdb->get_results( "SELECT * FROM `".$wpdb->get_blog_prefix()."wpsqt_survey_single_results` WHERE surveyid = ".$survey['id'], ARRAY_A );
			$forms      = $wpdb->get_results( "SELECT * FROM `".$wpdb->get_blog_prefix()."wpsqt_forms` WHERE surveyid = ".$survey['id'], ARRAY_A );
			
			if ( !empty($forms) ){
				foreach( $forms as $form ){
					Wpsqt_System::insertFormItem($surveyId, $form['name'], $form['type'], 
							  							  $form['required'], 'none');
				}
			}
			
			foreach ( $sections as $section ) {
				// So we can relate the old sectionId with the new one.
				$sectionIds[ $section['id'] ] = Wpsqt_System::insertSection( $surveyId , $section['name'], 
												 							$section['number'], $section['orderby'],
												 							false);
				
			}
			
			foreach ( $questions as $question ){			
				
				$question['name'] = $question['text'];
				$question['section'] = $question['sectionid'];
				
				unset($question['text']);
				unset($question['sectionid']);
				
				$sectionId = $sectionIds[ $question['section'] ];
				
				$answers = $wpdb->get_results("SELECT * FROM `".$wpdb->get_blog_prefix()."wpsqt_survey_questions_answers` WHERE questionid = ".$question['id'], ARRAY_A );
				if ( !empty($answers) ){
					$question['answers'] = $answers;
				}
				$question['difficulty'] = false;
				
				list($questionText, $questionType, $questionDifficulty,
					 $questionSection, $questionMeta) = Wpsqt_System::serializeQuestion($question,'survey');
				$wpdb->query( 
					$wpdb->prepare("INSERT INTO `".WPSQT_TABLE_QUESTIONS."` 
									(name,type,item_id,section_id,difficulty,meta) 
									VALUES (%s,%s,%d,%d,%s,%s)",
									array($questionText, ucfirst($questionType) ,$surveyId,
										  $sectionId,$questionDifficulty,$questionMeta))
					);
										 
			}
			$cachedSections = array();
			
			foreach ( $results as $result ){				
			
				$sections =  unserialize( $result['results'] );
				
					
				foreach ( $sections as $sectionKey => &$section ){		
								
					$section['answers'] = array();
					foreach ( $section['questions'] as $key => &$value ){
							
						$questionId = $value['id'];
						$value['name'] = $value['text'];
						$section['answers'][ $questionId ]['given'] =array($value['answer']);
						$value['type'] = ucfirst($value['type']);
						
						if ( $value['type'] == 'Multiple' ){
							$value['type'] = 'Multiple Choice';
						}
						
						unset($value['text']);
							
					}
					
					if ( !array_key_exists($sectionKey,$cachedSections) ){
						$cachedSections[$sectionKey] = array();	
						$cachedSections[$sectionKey]['questions'] = array();
					}
					foreach ( $section['questions'] as $questionKey => $question ) {
						$questionId = $question['id']; 
						if ( !array_key_exists($question['id'], $cachedSections[$sectionKey]['questions']) ) {		
							$cachedSections[$sectionKey]['questions'][$questionId] = array();
							$cachedSections[$sectionKey]['questions'][$questionId]['name'] = $question['name'];
							$cachedSections[$sectionKey]['questions'][$questionId]['type'] = $question['type'];
							$cachedSections[$sectionKey]['questions'][$questionId]['answers'] = array(); 
						}	
		
						if ( $cachedSections[$sectionKey]['questions'][$questionId]['type'] == "Multiple Choice" ||
							 $cachedSections[$sectionKey]['questions'][$questionId]['type'] == "Dropdown" ) {
							if ( empty($cachedSections[$sectionKey]['questions'][$questionId]['answers']) ) {
								foreach ( $question['answers'] as $answerKey => $answers ){	
									$answerId = $answers['id'];
									$cachedSections[$sectionKey]['questions'][$questionId]['answers'][$answerId] = array("text" => $answers['text'],"count" => 0);
								}
							 }
		
						} elseif ( $cachedSections[$sectionKey]['questions'][$questionId]['type'] == "Likert" || 
								   $cachedSections[$sectionKey]['questions'][$questionId]['type'] == "Scale" ){							   	
						 	if ( empty($cachedSections[$sectionKey]['questions'][$questionId]['answers']) ) {
								for ( $i = 0; $i < 10; ++$i ){
									$cachedSections[$sectionKey]['questions'][$questionId]['answers'][$i] = array('count' => 0);	
								}	
							}							
						} elseif ( $cachedSections[$sectionKey]['questions'][$questionId]['type'] == "Free Text" ){
							if ( empty($cachedSections[$sectionKey]['questions'][$questionId]['answers']) ) {
								$cachedSections[$sectionKey]['questions'][$questionId]['answers'] = 'None Cached - Free Text Result';
							}
							continue;
						} else {
							if ( empty($cachedSections[$sectionKey]['questions'][$questionId]['answers']) ) {
								$cachedSections[$sectionKey]['questions'][$questionId]['answers'] = 'None Cached - Not a default question type.';
							}						
							continue;
						}
						$givenAnswer = (int) current($section['answers'][$questionId]['given']);
						$cachedSections[$sectionKey]['questions'][$questionId]['answers'][$givenAnswer]["count"]++;	
					}
						
				}	
	
				
				$result['results'] = serialize($sections);
				
				$wpdb->query(
					$wpdb->prepare("INSERT INTO `".WPSQT_TABLE_RESULTS."` (timetaken,person,sections,item_id,person_name,ipaddress,status) 
									VALUES (%d,%s,%s,%d,%s,%s,%s)",
									   array(0,
								   		 $result['person'],
								   		 $result['results'],
								   		 $surveyId,
								   		 $result['name'],
								   		 $result['ipaddress'],
								   		 'unviewed' ) )
						);
			
			}
			
			
			$wpdb->query( 
					$wpdb->prepare("INSERT INTO `".WPSQT_TABLE_SURVEY_CACHE."` (sections,item_id) VALUES (%s,%d)",
											 array(serialize($cachedSections),$surveyId) )
						);	
				
		}
	}
	
}