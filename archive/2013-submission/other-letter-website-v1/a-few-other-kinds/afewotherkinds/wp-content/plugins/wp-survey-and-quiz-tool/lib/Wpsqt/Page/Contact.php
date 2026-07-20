<?php

	/**
	 * Handles the contacting Fubra with complaints, 
	 * questions and what not.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Contact extends Wpsqt_Page {
		
		
		public function process(){

			if (  $_SERVER["REQUEST_METHOD"] == "POST" ){
			global $wp_version;
			
				$errorArray = array();
				if ( !isset($_POST['email']) || empty($_POST['email'])){
					$errorArray[] = 'Email is required';
				} elseif ( !is_email($_POST['email']) ){
					$errorArray[] = 'Invalid from email';
				}
				
				if ( !isset($_POST['name']) || empty($_POST['name']) ){
					$errorArray[] = 'Name is required';
				}
				
				if ( !isset($_POST['message']) || empty($_POST['message']) ){
					$errorArray[] = 'Message is required';
				}
				
				if ( !isset($_POST['reason']) || empty($_POST['reason']) ){
					$errorArray[] = 'Reason is required';
					// Tho this should never be blank or empty!
				} elseif ( $_POST['reason'] != "Bug" && $_POST['reason'] != 'Suggestion' 
				 		&& $_POST['reason'] != 'You guys rock!' && $_POST['reason'] != 'You guys are the suck!'
				 		&& $_POST['reason'] != 'Moving to CatN') {
					$errorArray[] = 'Invalid reason';
					// Definetly something a miss here
				}
				
				if ( empty($errorArray) ){
					$fromEmail = ( get_option('wpsqt_from_email') ) ? get_option('wpsqt_from_email') : get_option('admin_email');
					
		   			$headers  = 'From: WPSQT Contact Form'. PHP_EOL;
		   			$headers .= 'Reply-To: '.trim($_POST['name']).' <'.$_POST['email'].'>'.PHP_EOL;
		   			$message  = 'From: '.trim($_POST['name']).' <'.$fromEmail.'>'.PHP_EOL;
		   			$message .= 'WPSQT Version: '.WPSQT_VERSION.PHP_EOL;
		   			$message .= 'PHP Version: '.PHP_VERSION.PHP_EOL;
		   			$message .= 'WordPress Version: '.$wp_version.PHP_EOL;
		   			$message .= 'Message: '.esc_html(wp_kses_stripslashes($_POST['message'])).PHP_EOL;
		   			   			
					if ( !wp_mail(WPSQT_CONTACT_EMAIL, 'WPSQT : '.stripslashes($_POST['reason']), $message, $headers) ){
						$errorArray[] = 'Unable to send email, please check wordpress settings';
					} else {
						$successMessage = 'Email sent! Thank you for reponse';
					}		
					
				}
			
			}
			
			$this->_pageView = "admin/misc/contact.php";
				
		}	
		
		
}