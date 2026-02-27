<?php
require WPSQT_DIR.'lib/Wpsqt/Form.php';
require WPSQT_DIR.'lib/Wpsqt/Form/Quiz.php';

	/**
	 * Test the Wpsqt_Form functionality, building forms aswell as
	 * checking the validation of input.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, copyright all rights reserved.
 	 * @license GPL v2
	 */

class WpsqtFormTest extends PHPUnit_Framework_TestCase {

	/**
	 * Checks to see if the forms are building text input
	 * properly.
	 */
	public function testFormTextBuildingWithNoValue(){
		
		$objForm = new Wpsqt_Form();
		
		$objForm->addOption("wpsqt_test","Test","text",false,"None");
		
		$lines = explode("\n",$objForm->getForm());
		foreach($lines as &$line){
			$line = trim($line);
		}		
		$formOneLine = implode("",$lines);
		
		$expectedForm = '<table class="form-table" id="question_form">';
		$expectedForm .= '<tbody><tr>';
		$expectedForm .= '<th scope="row">Test</th>';
		$expectedForm .= '<td valign="top">';
		$expectedForm .= '<input id="wpsqt_test" maxlength="255" size="50" name="wpsqt_test" value="" />';
		$expectedForm .= '</td>';
		$expectedForm .= '<td>None</td>';
		$expectedForm .= '</tr></tbody>';
		$expectedForm .= '</table>';
		$this->assertEquals($expectedForm,$formOneLine,"Form doesn't match up");
		
	}
	
	/**
	 * Checks to see if the forms are building text input
	 * properly.
	 */
	public function testFormTextBuildingWithValueTest(){
		
		$objForm = new Wpsqt_Form();
		
		$objForm->addOption("wpsqt_test","Test","text","test","None");
		
		$lines = explode("\n",$objForm->getForm());
		foreach($lines as &$line){
			$line = trim($line);
		}		
		$formOneLine = implode("",$lines);
		
		$expectedForm = '<table class="form-table" id="question_form">';
		$expectedForm .= '<tbody><tr>';
		$expectedForm .= '<th scope="row">Test</th>';
		$expectedForm .= '<td valign="top">';
		$expectedForm .= '<input id="wpsqt_test" maxlength="255" size="50" name="wpsqt_test" value="test" />';
		$expectedForm .= '</td>';
		$expectedForm .= '<td>None</td>';
		$expectedForm .= '</tr></tbody>';
		$expectedForm .= '</table>';
		$this->assertEquals($expectedForm,$formOneLine,"Form doesn't match up");
		
	}

	/**
	 * Checks to see if the forms are building yes or no
	 * properly.
	 */
	public function testFormYesnoBuildingWithNoValue(){
		
		$objForm = new Wpsqt_Form();
		
		$objForm->addOption("wpsqt_test","Test","yesno",false,"None");
		
		$lines = explode("\n",$objForm->getForm());
		foreach($lines as &$line){
			$line = trim($line);
		}		
		$formOneLine = implode("",$lines);

		$expectedForm  = '<table class="form-table" id="question_form">';
		$expectedForm .= '<tbody><tr>';
		$expectedForm .= '<th scope="row">Test</th>';
		$expectedForm .= '<td valign="top">';
		$expectedForm .= '<input type="radio" name="wpsqt_test" value="no"  checked="checked" id="wpsqt_test_no" />';
		$expectedForm .= '<label for="wpsqt_test_no">No</label>';
		$expectedForm .= '<input type="radio" name="wpsqt_test" value="yes"  id="wpsqt_test_yes" />';
		$expectedForm .= '<label for="wpsqt_test_yes">Yes</label>';
		$expectedForm .= '</td>';
		$expectedForm .= '<td>None</td>';
		$expectedForm .= '</tr></tbody>';
		$expectedForm .= '</table>';
		$this->assertEquals($expectedForm,$formOneLine,"Form doesn't match up");
		
	}

	/**
	 * Checks to see if the forms are building textarea
	 * properly.
	 */
	public function testFormTextareaBuildingWithNoValue(){
		
		$objForm = new Wpsqt_Form();
		
		$objForm->addOption("wpsqt_test","Test","textarea",false,"None");
		
		$lines = explode("\n",$objForm->getForm());
		foreach($lines as &$line){
			$line = trim($line);
		}		
		$formOneLine = implode("",$lines);

		$expectedForm  = '<table class="form-table" id="question_form">';
		$expectedForm .= '<tbody><tr>';
		$expectedForm .= '<th scope="row">Test</th>';
		$expectedForm .= '<td valign="top">';
		$expectedForm .= '<textarea name="wpsqt_test" rows="8" cols="40"></textarea>';
		$expectedForm .= '</td>';
		$expectedForm .= '<td>None</td>';
		$expectedForm .= '</tr></tbody>';
		$expectedForm .= '</table>';
		$this->assertEquals($expectedForm,$formOneLine,"Form doesn't match up");
		
	}
	
