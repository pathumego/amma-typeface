<?php

	/**
	 * The master class for Page classes 
	 * 
	 * @author Iain Cambridge
	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
	 * @copyright All rights reserved 2011 (c)
	 * @since 2.0
	 * @package WP Survey And Quiz Tool
	 */

abstract class Wpsqt_Page {
	
	/**
	 * Holds what the sub section is, generally it's either quiz or survey.
	 * @var string
	 * @since 2.0
	 */
	protected $_subsection;
	
	/**
     * Holds a copy of the wpdb object
     * @var wpdb
	 * @since 2.0
	 */
	protected $wpdb;
	/**
     * Holds the location of the page view file location.
     * @var string
	 * @since 2.0
	 */
	protected $_pageView;
	/**
	 * Holds the page variables for the page view.
	 * @var array
	 * @since 2.0
	 */
	protected $_pageVars  = array();
	
	/**
	 * Sets up the default values for the 
	 * pages.
	 * @since 2.0
	 */
	
	final public function __construct(){
		
		do_action('wpsqt_page_files');
		global $wpdb;		
		$this->wpdb = $wpdb;
		$this->_pageView = 'none.php';
		$this->init();
	}
	
	protected function init(){
		return true;
	}
	
	/**
	 * Returns the Wpsqt_Page object for the page request. Allows other plugin
	 * developers to filter the possible directories where the page class can be
	 * located in using the 'wpsqt_page_file_locations' filter.
	 * 
	 * @param string $module Defined in Wpsqt_Admin::show_Page as $_GET['page']
	 * @param string|boolean $mainPage Defined in Wpsqt_Admin::show_page as $_GET['section']
	 * @param string|boolean $subPage Defined in Wpsqt_Admin::show_page as $_GET['subsection']
	 * @since 2.0
	 * @return Wpsqt_Core
	 */
	
	public static function getPage($module,$mainPage = FALSE,$subPage = false){
		
		$className = 'Wpsqt_Page_'.ucfirst($module);
		
		if ( !empty($mainPage) ){
			$className .= "_".ucfirst($mainPage);
		}
		
		if ( !empty($subPage) ){
			$className .= "_".ucfirst($subPage);
		}
		
		$objPage = Wpsqt_Core::getObject($className);
		
		return $objPage;
		
	} 
	
	/**
	 * The area where the class starts processing the
	 * the page request.
	 * 
	 * @since 2.0
	 */
	abstract function process();
	
	/**
	 * Handles displaying the page view. Firstly it 
	 * extracts the contents of $this->_pageVariables
	 * and then does a require_once on the return value 
	 * of Wpsqt_Core::pageView() using the content of
	 * $this->_pageView.
	 * 
	 * @since 2.0
	 */
	final public function display(){
		
		extract($this->_pageVars);
		require_once Wpsqt_Core::pageView($this->_pageView);
		return;
				
	}
	
	/**
	 * 
	 * 
	 * @param string $url
	 * @since 2.0
	 */
	final public function redirect( $url ){
		
		$this->_pageVars['redirectLocation'] = $url;
		$this->_pageView = "admin/misc/redirect.php";
		
		return;
	}
}
