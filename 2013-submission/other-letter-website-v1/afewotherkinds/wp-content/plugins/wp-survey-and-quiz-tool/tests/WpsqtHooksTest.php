<?php 

	/**
	 * Tests to ensure all the hooks are in place.
	 *  
	 * @author Iain Cambridge
	 * @license GPL v2
	 * @copyright Fubra Limited 2011 (c)
	 * @since 2.0
	 */

class WpsqtHooksTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * Checks to see if the menu is properly assembled.
	 */
	
	public function testMenuIsset(){
		
		global $menu, $submenu;		
		
		// Check to see if the menu item exists
		
		$pass = false;
		foreach( $menu as $menuItem ){
			if ( $menuItem[0] == "WPSQT" && $menuItem[2] == "wpsqt-menu" ){
				$pass = true;
			} 			
		}
		$this->assertTrue($pass, "Menu item doesn't exist");
		
		// Check to see if the sub menu exists
		// and that it contains all the elements
		// it's meant to contain.
		
		$this->assertContains("wpsqt-menu", array_keys($submenu), "Submenu array doesn't exist");
		
		$this->assertEquals( 
						array( 
						  array(
						  	"WPSQT","manage_options","wpsqt-menu",
						  	"WPSQT","menu-top toplevel_page_wpsqt-menu",
						    "toplevel_page_wpsqt-menu","http://iain.fubradev.vc.catn.com/wp-admin/images/generic.png"
						  ),
						  array(
						  	"Options","manage_options","wpsqt-menu-options","Options"
						  ),
						  array(
						  	"Maintenance","manage_options","wpsqt-menu-maintenance","Maintenance"
						  ),
						  array(
						  	"Contact","manage_options","wpsqt-menu-contact","Contact"
						  ),
						  array(
						  	"Help","manage_options","wpsqt-menu-help","Help"
						  ),
						  array(
						  	"CatN","manage_options","wpsqt-menu-catn","CatN PHP Experts"
						  )
						),
						$submenu["wpsqt-menu"],
						"Sub Menu isn't what expected"
					);
							
	}
	 
	/**
	 * Checks to see if the the action and filter hooks are in place.
	 * 
	 * @uses _hookCheck
	 */	
	public function testAreActionAndFilterHooksInPlace(){
		
		// Check for init actions and filters first
		
		// Wpsqt_Core hooks
		$this->_hookCheck('init', 10, 'Wpsqt_Core', 'create_nonce');
		$this->_hookCheck('init', 10, 'Wpsqt_Core', 'filter');
		$this->_hookCheck('wp_footer', 10, 'Wpsqt_Core', 'show_footer');
		
		// Wpsqt_Admin hooks
		$this->_hookCheck('admin_init', 10, 'Wpsqt_Admin', 'enqueue_files');
		$this->_hookCheck('admin_init', 10, 'Wpsqt_Admin', 'adminFilter');
		$this->_hookCheck('admin_menu', 10, 'Wpsqt_Admin', 'admin_menu');
		
	}

	/**
	 * Checks to see if the 
	 */
	public function testShortcodesAreHooked(){
		
		$this->_checkShortcode('wpsqt_quiz', 'Wpsqt_Core', 'shortcode_quiz');
		$this->_checkShortcode('wpsqt_survey', 'Wpsqt_Core', 'shortcode_survey');
		
	}
	
	public function testEnqueueScripts(){
		
		$this->_checkEnqueuedFile('script', 'wpsqt-generic', plugins_url('/js/generic.js',WPSQT_FILE) );
		$this->_checkEnqueuedFile('style', 'wpsqt-print', plugins_url('/css/print.css',WPSQT_FILE) );
		
	}
	
	/**
	 * Checks to see if $hookName key exists in the $wp_filter array,
	 * then ensures it's not empty and that it is an array. At which point
	 * it does the same checks $priority is a key in the $hookName array.
	 *  
	 * @param string $hookName the name of the hook to be checked.
	 * @param integer $priority the priority of the action.
	 * @param string $className the name of the class that is action is in.
	 * @param string $methodName the name of the method for the action.
	 */
	protected function _hookCheck($hookName,$priority,$className,$methodName){
		
		global $wp_filter;
		
		$this->assertTrue(array_key_exists($hookName,$wp_filter),"'".$hookName."' action doesn't seem to exist.");
		$this->assertFalse(empty($wp_filter[$hookName]),"'".$hookName."' action appears to be empty.");
		$this->assertTrue(is_array($wp_filter[$hookName]), "'".$hookName."' action isn't an array as expected.");
		$this->assertTrue(array_key_exists($priority, $wp_filter[$hookName]), "The priority ".$priority." doesn't appear to exist for action '".$hookName."'.");	
		$this->assertFalse(empty($wp_filter[$hookName][$priority]),"The priority ".$priority." for action '".$hookName."' appears to be empty.");
		$this->assertTrue(is_array($wp_filter[$hookName][$priority]),"The priority ".$priority." for action '".$hookName."' doesn't appear to be an array." );
		$foundHook = false;
		foreach ( $wp_filter[$hookName][$priority] as $hook ){
			if ( is_array($hook['function']) ){
				if ( is_a($hook['function'][0],$className) && $hook['function'][1] == $methodName ){
					$foundHook = true;			
				}
			}			
		}		
		$this->assertTrue($foundHook,"Unable to find hook for ".$className."::".$methodName." in the 'init' action.");
	
	}

	/**
	 * Checks to see if a shortcode has been added. Firstly
	 * checks that the key for the shortcode exists. Then 
	 * verifies that the shortcode is an array, then checks
	 * that the callback object is a $className object and 
	 * that the callback method is $methodName.
	 * 
	 * @param string $tagName The name of the shortcode.
	 * @param string $className The name of the class that the callback object should be an implemention of.
	 * @param string $methodName The name of the callback method.
	 */
	
	protected function _checkShortcode( $tagName,$className,$methodName ){
		
		global $shortcode_tags;
		
		$this->assertTrue(array_key_exists($tagName,$shortcode_tags),"Shortcode '".$tagName."' key doesn't appear to exist");
		$this->assertFalse(empty($shortcode_tags[$tagName]),"Shortcode callback for '".$tagName."' appears to be empty");	
		$this->assertTrue(is_array($shortcode_tags[$tagName]),"The shortcode callback for '".$tagName."' isn't an array as expected.");
		$this->assertTrue(is_a($shortcode_tags[$tagName][0],$className),"The callback object for '".$tagName."' isn't a '".$className."' object");
		$this->assertEquals($methodName,$shortcode_tags[$tagName][1],"The callback method for '".$tagName."' isn't '".$methodName."'");
		
	}
	
	
	/**
	 * Checks to see if the script|styles has been enqueued
	 * it starts off to see if the key exists in the registered
	 * array of either $wp_scripts|$wp_styles. Then ensures that
	 * it isn't empty and is _WP_Dependency. Then checks the
	 * arguments of the function againist the members of the 
	 * the object.
	 * 
	 * @param string $type
	 * @param string $name
	 * @param string $src
	 * @param array $deps
	 * @param boolean|string $ver
	 * @param null|array $args
	 * @param array $extra
	 */
	
	protected function _checkEnqueuedFile ( $type, $name, $src , $deps = false , $ver = false, $args = false, $extra = false  ){
		
		global $wp_scripts,$wp_styles;
		
		$file =  ( $type == "script" ) ? $wp_scripts : $wp_styles ;
		
		$this->assertTrue(array_key_exists($name, $file->registered), "The script '".$name."' doesn't appear to be enqueued.");
		$this->assertFalse(empty($file->registered[$name]), "Seems the enqueued script '".$name."' is empty.");
		$this->assertTrue(is_a($file->registered[$name],"_WP_Dependency"), "The object for the enqueued script '".$name."' isn't a _WP_Dependency as expected." );
		$this->assertEquals($src,$file->registered[$name]->src, "The source file for '".$name."' isn't what was expected '".$src."'");
		
		if ( $deps !== false ){
			$this->assertEquals($deps,$file->registered[$name]->deps, "The dependcies for '".$name."' isn't what was expected." );
		}
		if ( $ver !== false ){
			$this->assertEquals($ver,$file->registered[$name]->ver, "The verison for '".$name."' isn't what was expected");
		}
		if ( $args !== false ){
			$this->assertEquals($args,$file->registered[$name]->args, "The arguments for '".$name."' isn't what was expected.");
		}
		if ( $extra !== false ){
			$this->assertEquals($extra,$file->registered[$name]->extra, "The extra info for '".$name."' isn't what was expected." );
		}
		
	}
}