	/**
	 * Checks to see if the forms are building select
	 * properly.
	 */
	public function testFormTextareaBuildingWithValueTest(){
		
		$objForm = new Wpsqt_Form();
		
		$objForm->addOption("wpsqt_test","Test","textarea","test","None");
		
		$lines = explode("\n",$objForm->getForm());
		foreach($lines as &$line){
			$line = trim($line);
		}		
		$formOneLine = implode("",$lines);

		$expectedForm  = '<table class="form-table" id="question_form">';
		$expectedForm .= '<tbody><tr>';
		$expectedForm .= '<th scope="row">Test</th>';
		$expectedForm .= '<td valign="top">';
		$expectedForm .= '<textarea name="wpsqt_test" rows="8" cols="40">test</textarea>';
		$expectedForm .= '</td>';
		$expectedForm .= '<td>None</td>';
		$expectedForm .= '</tr></tbody>';
		$expectedForm .= '</table>';
		$this->assertEquals($expectedForm,$formOneLine,"Form doesn't match up");
		
	}
	
	/**
	 * Checks to see if the forms are building select
	 * properly.
	 */
	public function testFormSelectBuildingWithNoValue(){
		
		$objForm = new Wpsqt_Form();
		
		$objForm->addOption("wpsqt_test","Test","select",false,"None",array('Test One','Test Two'));
		
		$lines = explode("\n",$objForm->getForm());
		foreach($lines as &$line){
			$line = trim($line);
		}		
		$formOneLine = implode("",$lines);

		$expectedForm  = '<table class="form-table" id="question_form">';
		$expectedForm .= '<tbody><tr>';
		$expectedForm .= '<th scope="row">Test</th>';
		$expectedForm .= '<td valign="top">';
		$expectedForm .= '<select id="wpsqt_test" name="wpsqt_test">';
		$expectedForm .= '<option value="Test One">Test One</option>';
		$expectedForm .= '<option value="Test Two">Test Two</option>';
		$expectedForm .= '</select>';
		$expectedForm .= '</td>';
		$expectedForm .= '<td>None</td>';
		$expectedForm .= '</tr></tbody>';
		$expectedForm .= '</table>';
		$this->assertEquals($expectedForm,$formOneLine,"Form doesn't match up");
		
	}
	
	/**
	 * Checks to see if the forms are building select
	 * properly.
	 */
	public function testFormSelectBuildingWithValue(){
		
		$objForm = new Wpsqt_Form();
		
		$objForm->addOption("wpsqt_test","Test","select",'Test One',"None",array('Test One','Test Two'));
		
		$lines = explode("\n",$objForm->getForm());
		foreach($lines as &$line){
			$line = trim($line);
		}		
		$formOneLine = implode("",$lines);

		$expectedForm  = '<table class="form-table" id="question_form">';
		$expectedForm .= '<tbody><tr>';
		$expectedForm .= '<th scope="row">Test</th>';
		$expectedForm .= '<td valign="top">';
		$expectedForm .= '<select id="wpsqt_test" name="wpsqt_test">';
		$expectedForm .= '<option value="Test One" selected="selected">Test One</option>';
		$expectedForm .= '<option value="Test Two">Test Two</option>';
		$expectedForm .= '</select>';
		$expectedForm .= '</td>';
		$expectedForm .= '<td>None</td>';
		$expectedForm .= '</tr></tbody>';
		$expectedForm .= '</table>';
		$this->assertEquals($expectedForm,$formOneLine,"Form doesn't match up");
		
	}

	/**
	 * Checks to see if the forms are building yes or no
	 * properly.
	 */
	public function testFormYesnoBuildingWithValueNo(){
		
		$objForm = new Wpsqt_Form();
		
		$objForm->addOption("wpsqt_test","Test","yesno","no","None");
		
		$lines = explode("\n",$objForm->getForm());
		foreach($lines as &$line){
			$line = trim($line);
		}		
		$formOneLine = implode("",$lines);

		$expectedForm  = '<table class="form-table" id="question_form">';
		$expectedForm .= '<tbody><tr>';
		$expectedForm .= '<th scope="row">Test</th>';
		$expectedForm .= '<td valign="top">';
		$expectedForm .= '<input type="radio" name="wpsqt_test" value="no"  checked="checked" id="wpsqt_test_no" />';
		$expectedForm .= '<label for="wpsqt_test_no">No</label>';
		$expectedForm .= '<input type="radio" name="wpsqt_test" value="yes"  id="wpsqt_test_yes" />';
		$expectedForm .= '<label for="wpsqt_test_yes">Yes</label>';
		$expectedForm .= '</td>';
		$expectedForm .= '<td>None</td>';
		$expectedForm .= '</tr></tbody>';
		$expectedForm .= '</table>';
		$this->assertEquals($expectedForm,$formOneLine,"Form doesn't match up");
		
	}
	
