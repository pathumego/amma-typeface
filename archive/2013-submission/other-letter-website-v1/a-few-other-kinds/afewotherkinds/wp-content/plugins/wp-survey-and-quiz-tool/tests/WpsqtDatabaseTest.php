<?php

	/**
	 * Checks and ensures that all the databases are correct and 
	 * are the schema are the the way they should be on creation.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011 (c)
	 * @license GPL v2
	 * @package WP Survey And Quiz Tool
	 * @since 2.0
	 */

class WpsqtDatabaseTest extends PHPUnit_Framework_TestCase {

	/**
	 * Holds a copy of the wpdb instance
	 * @var wpdb
	 */
	protected $db;
	
	/**
	 * Assigns to the wpdb instance to the internal 
	 */
	public function __construct(){
		
		parent::__construct();
		global $wpdb;
		$this->db = $wpdb;	
		
	}	

	/**
	 * Checks and sees if all the tables are
	 * present and have the correct schema.
	 * 
	 * @since 2.0
	 */
	public function testCheckTables(){
		
		$quizTable = $this->db->get_var("SHOW TABLES LIKE '".WPSQT_TABLE_QUIZ_SURVEYS."'");
		
		$this->assertEquals(WPSQT_TABLE_QUIZ_SURVEYS,$quizTable,"Quiz table not found!");
		
	}

}