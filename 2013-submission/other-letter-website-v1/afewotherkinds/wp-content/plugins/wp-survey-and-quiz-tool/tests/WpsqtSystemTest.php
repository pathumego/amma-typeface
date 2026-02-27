<?php

	/**
	 * The unit test for the Wpsqt_System class, checks that 
	 * the selecting,updating,inserting functionality for
	 * quizzes and surveys. 
	 * 
	 * @author Iain Cambridge
	 * @since 2.0
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
	 * @license GPL v2
	 * @package WP Survey And Quiz Tool
	 */

class WpsqtSystemTest extends PHPUnit_Framework_TestCase {

	/**
	 * Holds a copy of the wpdb instance
	 * @var wpdb
	 */
	protected $db;
	
	/**
	 * Holds a boolean value to say if a filter has been called or not.
	 * @var boolean
	 */
	protected $filterCalled = false;
	
	/**
     * Holds a copy of the dummy quiz detaiils to be used for the tests.
     * @var array
	 */
	protected $dummyQuizDetails;
	
	
	/**
	 * Holds the quiz id of the dummy quiz that was inserted.
	 * @var integer
	 */
	protected $dummyQuizId;
	
	/**
	 * Assigns to the wpdb instance to the internal. And adds the dummy filter
	 * hooks so we can test if the filters are being called as they should be.
	 * Sets the dummy quiz and survey details array for use later.
	 * 
	 * @since 2.0
	 */
	public function __construct(){
		parent::__construct();
		global $wpdb;
		$this->db = $wpdb;	
		
		foreach ( array("wpsqt_fetch_quiz_details","wpsqt_fetch_survey_details",
						"wpsqt_pre_save_quiz_details","wpsqt_pre_save_survey_details") as $filter ){
			add_filter($filter, array($this, "dummy_filter"));
		}
		
		$this->dummyQuizDetails = array('name' => 'PHPUnit test  quiz creation',
								  		'display_result' => 'no',
										'id' => 0,
								  		'status' => 'disabled',
										'limit_one' => 'no',
										'email_template' => '',	
										'notify_completion' => 'never',
										'type' => 'quiz'							
								  );
		
		return true;
	}
	
	/**
	 * Resets all the variables.
	 */
	public function setUp(){
		$this->filterCalled = false;
		$this->dummyQuizId = 0;
		$this->dummySurveyId = 0;
	}

	/**
	 * Deletes any rows created during the test.
	 */
	public function tearDown(){
		
		if ( $this->dummyQuizId != 0 ){
			$this->db->query(
				$this->db->prepare("DELETE FROM `".WPSQT_TABLE_QUIZ_SURVEYS."` WHERE id = %d", array($this->dummyQuizId))
			);
		} 
		
	}
	
	/**
	 * Turns $this->filterCalled to true
	 * so we know if the filter has been called.
	 * 
	 * @param array $input
	 * @since 2.0
	 */
	public function dummy_filter($input){
		$this->filterCalled = true;
		return $input;
	}
	
	
	/**
	 * Tests the serialization of the 
	 * quiz array. Also makes sure
	 * the wpsqt_pre_save_quiz_details 
	 * filter is called.
	 * 
	 * @since 2.0
	 */
	public function testSerializationOfQuiz(){
		
		list($quizName,$quizId,$quizDetails) = Wpsqt_System::_serializeDetails($this->dummyQuizDetails, 'quiz');
		
		$unserializedDetails = unserialize($quizDetails);
		$this->assertEquals("PHPUnit test  quiz creation",$quizName,"Quiz name isn't what was expected");
		$this->assertEquals(0,$quizId,"Quiz ID isn't what was expected");
		
		$this->assertTrue(is_array($unserializedDetails), "The serialized quiz details isn't an array.");
		$this->assertEquals(array('display_result' => 'no',
								  		'status' => 'disabled',
										'limit_one' => 'no',
										'email_template' => '',	
										'notify_completion' => 'never'),$unserializedDetails, "The unserialized array isn't what was expected.");
		$this->assertTrue($this->filterCalled,"Filter 'wpsqt_pre_save_quiz_details' wasn't called.");
		
		
		
	}
	
