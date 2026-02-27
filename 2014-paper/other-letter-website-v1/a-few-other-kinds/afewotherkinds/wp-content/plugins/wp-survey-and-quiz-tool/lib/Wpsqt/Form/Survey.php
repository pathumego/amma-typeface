<?php
require_once WPSQT_DIR.'lib/Wpsqt/Form.php';

	/**
	 * The create and edit form for surveys.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Form_Survey extends Wpsqt_Form {
	
	public function __construct( array $options = array() ){
		
		if ( empty($options) ){
			$options = array('name' => false,
							'notificaton_type' => false,
							'limit_one' => false,
							'limit_one_wp' => false,
							'limit_one_cookie' => false,
							'show_progress_bar' => false,
							'show_results_limited' => true,
							'status' => false,
							'finish_display' => false,
							'contact' => false,
							'use_wp' => false, 
							'notification_email' => false,
							'email_template' => false,
							'finish_message' => false);
		}
		
		$this->addOption("wpsqt_name", "Name", "text", $options['name'], "The name of the survey." )
			 ->addOption("wpsqt_status", "Status", "select", $options['status'], "If the survey is enabled or disabled.", array("enabled","disabled"))
			  ->addOption("wpsqt_finish_display", "Finish Display",'select', $options['finish_display'], "What should be displayed on the finishing of the quiz.", array("Default", "Custom finish message", "Results"))
			 ->addOption("wpsqt_limit_one", "Limit to one submission per IP","yesno", $options['limit_one'], "Limit the quiz to one submission per IP.")
			 ->addOption("wpsqt_limit_one_wp", "Limit to one submission per WP user","yesno", $options['limit_one_wp'], "Limit the quiz to one submission per WP user. You must have the Use WP Details option below set to yes.")
			 ->addOption("wpsqt_limit_one_cookie", "Limit to one submission per computer (using cookies)", "yesno", $options['limit_one_cookie'], "Limit the quiz to one submission per computer/browser")
			 ->addOption("wpsqt_show_progress_bar", "Show progress bar", "yesno", $options['show_progress_bar'], "Shows a progress bar based on which section the user is on")
			 ->addOption("wpsqt_show_results_limited", "Show the results if the user has already taken the survey", "yesno", $options['show_results_limited'], "If limiting is enabled (by either method) do you want to show the results to the user if they have already taken the survey?")
			 ->addOption("wpsqt_contact", "Take contact details", "yesno", $options['contact'] ,"This will show a form for users to enter their contact details before proceeding.")
			 ->addOption("wpsqt_notificaton_type", "Complete Notification", "select", $options['notificaton_type'] , "Send a notification email of completion.",array('none','instant') )
			 ->addOption("wpsqt_use_wp", "Use WordPress user details", "yesno", $options['use_wp'], "This will allow you to have the survey to use the details of the user if they are signed in. If enabled the contact form will not be shown if enabled.")
			 ->addOption("wpsqt_email_template", "Custom Email Template", "textarea", $options['email_template'], "The template of the email sent on notification. <strong>If empty the default one will be sent.</strong> <a href=\"#template_tokens\">Click Here</a> to see the tokens that can be used.", array(), false)
			 ->addOption("wpsqt_notification_email", "Notification Email", "text", $options['notification_email'], "The email address which is to be notified when the survey is completed. Emails can be seperated by a comma. <strong>Will override plugin wide option.</strong>", array(), false )
			 ->addOption("wpsqt_finish_message", "Finish Message", "textarea", $options['finish_message'], "The message to display when the user has successfully finished the quiz. <strong>If empty the default one will be displayed.</strong> <a href=\"#template_tokens\">Click Here</a> to see the tokens that can be used.", array(), false);
				
		$this->options = $options;
		apply_filters("wpsqt_form_survey",$this);
	}
	
}
