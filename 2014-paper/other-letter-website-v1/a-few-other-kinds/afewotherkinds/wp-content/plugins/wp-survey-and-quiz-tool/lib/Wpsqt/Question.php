<?php

	/**
	 * Master class for questions.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
	 * @package WP Survey And Quiz Tool
	 */

abstract class Wpsqt_Question {
	
	/**
     * Where the what objects have been called already is 
     * stored, currently on useful in the admin section.
     *
     * @var array
     * @since 2.0
	 */
	protected static $_called = array();
	
	/**
	 * Some sort of identifier for the object.
	 * 
	 * @var string
	 * @since 2.0
	 */
	protected static $_id;
	
	/**
	 * The absolute path to the page view for the form. Needs to 
	 * be set in the constructor.
	 * 
	 * @var String
	 * @since 2.0
	 */
	protected $_formView;
	
	/**
	 * The absolute path to the page view for the display. Needs
	 * to be set in the constructor.
	 *
	 * @var string
	 * @since 2.0
	 */
	protected $_displayView;
	
	/**
	 * The variable information relating the to current question.
	 * @var array
	 * @since 2.0
	 */
	protected $_questionVars = array();
	
	/**
	 * 
	 * Enter description here ...
	 * @var unknown_type
	 */
	protected static $_displayViews = array();
		
	/**
	 * To set the $this->_formView and collect the data required 
	 * for the question type.
	 * 
	 * @since 2.0
	 */
	abstract public function __construct( array $values = array() );
	
	/**
	 * Process the data to set the values for the form.
     *
	 * @param array $input the data for the question.
	 * @since 2.0
	 */
	 public function processValues( array $input ){
	 	$this->_questionVars = $input;
	 	return $this;
	 }
	
	/**
	 * Returns the content of the form.
	 * 
	 * @param string $form The absolute path of the form view file. 
	 * @since 2.0
	 */
	public function form( ){
		 
		if ( empty($this->_formView) ){
			return "Someone has dun goof'd! No question form view!";
		}
		if ( !isset(self::$_called[$this->_id]) ){
			ob_start();
			extract($this->_questionVars);
			require $this->_formView;
			self::$_called[$this->_id] = true;
			return ob_get_clean();
		}
		
		return null;
	} 
	
	/**
	 * Handles processing the form to see if the fields are present 
	 * and then process them to return an associative array an item 
	 * with the key "errors" which will be merged with the error 
	 * messages for the page and item with the key "content" and 
	 * an item with the key "name" which is the name of the key
	 * in questions it will assume.
	 *  
	 * @param array $postData
	 * @since 2.0
	 */
	public function processForm($postData){
		return false;
	}
	
	
	/**
	 * Displays the question for use.
	 * 
	 * @since 2.0
	 */
	public static function getDisplayView( $questionData ){
		
		if ( !isset(self::$_displayViews[$questionData["type"]]) ){
			$objQuestion = self::getObject($questionData["type"]);
			self::$_displayViews[$questionData["type"]] = $objQuestion->getView();
		}
		
		
		return self::$_displayViews[$questionData["type"]];
		
	}
	
	public function getView(){
		return $this->_displayView;
	}
	
	/**
	 * Returns the question object.
	 * 
	 * @todo look into my possible over use of the factory pattern.
	 * @param string $type
	 * @since 2.0
	 */
	public static function getObject($type){

		return Wpsqt_Core::getObject("Wpsqt_Question_".ucfirst(str_replace(" ", "",strtolower($type))));
	
	}
	
}