	/**
	 * Tests the unserialization of the quiz array.
	 * While ensuring that the wpsqt_fetch_quiz_details
	 * filter is called.
	 * 
	 * @since 2.0
	 */
	public function testUnserializationOfQuiz(){
		
		
		list($quizName,$quizId,$quizDetails) = Wpsqt_System::_serializeDetails($this->dummyQuizDetails, 'quiz');		
		$quizDetails = array('name' => $quizName,'id' => $quizId, 'settings' => $quizDetails);
		
		$this->filterCalled = false;
	
		$quizDetails = Wpsqt_System::_unserializeDetails($quizDetails,'quiz');	
		
		$this->assertEquals($this->dummyQuizDetails,$quizDetails,"Unserialized quiz details isn't what is expected.");
		$this->assertTrue($this->filterCalled,"Filter 'wpsqt_fetch_quiz_details' wasn't called.");
		
	}
	
	/**
	 * Tests that the insertion of quizzes is functional,
	 * ensuring that the filter wpsqt_pre_save_quiz_details
	 * is called along the way.
	 * 
	 * @since 2.0
	 */
	public function testQuizInsert(){
				
		$this->dummyQuizId = Wpsqt_System::insertItemDetails($this->dummyQuizDetails,'quiz');
		
		$results = $this->db->get_results(
							$this->db->prepare("SELECT * FROM `".WPSQT_TABLE_QUIZ_SURVEYS."` WHERE name = %s", array($this->dummyQuizDetails['name']))
							, ARRAY_A);
		
		$this->assertTrue(is_array($results),"The results from the SQL aren't an array");
		$this->assertEquals(sizeof($results),1, "There are more results than there should be.");
		$this->assertEquals($this->dummyQuizId,$results[0]['id'], "The quiz id doesn't match what was returned by Wpsqt_System::insertQuizDetails()");
		$this->assertTrue($this->filterCalled, "Seems the 'wpsqt_pre_save_quiz_details' filter.");
					
	}

	/**
	 * Test the update quiz functionality is working
	 * correctly also checks to see if the filter
	 * 'wpsqt_pre_save_quiz_details' is called along
	 * the way.
	 * 
	 * @since 2.0
	 */
	public function testQuizUpdate(){
				
		$this->dummyQuizId = Wpsqt_System::insertItemDetails($this->dummyQuizDetails,'quiz');
		
		$updateDetails = $this->dummyQuizDetails;
		$updateDetails['id'] = $this->dummyQuizId;
		$updateDetails['name'] = "PHPUnit test updated";
		
		Wpsqt_System::updateItemDetails($updateDetails,"quiz");
		
		$results = $this->db->get_results(
							$this->db->prepare("SELECT * FROM `".WPSQT_TABLE_QUIZ_SURVEYS."` WHERE id = %d", array($this->dummyQuizId))
							, ARRAY_A);
		
		$this->assertTrue(is_array($results),"The results from the SQL aren't an array");
		$this->assertEquals(sizeof($results),1, "There are more results than there should be.");
		$this->assertEquals($updateDetails['name'],$results[0]['name'], "The name hasn't changed. Expecting");
		$this->assertTrue($this->filterCalled, "Seems the 'wpsqt_pre_save_quiz_details' filter.");
	
	}
	
	/**
	 * Tests the quiz select quiz functionality is working
	 * as expected. Ensures the 'wpsqt_fetch_quiz_details'
	 * filter is called along the way. 
	 * 
	 * @since 2.0
	 */
	public function testQuizSelect(){
		
		 $this->dummyQuizId = Wpsqt_System::insertItemDetails($this->dummyQuizDetails,'quiz');
		 $this->filterCalled = false;
		 
		 $retrivedQuizDetails = Wpsqt_System::getItemDetails($this->dummyQuizId,'quiz');
		 
		 $expected = $this->dummyQuizDetails;
		 $expected['id'] = $this->dummyQuizId;
		 
		 $diff = array_diff($expected,$retrivedQuizDetails);
		 
		 $this->assertTrue( empty($diff) ,"Quizzes don't match");
		 $this->assertTrue( $this->filterCalled, "Filter 'wpsqt_fetch_quiz_details' wasn't called it seems." );
	
	}
	
