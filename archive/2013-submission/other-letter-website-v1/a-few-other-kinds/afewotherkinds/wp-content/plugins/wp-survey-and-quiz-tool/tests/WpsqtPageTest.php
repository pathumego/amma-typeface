<?php

	/**
	 * Checks to see if all the basic page functionality
	 * is working. Visual checks to be done via 
	 * 
	 * @author Iain Cambridge
	 * @copyright All rights reserved 2011 (C)
	 * @license GPL v2
	 */
class WpsqtPageTest extends PHPUnit_Framework_TestCase {
	
	protected $plugin;
	
	public function setUp(){
		
		global $objWpsqtPlugin;
		$this->plugin = $objWpsqtPlugin;
		
	}
	
	/**
	 * Checks to see if the main page is returning the
	 * correct object type.
	 */
	public function testMainListPage(){

		// Set up
		$oldGetPage = $_GET['page'];
		$_GET['page'] = WPSQT_PAGE_MAIN;
		$pageDetails = $this->plugin->getPageDetails(WPSQT_PAGE_MAIN);
		$className = 'Wpsqt_Page_'.ucfirst($pageDetails['module']);
		
		$this->assertTrue(is_a($this->plugin->show_page(true), $className),"Incorrect page object returned returned.");

		// teardown.
		$_GET['PAGE'] = $oldGetPage;
		
	}
	
}