<?php

	/**
	 * Handles the test for the Wpsqt_Core
	 * functionality, except the quiz and
	 * shortcode functionality which have 
	 * their own tests.
	 * 
	 * @author Iain Cambridge
	 * @copyright All rights reserved Fubra Limited 2010-2011 (c)
	 * @since 2.0
	 */

class WpsqtCoreTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * Sets the location of the custom pages
	 * directory.
	 */
	public function setUp(){
		
		$this->_customPagesDirectory = WPSQT_DIR.'pages/custom';
	}
	
	/**
	 * Holds the location of the custom string directory. 
	 * @var string
	 */
	protected $_customPagesDirectory;
	
	/**
	 * Holds a copy of the original blog id value. 
	 * @var integer
	 */
	protected $_oldBlogId;
	
	/**
	 * Checks to see if the custom pages functionality
	 * is working when a custom page is present. Creates
	 * the folder and page before calling the function to
	 * ensure it works. Will fail if permissions aren't
	 * set properly.
	 */
	public function testCustomPagesFunctionalityWithCustomDirectoryPage(){
		
		//setUp
		$_SESSION['wpsqt']['current_type'] = 'quiz';
		$_SESSION['wpsqt']['current_id'] = '666';		
		$expectedFileName = $this->_createCustomDirectoryFiles('quiz-666');
		$this->_changeBlogId(666);
		
		//test
		$actualFileName = Wpsqt_Core::pageView('site/quiz/section.php');
		$this->assertEquals($expectedFileName,$actualFileName,"Filename doesn't match what was expected.");
		
		//tearDown
		$this->_removeCustomDirectoryFiles('quiz-666');
		$this->_resetBlogId();
		
	}
	
	/**
	 * Checks to see the custom pages functionality is working,
	 * when the custom quiz folder isn't present but the shared
	 * directory is. Creates the shared folder and the file. Will
	 * fail if permissons aren't set properly. 
	 */
	public function testCustomPagesFunctionalityWithoutCustomDirectoryPageButWithShared(){
		
		//setUp	
		$_SESSION['wpsqt']['current_type'] = 'quiz';
		$_SESSION['wpsqt']['current_id'] = '666';	
		$expectedFileName = $this->_createCustomDirectoryFiles('shared');
		$this->_changeBlogId(666);
		//test
		
		$actualFileName = Wpsqt_Core::pageView('site/quiz/section.php');
		$this->assertEquals($expectedFileName,$actualFileName,"Filename doesn't match what was expected.");
		
		//tearDown
		$this->_removeCustomDirectoryFiles('shared');
		$this->_resetBlogId();
	}
	
	/**
	 * Checks the custom pages functionality is working when
	 * when there are no custom directories about to use.
	 */
	
	public function testCustomPagesFunctionalityWithoutAnyCustomPages(){
		
		$expectedFileName = WPSQT_DIR.'pages/site/quiz/section.php';
		$actualFileName = Wpsqt_Core::pageView('site/quiz/section.php');
		$this->assertEquals($expectedFileName,$actualFileName,"Filename doesn't match what was expected.");
		
	}
	
	
	/**
	 * Handles replacing the global $blog_id variable,
	 * stores a copy in $this->_oldBlogId before 
	 * replacing the value so it can be reset later.
	 * 
	 * @param integer $newId
	 */
	protected function _changeBlogId($newId){
		
		global $blog_id;
		
		$this->_oldBlogId = $blog_id;
		$blog_id = $newId;
		
	}
	
	/**
	 * Resets the global $blog_id variable with the 
	 * old value, if $this->_oldBlogId is empty then
	 * it does nothing. Since no blog id is 0 shouldn't
	 * cause a problem.
	 */
	
	protected function _resetBlogId(){
		
		if ( !empty($this->_oldBlogId) ){
			return ;
		}
		
		global $blog_id;
		
		$blog_id = $this->_oldBlogId;
		
	}
	
	/**
	 * Handles the creation of the custom directory files.
	 * Firstly creates a the directory that the files are 
	 * to be in, based on $directory agrument. 
	 * 
	 * @param string $directory The directory for the custom pages, either quiz-666
	 */	
	protected function _createCustomDirectoryFiles($directory){
		
		global $blog_id;
		
		$this->assertTrue(is_writable($this->_customPagesDirectory), 
						"Unable to write in '".$this->_customPagesDirectory."' to create test files" );	
		
		mkdir($this->_customPagesDirectory."/".$blog_id."/".$directory."/site/quiz/",0777,true);
		$this->assertTrue(is_dir($this->_customPagesDirectory."/".$blog_id."/".$directory."/site/quiz/"),
						  "The custom directory page hasn't been created.");
		
		$fp = fopen($this->_customPagesDirectory."/".$blog_id."/".$directory."/site/quiz/section.php","w+");
		$time = time();
		fwrite($fp, $time);
		fclose($fp);
		$this->assertTrue(file_exists($this->_customPagesDirectory."/".$blog_id."/".$directory."/site/quiz/section.php"),
						  "The test file doesn't exist");
		
		return $this->_customPagesDirectory."/".$blog_id."/".$directory."/site/quiz/section.php";
		
	}
	
	/**
	 * Deletes the custom pages directory, starts off with
	 * the file and then rmdir for each one the directories.
	 * 
	 * @param string $directory
	 */
	protected function _removeCustomDirectoryFiles($directory){

		global $blog_id;
		
		unlink($this->_customPagesDirectory."/".$blog_id."/".$directory."/site/quiz/section.php");
		rmdir($this->_customPagesDirectory."/".$blog_id."/".$directory."/site/quiz");
		rmdir($this->_customPagesDirectory."/".$blog_id."/".$directory."/site");
		rmdir($this->_customPagesDirectory."/".$blog_id."/".$directory);
		
	}

}