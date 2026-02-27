<?php
require_once WPSQT_DIR.'lib/Wpsqt/Tokens.php';
	/**
	 * Handles testing the token class, adding, updating,
	 * replacing and the filter usage.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, All rights reserved.
	 * @license GPL v2
	 * @package WP Survey And Quiz Tool
	 */

class WpsqtTokensTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * Tests to see if token replacements 
	 * are working.
	 * 
	 * @since 2.0
	 */
	public function testTwoTokensAddReplacement(){
		
		$objTokens = new Wpsqt_Tokens();
		$objTokens->addToken("name", "My name","Iain Cambridge")
				  ->addToken("email", "My email address", "backie@backie.org");

		$this->assertEquals("Iain Cambridge-backie@backie.org",$objTokens->doReplacement("%name%-%email%"), "The replacement doesn't match what it should be");
		$this->assertEquals("Iain Cambridge-backie@backie.org",$objTokens->doReplacement("%NAME%-%email%"), "The replacement doesn't match what it should be");
		$this->assertEquals("Iain Cambridge-%email",$objTokens->doReplacement("%name%-%email"), "The replacement doesn't match what it should be");
				  
	}	
	
	/**
	 * Tests to see if token replacements are
	 * working when tokens are updated.
	 * 
	 * @since 2.0
	 */
	public function testTwoTokensSingleUpdateReplacement(){
				
		$objTokens = new Wpsqt_Tokens();
		
		$objTokens->addToken("name", "My name")
				  ->addToken("email", "My email address")
				  ->setTokenValue("name","Iain Cambridge")
				  ->setTokenValue("email","backie@backie.org");
		
		$this->assertEquals("Iain Cambridge-backie@backie.org",$objTokens->doReplacement("%name%-%email%"), "The replacement doesn't match what it should be");
		$this->assertEquals("Iain Cambridge-backie@backie.org",$objTokens->doReplacement("%NAME%-%email%"), "The replacement doesn't match what it should be");
		$this->assertEquals("Iain Cambridge-%email",$objTokens->doReplacement("%name%-%email"), "The replacement doesn't match what it should be");
						  
	}
	
	/**
	 * Tests to see if the token replacements are
	 * working when the mass value update is used.
	 * 
	 * @since 2.0
	 */
	
	public function testTwoTokensMassUpdateReplacement(){
		
		$objTokens = new Wpsqt_Tokens();
		
		$objTokens->addToken("name", "My name")
				  ->addToken("email", "My email address")
				  ->setTokensValue( array("name" =>"Iain Cambridge", "email" => "backie@backie.org"));
				  
		$this->assertEquals("Iain Cambridge-backie@backie.org",$objTokens->doReplacement("%name%-%email%"), "The replacement doesn't match what it should be");
		$this->assertEquals("Iain Cambridge-backie@backie.org",$objTokens->doReplacement("%NAME%-%email%"), "The replacement doesn't match what it should be");
		$this->assertEquals("Iain Cambridge-%email",$objTokens->doReplacement("%name%-%email"), "The replacement doesn't match what it should be");
			
		
	}
	
	/**
	 * Checks to see if adding tokens via the 
	 * filter is functional.
	 *  
	 * @since 2.0
	 */
	
	public function testTokenAddViaFilter(){
		
		add_filter("wpsqt_replacement_tokens", array($this,"filter_test"));
		
		$objTokens = new Wpsqt_Tokens();
		
		$objTokens->addToken("name", "My name","Iain Cambridge")
				  ->addToken("email", "My email address", "backie@backie.org");
				  
		$this->assertEquals("Iain Cambridge-backie@backie.org-Fubra Limited",$objTokens->doReplacement("%name%-%email%-%work%"), "The replacement doesn't match what it should be");
		$this->assertEquals("Iain Cambridge-backie@backie.org-Fubra Limited",$objTokens->doReplacement("%NAME%-%email%-%work%"), "The replacement doesn't match what it should be");
		$this->assertEquals("Iain Cambridge-%email-Fubra Limited",$objTokens->doReplacement("%name%-%email-%work%"), "The replacement doesn't match what it should be");

		remove_all_filters("wpsqt_replacement_tokens");
	}
	
	/**
	 * Adds a token to the Wpsqt_Tokens object.
	 * 
	 * @param Wpsqt_Tokens $objTokens
	 * @since 2.0
	 */
	public function filter_test(Wpsqt_Tokens $objTokens){
		$objTokens->addToken("work","Company I work for","Fubra Limited");
	}
	
	/**
	 * Checks to see if the proper description is being outputed.
	 * 
	 * @since 2.0
	 */
	
	public function testDescription(){
		
		$objTokens = new Wpsqt_Tokens();
		
		$objTokens->addToken("name", "My name","Iain Cambridge")
				  ->addToken("email", "My email address", "backie@backie.org");

		$descriptionHtml = "<ul>";
		$descriptionHtml .= "<li><strong>%NAME%</strong> - My name</li>";
		$descriptionHtml .= "<li><strong>%EMAIL%</strong> - My email address</li>";
		$descriptionHtml .= "</ul>";
				  
		$this->assertEquals( $descriptionHtml , $objTokens->getDescriptions(),"The html doesn't match what was expected");		  
				  
	}
	
	/**
	 * Checks to see if the singleton is working and if it's holding the 
	 * tokens we expect it to have.
	 * 
	 * @since 2.0
	 */
	
	public function testSingleton(){
		
		$objTokens = Wpsqt_Tokens::getTokenObject();
		
		$descriptionHtml = "<ul>";
		$descriptionHtml .= "<li><strong>%USER_NAME%</strong> - The name of the user who has taken the quiz or survey.</li>";
		$descriptionHtml .= "<li><strong>%QUIZ_NAME%</strong> - The name of the quiz that has been taken, <strong>same as %SURVEY_NAME%</strong>.</li>";
		$descriptionHtml .= "<li><strong>%SURVEY_NAME%</strong> - The name of the survey that has been taken, <strong>same as %QUIZ_NAME%</strong>.</li>";
		$descriptionHtml .= "<li><strong>%DATE_EU%</strong> - The date the quiz or survey was taken in EU format.</li>";
		$descriptionHtml .= "<li><strong>%DATE_US%</strong> - The date the quiz or survey was taken in US format.</li>";
		$descriptionHtml .= "<li><strong>%SCORE%</strong> - Score gained in quiz, only works if automarking is enabled.</li>";
		$descriptionHtml .= "<li><strong>%RESULT_URL%</strong> - A link to view the results in the dashboard.</li>";
		$descriptionHtml .= "<li><strong>%DATETIME_EU%</strong> - The date and time the quiz or survey was taken in EU format.</li>";
		$descriptionHtml .= "<li><strong>%DATETIME_US%</strong> - The date and time the quiz or survey was taken in US format.</li>";
		$descriptionHtml .= "<li><strong>%IP_ADDRESS%</strong> - The IP address of the user who has taken the quiz or survey.</li>";
		$descriptionHtml .= "<li><strong>%HOSTNAME%</strong> - The hostname of the IP address of the user who has taken the quiz or survey.</li>";
		$descriptionHtml .= "<li><strong>%USER_AGENT%</strong> - The user agent of the user who has taken the quiz or survey.</li>";
		$descriptionHtml .= "</ul>";
				  
		$this->assertEquals( $descriptionHtml , $objTokens->getDescriptions(),"The html doesn't match what was expected");		  
		
	}
	
}