<?php
require_once WPSQT_DIR.'lib/Wpsqt/Tokens.php';

/**
 * Handle sending the notification emails. 
 * 
 * @author Iain Cambridge
 * @copyright Fubra Limited 2010-2011, all rights reserved.
 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
 * @package WPSQT
 */
class Wpsqt_Mail {
	
	/**
	 * Sends the notification email to respondent
	 *
	 * @since 2.11.1
	 */
	private function _sendRespondentMail($address) {

		$quizName = $_SESSION['wpsqt']['current_id'];
		
		$objTokens = Wpsqt_Tokens::getTokenObject();
		$objTokens->setDefaultValues();

		$emailMessage = $_SESSION['wpsqt'][$quizName]['details']['email_template'];
		
		if ( empty($emailMessage) ){
			$emailMessage = get_option('wpsqt_email_template');
		}
		
		if ( empty($emailMessage) ){
			
			$emailMessage  = 'There is a new result to view'.PHP_EOL.PHP_EOL;
			$emailMessage .= 'Person Name : %USER_NAME%'.PHP_EOL;
			$emailMessage .= 'Result can be viewed at %RESULT_VIEW_URL%'.PHP_EOL;
			
		}
		
		$emailMessage = $objTokens->doReplacement($emailMessage);
									
		$quizDetails = $_SESSION['wpsqt'][$quizName]['details'];
		$emailTemplate = (empty($quizDetails['email_template'])) ? get_option('wpsqt_email_template'):$quizDetails['email_template'];
		$fromEmail = ( get_option('wpsqt_from_email') ) ?  get_option('wpsqt_from_email') : get_option('admin_email');

		$type = ucfirst($_SESSION['wpsqt'][$quizName]['details']['type']);
		$blogname = get_bloginfo('name');
		$emailSubject = $type.' Notification From '.$blogname;
		$headers = 'From: '.$blogname.' <'.$fromEmail.'>' . "\r\n";

		wp_mail($address,$emailSubject,$emailMessage,$headers);
	}

	/**
	 * Sends the notificatione mail.
	 * 
	 * @since 2.0
	 */
	public static function sendMail(){
	
		global $wpdb;
		
		$quizName = $_SESSION['wpsqt']['current_id'];
		
		$objTokens = Wpsqt_Tokens::getTokenObject();
		$objTokens->setDefaultValues();
		
		$emailMessage = $_SESSION['wpsqt'][$quizName]['details']['email_template'];
		
		if ( empty($emailMessage) ){
			$emailMessage = get_option('wpsqt_email_template');
		}
		
		if ( empty($emailMessage) ){
			
			$emailMessage  = 'There is a new result to view'.PHP_EOL.PHP_EOL;
			$emailMessage .= 'Person Name : %USER_NAME%'.PHP_EOL;
			$emailMessage .= 'IP Address : %IP_ADDRESS%'.PHP_EOL;
			$emailMessage .= 'Result can be viewed at %RESULT_URL%'.PHP_EOL;
			
		}
		
		$emailMessage = $objTokens->doReplacement($emailMessage);
									
		$quizDetails = $_SESSION['wpsqt'][$quizName]['details'];
		$emailTemplate = (empty($quizDetails['email_template'])) ? get_option('wpsqt_email_template'):$quizDetails['email_template'];
		$fromEmail = ( get_option('wpsqt_from_email') ) ?  get_option('wpsqt_from_email') : get_option('admin_email');
		
		$role = get_option('wpsqt_email_role');
		$personName = ( isset($_SESSION['wpsqt'][$quizName]['person']['user_name']) && !empty($_SESSION['wpsqt'][$quizName]['person']['user_name']) ) ? $_SESSION['wpsqt'][$quizName]['person']['user_name'] : 'Anonymous';
		
		if ( !empty($role) && $role != 'none' ){
			$this_role = "'[[:<:]]".$role."[[:>:]]'";
	  		$query = "SELECT * 
	  				  FROM ".$wpdb->users." 
	  				  WHERE ID = ANY 
	  				  	(
	  				  		SELECT user_id 
	  				  		FROM ".$wpdb->usermeta." 
	  				  		WHERE meta_key = 'wp_capabilities' 
	  				  			AND meta_value RLIKE ".$this_role."
						) 
	  				  ORDER BY user_nicename ASC LIMIT 10000";
	  		$users = $wpdb->get_results($query,ARRAY_A);
	  		$emailList = array();
	  		foreach($users as $user){
	  			$emailList[] = $user['user_email'];
	  		}
		}
		
		if ( isset($_SESSION['wpsqt'][$quizName]['details']['send_user']) 
		  && $_SESSION['wpsqt'][$quizName]['details']['send_user'] == "yes" && isset($_SESSION['wpsqt'][$quizName]['person']['email']) ) {
			self::_sendRespondentMail($_SESSION['wpsqt'][$quizName]['person']['email']);
		}
		
		if ( $_SESSION['wpsqt'][$quizName]['details']['notificaton_type'] == 'instant' ){
			$emailTrue = true;
		} elseif ( $_SESSION['wpsqt'][$quizName]['details']['notificaton_type'] == 'instant-100' 
					&& $percentRight == 100 ) {
			$emailTrue = true;	
		} elseif ( $_SESSION['wpsqt'][$quizName]['details']['notificaton_type'] == 'instant-75' 
					 && $percentRight > 75 ){
			$emailTrue = true;
		} elseif ( $_SESSION['wpsqt'][$quizName]['details']['notificaton_type'] == 'instant-50'  
					&& $percentRight > 50 ){
			$emailTrue = true;
		}
		
		if ( !isset($emailList) || empty($emailList) || $emailTrue === TRUE ){
			$emailAddress = get_option('wpsqt_contact_email');
			if ( !empty($_SESSION['wpsqt'][$quizName]['details']['notification_email'])  ){
				$emailList[] = $_SESSION['wpsqt'][$quizName]['details']['notification_email'];
			}
		}

		$type = ucfirst($_SESSION['wpsqt'][$quizName]['details']['type']);
		$blogname = get_bloginfo('name');
		$emailSubject = $type.' Notification From '.$blogname;
		$headers = 'From: '.$blogname.' <'.$fromEmail.'>' . "\r\n";
		if (isset($emailList) && is_array($emailList)) {
			foreach( $emailList  as $emailAddress ){
				wp_mail($emailAddress,$emailSubject,$emailMessage,$headers);
			}	
		}
	}
	
}