	/**
	 * Checks to see if the forms are building yes or no
	 * properly.
	 */
	public function testFormYesnoBuildingWithValueYes(){
		
		$objForm = new Wpsqt_Form();
		
		$objForm->addOption("wpsqt_test","Test","yesno","yes","None");
		
		$lines = explode("\n",$objForm->getForm());
		foreach($lines as &$line){
			$line = trim($line);
		}		
		$formOneLine = implode("",$lines);

		$expectedForm  = '<table class="form-table" id="question_form">';
		$expectedForm .= '<tbody><tr>';
		$expectedForm .= '<th scope="row">Test</th>';
		$expectedForm .= '<td valign="top">';
		$expectedForm .= '<input type="radio" name="wpsqt_test" value="no"  id="wpsqt_test_no" />';
		$expectedForm .= '<label for="wpsqt_test_no">No</label>';
		$expectedForm .= '<input type="radio" name="wpsqt_test" value="yes"  checked="checked" id="wpsqt_test_yes" />';
		$expectedForm .= '<label for="wpsqt_test_yes">Yes</label>';
		$expectedForm .= '</td>';
		$expectedForm .= '<td>None</td>';
		$expectedForm .= '</tr></tbody>';
		$expectedForm .= '</table>';
		$this->assertEquals($expectedForm,$formOneLine,"Form doesn't match up");
		
	}
	
	/**
	 * Checks to see the proper error message is returned
	 * for a yesno option with no input given.
	 * 
	 * @since 2.0
	 */
	public function testFormYesnoValidation(){
		
		
		$objForm = new Wpsqt_Form();		
		$objForm->addOption("wpsqt_test","Test","yesno","yes","None");
		
		$errorMessages = $objForm->getMessages(array());		
		$this->assertEquals(array("Test can't be empty."), $errorMessages , "Invalid error message given for empty value." );

		$errorMessages = $objForm->getMessages(array("wpsqt_test" => "none"));
		$this->assertEquals(array("Test has to be yes or no."), $errorMessages, "Invalid error message given for invalid response");
		
		$errorMessages = $objForm->getMessages(array("wpsqt_test" => "yes"));
		$this->assertTrue(empty($errorMessages), "Error message given for valid response.");
		
	}
	
	/**
	 * Check to make sure the form select elements
	 * are validating properly.
	 * 
	 * @since 2.0
	 */
	public function testFormSelectValidation(){
		
		$objForm = new Wpsqt_Form();
		$objForm->addOption("wpsqt_test","Test","select",false,"None",array("one","two","three"));
		
		$errorMessages = $objForm->getMessages(array());		
		$this->assertEquals(array("Test can't be empty."), $errorMessages , "Invalid error message given for no value." );
		
		$errorMessages = $objForm->getMessages(array("wpsqt_test" => ""));		
		$this->assertEquals(array("Test can't be empty."), $errorMessages , "Invalid error message given for empty value." );
		
		$errorMessages = $objForm->getMessages(array("wpsqt_test" => "none"));		
		$this->assertEquals(array("Test doesn't have a valid response."), $errorMessages , "Invalid error message given for invalid response." );
		
		
	}
	
	/**
	 * Check on Wpsqt_Form_Quiz to make sure all is
	 * well.
	 * 
	 * @since 2.0
	 */
	
