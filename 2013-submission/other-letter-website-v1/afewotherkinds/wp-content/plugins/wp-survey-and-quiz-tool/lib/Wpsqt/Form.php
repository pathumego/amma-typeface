<?php 

	/**
	 * Allows for the easy creation of admin forms.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011 (C) All rights reserved.
	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
	 * @package WP Survey And Quiz Tool
	 */

class Wpsqt_Form {
	/**
	 * The options of the child class
	 * 
	 * @var array
	 * @since 2.0
	 */
	public $options;
	
	/**
	 * Array full of the options for the form in question.
	 * 
	 * @var array
	 * @since 2.0
	 */
	private $_options = array();
	
	/**
	 * Allows the adding of options.
	 * 
	 * @param string $name
	 * @param string $displayName
	 * @param string $type
	 * @param string $value
	 * @param string $helpMessage
	 * @param array $args
	 * @since 2.0
	 */
	public function addOption($name,$displayName,$type,$value = false,$helpMessage = false, $args = array(), $required = true){
		
		$this->_options[$name] = array('type' => $type,'display' => $displayName,'value' => $value,'help' => $helpMessage, 'args' =>$args, "required" => $required );
		
		return $this;
		
	}
	
	/**
	 * Gets the error messages and checks that the 
	 * responses are valid.
	 * 
	 * @param array $options
	 * @since 2.0
	 */
	public function getMessages(array $input){

		$errorMessages = array();
		foreach( $this->_options as $name => $option ){
						
			if ( $option['required'] == true && (!isset($input[$name]) || $input[$name] == "") ){
				$errorMessages[] = $option['display']." can't be empty.";
				continue;	
			} 
						
			if ( $option['type'] == "yesno" ){				
				if ( $input[$name] != "yes" && $input[$name] != "no" ){
					$errorMessages[] = $option['display']." has to be yes or no.";
				}				
			} elseif ( $option['type'] == "select" ){				
				if ( !in_array($input[$name], $option['args'] ) ){
					$errorMessages[] = $option['display']." doesn't have a valid response.";
				}				
			}				
		}
		
		return $errorMessages;
		
	}
	
	
	/**
	 * Easy way to set multiple option values 
	 * in one go. Loops through the array using
	 * the key as the key for the option and the
	 * value for the value.
	 * 
	 * @param array $values
	 * @since 2.0
	 */
	public function setValues(array $values){
		
		foreach( $values as $name => $value ){
			if ( array_key_exists($name, $this->_options) ){
				$this->_options[$name]['value'] = $value;
			}
		}
		
	}
	
	/**
	 * Sets a value for a single item.
	 * 
	 * @param string $name The key of the option in the options array.
	 * @param string $value The new value of the option.
	 * @since 2.0
	 */
	public function setValue($name,$value){
		$this->_options[$name]['value'] = $value;
	}
	
	/**
	 * Builds the form and returns the content in
	 * HTML.	 
	 * 
	 * @return string $content The html for the form.
	 * @since 2.0
	 */
	final public function getForm(){
		
		$options = $this->_options;
		ob_start();
		include Wpsqt_Core::pageView('admin/misc/form.php');
		$content = ob_get_clean();
		
		return $content;
	}
	
	/**
	 * Echos out the return value of $this->getForm();
	 * 
	 * @since 2.0
	 */
	final public function display(){
		
		echo $this->getForm();
		
	}
	
	/**
	 * Goes through the array and returns all the wpsqt options 
	 * without wpsqt_ at the start of the key. 
	 *
	 * @param array $input
	 * @since 2.0
	 */
	
	public static function getSavableArray( array $input ){
		
		$output = array();
		foreach( $input as $name => $value ){
			if (preg_match("~^wpsqt_(.*)$~iU",$name,$match)){
				if ( is_string($value) ){
					$value = stripslashes($value);
				}
				$output[$match[1]] = $value;						
			}
		}
		
		return $output;
	}
	
	/**
	 * Returns the array with wpsqt_ added to each key. 
	 *
	 * @param array $input
	 * @todo look at improving the whole setup here.
	 */
	public static function getInsertableArray ( array $input ){
		
		$output = array();
		foreach ( $input as $name => $value ){
			if ( is_string($value) ){
				$value = stripslashes($value);
			}
			$output['wpsqt_'.$name] = $value;
		}
		return $output;		
	}
	
}