	/**
	 * Test to see if if fetch all the quiz details functionality
	 * is working correctly. Also ensures the 'wpsqt_fetch_quiz_details'
	 * fitler is called along the way.
	 * 
	 * @since 2.0
	 */
	public function testQuizSelectAll(){
			
		global $wpdb;
		
		$this->dummyQuizId = Wpsqt_System::insertItemDetails($this->dummyQuizDetails,'quiz');
		$this->filterCalled = false;
		 
		$retrivedQuizDetails = Wpsqt_System::getAllItemDetails('quiz');
		$count = $wpdb->get_var("SELECT COUNT(*) FROM `".WPSQT_TABLE_QUIZ_SURVEYS."` WHERE type = 'quiz'");
			 
		$this->assertEquals( $count, sizeof($retrivedQuizDetails) ,"Quiz counts don't match");
		$this->assertTrue( $this->filterCalled, "Filter 'wpsqt_fetch_quiz_details' wasn't called it seems." );
	
	}
	
	/**
	 * Tests to see if the full lifecycle of sections is 
	 * working properly. Starts off with creating a 
	 * quiz since we'll need the quiz id then it
	 * inserts the section then checks to see if
	 * actually exists in the database. Then moves
	 * on to updating the sections.
	 * 
	 * @since 2.0
	 */
	public function testSectionsFullLifecycle(){
		
		global $wpdb;
		
		$this->dummyQuizId = Wpsqt_System::insertItemDetails($this->dummyQuizDetails,'quiz');
		
		Wpsqt_System::insertSection($this->dummyQuizId, 'Section Name', '1', 'random', 'mixed');
		
		$sections = $wpdb->get_results("SELECT * FROM `".WPSQT_TABLE_SECTIONS."` WHERE item_id = ".$this->dummyQuizId, ARRAY_A);
		// Should be only one since we have just created
		// the quiz and only inserted one section.
		
		$this->assertEquals(sizeof($sections),1,"Sections count doesn't match after insertion");
		$this->assertEquals("Section Name", $sections[0]['name'], "The sections names don't match after insertion");
		
		Wpsqt_System::updateSection($sections[0]['id'], "Update Section", 0, "random", "mixed");
		$sections = $wpdb->get_results("SELECT * FROM `".WPSQT_TABLE_SECTIONS."` WHERE item_id = ".$this->dummyQuizId, ARRAY_A);
		
		$this->assertEquals(sizeof($sections),1,"Sections count doesn't match after update");
		$this->assertEquals("Update Section", $sections[0]['name'], "The sections names don't match after update");
		
		Wpsqt_System::deleteSection($sections[0]['id']);
		$sections = $wpdb->get_results("SELECT * FROM `".WPSQT_TABLE_SECTIONS."` WHERE item_id = ".$this->dummyQuizId, ARRAY_A);
		
		$this->assertEquals(sizeof($sections),0,"Sections count doesn't match after deletion");
		
	}
	
	
	/**
	 * Tests the serialization of the Questions array first 
	 * serializes and then it unserilizes and then checks 
	 * to see if they are the same.
	 * 
	 * @since 2.0
	 */
	public function testQuestionsSerializationBothways(){
		
		$question =	array("text"       => "Test Question",
			  			  "section"    => "Section One",
						  "points"     => "3",
						  "difficulty" => "easy",
						  "add_text"   => "Fix this.",
						  "type"       => "question"
						);
		$serializedQuestion = array();
		list($serializedQuestion['text'],$serializedQuestion['type']
			,$serializedQuestion['difficulty'],
			$serializedQuestion['section'],$serializedQuestion['meta']) = Wpsqt_System::serializeQuestion($question,$_GET['subsection'],'quiz');
				
		$unserializedQuestion = Wpsqt_System::unserializeQuestion($serializedQuestion,'quiz');
		$this->assertEquals($question,$unserializedQuestion, "Arrays don't match up.");
		
	}
	
}