	public function testQuizFormOutput(){
		
		$objForm = new Wpsqt_Form_Quiz();
		
		$lines = explode("\n",$objForm->getForm());
		foreach($lines as &$line){
			$line = trim($line);
		}		
		$formOneLine = implode("",$lines);
		
		$expectedForm  = '<table class="form-table" id="question_form">';
		$expectedForm .= '<tbody>';
		$expectedForm .= '<tr><th scope="row">Name</th>';
		$expectedForm .= '<td valign="top">';
		$expectedForm .= '<input id="wpsqt_name" maxlength="255" size="50" name="wpsqt_name" value="" />';
		$expectedForm .= '</td>';
		$expectedForm .= '<td>What you would like the quiz to be called.</td>';
		$expectedForm .= '</tr><tr>';
		$expectedForm .= '<th scope="row">Complete Notification</th>';
		$expectedForm .= '<td valign="top">';
		$expectedForm .= '<select id="wpsqt_notificaton_type" name="wpsqt_notificaton_type">';
		$expectedForm .= '<option value="none">none</option>';
		$expectedForm .= '<option value="instant">instant</option>';
		$expectedForm .= '<option value="instant 100%">instant 100%</option>';
		$expectedForm .= '<option value="instant 75%">instant 75%</option>';
		$expectedForm .= '<option value="instant 50%">instant 50%</option>';
		$expectedForm .= '</select>';
		$expectedForm .= '</td>';
		$expectedForm .= '<td>Send a notification email of completion.</td>';
		$expectedForm .= '</tr><tr>';
		$expectedForm .= '<th scope="row">Limit to one submission</th>';
		$expectedForm .= '<td valign="top">';
		$expectedForm .= '<input type="radio" name="wpsqt_limit_one" value="no"  checked="checked" id="wpsqt_limit_one_no" /><label for="wpsqt_limit_one_no">No</label>';
		$expectedForm .= '<input type="radio" name="wpsqt_limit_one" value="yes"  id="wpsqt_limit_one_yes" /><label for="wpsqt_limit_one_yes">Yes</label>';
		$expectedForm .= '</td>';
		$expectedForm .= '<td>Limit the quiz to one submission per IP</td>';
		$expectedForm .= '</tr>';
		$expectedForm .= '<tr>';
		$expectedForm .= '<th scope="row">Finish Display</th>';
		$expectedForm .= '<td valign="top"><select id="wpsqt_finish_display" name="wpsqt_finish_display">';
		$expectedForm .= '<option value="Finish message">Finish message</option>';
		$expectedForm .= '<option value="Quiz Review">Quiz Review</option>';
		$expectedForm .= '</select>';
		$expectedForm .= '</td>';
		$expectedForm .= '<td>What should be displayed on the finishing of the quiz</td>';
		$expectedForm .= '</tr><tr>';
		$expectedForm .= '<th scope="row">Status</th><td valign="top">';
		$expectedForm .= '<select id="wpsqt_status" name="wpsqt_status">';
		$expectedForm .= '<option value="enabled">enabled</option>';
		$expectedForm .= '<option value="disabled">disabled</option>';
		$expectedForm .= '</select></td>';
		$expectedForm .= '<td>Status of the quiz ethier enabled where users can take it or disabled where users can\'t.</td>';
		$expectedForm .= '</tr><tr><th scope="row">Take contact details</th>';
		$expectedForm .= '<td valign="top">';
		$expectedForm .= '<input type="radio" name="wpsqt_contact" value="no"  checked="checked" id="wpsqt_contact_no" />';
		$expectedForm .= '<label for="wpsqt_contact_no">No</label>';
		$expectedForm .= '<input type="radio" name="wpsqt_contact" value="yes"  id="wpsqt_contact_yes" />';
		$expectedForm .= '<label for="wpsqt_contact_yes">Yes</label>';
		$expectedForm .= '</td>';
		$expectedForm .= '<td>This will show a form for users to enter their contact details before proceeding</td>';
		$expectedForm .= '</tr><tr>';
		$expectedForm .= '<th scope="row">Use WordPress user details</th><td valign="top"><input type="radio" name="wpsqt_use_wp" value="no"  checked="checked" id="wpsqt_use_wp_no" />';
		$expectedForm .= '<label for="wpsqt_use_wp_no">No</label><input type="radio" name="wpsqt_use_wp" value="yes"  id="wpsqt_use_wp_yes" />';
		$expectedForm .= '<label for="wpsqt_use_wp_yes">Yes</label></td>';
		$expectedForm .= '<td>This will allow you to have the Quiz to use the user details for signed in users of your blog. If enabled the contact form will not be shown if enabled.</td>';
		$expectedForm .= '</tr>';
		$expectedForm .= '<tr><th scope="row">Custom Email Template</th>';
		$expectedForm .= '<td valign="top"><textarea name="wpsqt_email_template" rows="8" cols="40"></textarea></td>';
		$expectedForm .= '<td>The template of the email sent on notification. <strong>If empty the default one will be sent.</strong> <a href="#template_tokens">Click Here</a> to see the tokens that can be used.</td></tr>';
		$expectedForm .= '</tbody>';
		$expectedForm .= '</table>';
		
		$this->assertEquals($expectedForm,$formOneLine, "Form not as expected");

		$errorMessages = $objForm->getMessages( array( "wpsqt_name" => "PHPUnit test",
													   "wpsqt_notificaton_type" => "none",
													   "wpsqt_limit_one" => "yes",
													   "wpsqt_finish_display" => "Quiz Review",
													   "wpsqt_contact" => "no",
													   "wpsqt_use_wp" => "no",
													   "wpsqt_email_template" => "",
													   "wpsqt_status" => "enabled"
													   ) );
		$this->assertEquals(array(),$errorMessages,"Error messages isn't empty");
	}
	
}