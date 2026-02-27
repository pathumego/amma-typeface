<?php

	/**
	 * Master class for exporting information. 
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
	 * @package WPSQT
	 */

abstract class Wpsqt_Export {


	/**
	 * The data to be exported.
	 * 
	 * @var array
	 * @since 2.0  
	 */
	protected $_data = array();

	
	/**
	 * Takes the input and puts it in $this->_data.
	 * 
	 * @param array $input The data to be exported.
	 * @since 2.0
	 */
	public function input( array $input ){
		$this->_data = $input;
		return $this;
	}
	
	/** 
	 * Returns the data in an export fashion.
	 * 
	 * @since 2.0
	 */
	abstract public function output();
	
	
	/**
	 * Returns the object based on $type.
	 * 
	 * @since 2.0
	 */
	public static function getObject($type){
		
		$className = "Wpsqt_Export_".ucfirst(strtolower($type));
		
		if ( !file_exists(WPSQT_DIR."lib/Wpsqt/Export/".ucfirst(strtolower($type)).".php") ) {
			wp_die("File doesn't exist");
		}	
		
		require_once(WPSQT_DIR."lib/Wpsqt/Export/".ucfirst(strtolower($type)).".php");
		
		if ( !class_exists($className) ) {
			wp_die($className." Class doesn't exist");	
		}
		
		return new $className;
		
	}	 	
		
}