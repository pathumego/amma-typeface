<?php
require_once WPSQT_DIR.'lib/Wpsqt/Form.php';
require_once WPSQT_DIR.'lib/Wpsqt/Tokens.php';

	/**
	 * Handles building the create/edit quiz form.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, All rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Form_Poll extends Wpsqt_Form {

	public function __construct( array $options = array() ){
		
		global $blog_id;
		
		if ( empty($options) ){
			$options = array('name' => false,
							'limit_one' => false,
							'limit_one_wp' => false,
							'limit_one_cookie' => false,
							'show_results_limited' => true,
							'finish_display' => false, 
							'status' => false, 
							'store_results' => 'yes',
							'finish_message' => false);
		} 
		
		$this->addOption("wpsqt_name", "Name", "text", $options['name'], "What you would like the poll to be called." )
			 ->addOption("wpsqt_limit_one", "Limit to one submission per IP","yesno", $options['limit_one'], "Limit the poll to one submission per IP.")
			 ->addOption("wpsqt_limit_one_wp", "Limit to one submission per WP user","yesno", $options['limit_one_wp'], "Limit the quiz to one submission per WP user. You must have the Use WP Details option below set to yes.")
			 ->addOption("wpsqt_limit_one_cookie", "Limit to one submission per computer (using cookies)", "yesno", $options['limit_one_cookie'], "Limit the quiz to one submission per computer/browser")
			 ->addOption("wpsqt_show_results_limited", "Show the results if the user has already taken the poll", "yesno", $options['show_results_limited'], "If limiting is enabled (by either method) do you want to show the results to the user if they have already taken the poll?")
			 ->addOption("wpsqt_finish_display", "Finish Display",'select', $options['finish_display'], "What should be displayed on the finishing of the poll.", array("Finish message","Poll results"))
			 ->addOption("wpsqt_status", "Status", "select", $options['status'], "Status of the poll either enabled where users can take it or disabled where users can't.", array('enabled','disabled'))
			 ->addOption("wpsqt_store_results", "Save Results", "yesno", $options['store_results'], "If the poll results should be saved.")
			 ->addOption("wpsqt_finish_message", "Finish Message", "textarea", $options['finish_message'], "The message to display when the user has successfully finished the poll. <strong>If empty the default one will be displayed.</strong> <a href=\"#template_tokens\">Click Here</a> to see the tokens that can be used.", array(), false);
		
		if ( array_key_exists('id', $options) ){
			$this->addOption("wpsqt_custom_directory", "Custom Directory Location", "static",  WPSQT_DIR."/pages/custom/".$blog_id."/quiz-".$options['id'] ,false,array(),false);		
		}

		$this->options = $options;

		apply_filters("wpsqt_form_poll",$this);

	}
	
}