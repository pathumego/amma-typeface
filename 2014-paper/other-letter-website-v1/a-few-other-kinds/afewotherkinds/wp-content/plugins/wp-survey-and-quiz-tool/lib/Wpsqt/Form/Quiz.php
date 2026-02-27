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

class Wpsqt_Form_Quiz extends Wpsqt_Form {

	public function __construct( array $options = array() ){
		
		global $blog_id;
		
		if ( empty($options) ){
			$options = array('name' => false,
							'notificaton_type' => false, 
							'limit_one' => false,
							'limit_one_wp' => false,
							'limit_one_cookie' => false,
							'save_resume' => false,
							'timer' => '0',
							'pass_mark' => '80', 
							'show_progress_bar' => false,
							'automark_whenfreetext' => 'no',
							'finish_display' => false, 
							'status' => false, 
							'contact' => false, 
							'use_wp' => false, 
							'email_template' => false, 
							'pdf_template' => false,
							'use_pdf' => 'yes',
							'store_results' => 'yes',
							'notification_email' => false,
							'send_user' => 'yes',
							'finish_message' => false,
							'pass_finish' => false,
							'pass_finish_message' => false,
							'fail_review' => false);
		}
		
		$this->addOption("wpsqt_name", "Name", "text", $options['name'], "What you would like the quiz to be called." )
			 ->addOption("wpsqt_limit_one", "Limit to one submission per IP","yesno", $options['limit_one'], "Limit the quiz to one submission per IP.")
			 ->addOption("wpsqt_limit_one_wp", "Limit to one submission per WP user","yesno", $options['limit_one_wp'], "Limit the quiz to one submission per WP user. You must have the Use WP Details option below set to yes.")
			 ->addOption("wpsqt_limit_one_cookie", "Limit to one submission per computer (using cookies)", "yesno", $options['limit_one_cookie'], "Limit the quiz to one submission per computer/browser")
			 ->addOption("wpsqt_save_resume", "Allow save/resume","yesno", $options['save_resume'], "Allow save and resume for this quiz?")
			 ->addOption("wpsqt_timer", "Timer value for the quiz","text", $options['timer'], "Enter the countdown timer value in minutes for the quiz. <b>Enter 0 for no timer</b>")
			 ->addOption("wpsqt_pass_mark", "Pass mark", "text", $options['pass_mark'], "What is the pass mark of this quiz (percentage)?")
			 ->addOption("wpsqt_show_progress_bar", "Show progress bar", "yesno", $options['show_progress_bar'], "Shows a progress bar based on which section the user is on")
			 ->addOption("wpsqt_automark_whenfreetxt", "Auto mark when freetext questions", "select", $options['automark_whenfreetext'], "If the quiz contains free text questions then this option will have the behaviour:<br /><strong>No</strong> - Do not attempt to mark the quiz<br /><strong>Yes - include</strong> - Mark all questions except and mark free texts as incorrect<br /><strong>Yes - exclude</strong> - Mark all questions except free text questions and ignore them from the total count.",array('no','yes - include freetext', 'yes - exclude freetext') )
			 ->addOption("wpsqt_finish_display", "Finish Display",'select', $options['finish_display'], "What should be displayed on the finishing of the quiz.", array("Finish message","Quiz Review","Both"))
			 ->addOption("wpsqt_status", "Status", "select", $options['status'], "Status of the quiz either enabled where users can take it or disabled where users can't.", array('enabled','disabled'))
			 ->addOption("wpsqt_send_user", "Send notification email to user as well", "yesno", $options["send_user"], "Should we send a notification email to the user who took the quiz. You must enable the 'use wordpress details' option below and the use must be logged in for this to work. This is due to a bug in the 'take contact details' option." )
			 ->addOption("wpsqt_contact", "Take contact details", "yesno", $options['contact'] ,"This will show a form for users to enter their contact details before proceeding.")
			 ->addOption("wpsqt_use_wp", "Use WordPress user details", "yesno", $options['use_wp'], "This will allow you to have the quiz to use the details of the user if they are signed in. If enabled the contact form will not be shown if enabled.")
			 ->addOption("wpsqt_notificaton_type", "Complete Notification", "select", $options['notificaton_type'] , "Send a notification email on of completion the quiz by a user.",array('none','instant','instant 100% correct','instant 75% correct','instant 50% correct') )
			 ->addOption("wpsqt_email_template", "Custom Email Template", "textarea", $options['email_template'], "The template of the email sent on notification. <strong>If empty the default one will be sent.</strong> <a href=\"#template_tokens\">Click Here</a> to see the tokens that can be used.", array(), false)
			 ->addOption("wpsqt_pdf_template", "PDF Template", "textarea", $options['pdf_template'], "The template for the PDF. <strong>If you're not using pdf certificates then leave blank.</strong> <a href=\"#template_tokens\">Click Here</a> to see the tokens that can be used.", array(), false)
			 ->addOption("wpsqt_use_pdf", "PDF Certificates","yesno", $options['use_pdf'], "Allow the user to download a PDF certificate.")
			 ->addOption("wpsqt_store_results", "Save Results", "yesno", $options['store_results'], "If the quiz results should be saved.")
			 ->addOption("wpsqt_notification_email", "Notification Email", "text", $options['notification_email'], "The email address which is to be notified when the quiz is completed. Emails can be seperated by a comma. <strong>Will override plugin wide option.</strong>", array(), false )
			 ->addOption("wpsqt_finish_message", "Finish Message", "textarea", $options['finish_message'], "The message to display when the user has successfully finished the quiz. <strong>If empty the default one will be displayed.</strong> <a href=\"#template_tokens\">Click Here</a> to see the tokens that can be used.", array(), false)
			 ->addOption("wpsqt_pass_finish", "Different finish message for pass", "yesno", $options['pass_finish'], "Display a different finish message if the user passes?")
			 ->addOption("wpsqt_pass_finish_message", "Finish message for pass", "textarea", $options['pass_finish_message'], "The message to display when the user has passed the quiz. <a href=\"#template_tokens\">Click Here</a> to see the tokens that can be used.", array(), false)
			 ->addOption("wpsqt_fail_review", "Quiz review on fail", "yesno", $options['fail_review'], "Do you want to show quiz review page if the taker fails?");
		
		if ( array_key_exists('id', $options) ){
			$this->addOption("wpsqt_custom_directory", "Custom Directory Location", "static",  WPSQT_DIR."/pages/custom/".$blog_id."/quiz-".$options['id'] ,false,array(),false);		
		}

		$this->options = $options;
		apply_filters("wpsqt_form_quiz",$this);

	}
	
}
