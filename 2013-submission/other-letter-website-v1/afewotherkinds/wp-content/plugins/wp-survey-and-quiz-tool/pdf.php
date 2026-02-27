<?php

	/**
	 * Handles the fetching and downloading of PDFs
	 * from DocRaptor. 
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011 (c), all rights reserved.
	 * @license GPL v2
	 * @package WPSQT
	 */
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/wp-load.php';
require_once WPSQT_DIR.'lib/Wpsqt/Tokens.php';
require_once WPSQT_DIR.'lib/docraptor.php';

$resultId = filter_input(INPUT_GET, 'id');
$quizId = filter_input(INPUT_GET,'quizid');
if ( !$_GET['quizid'] || !$_GET['id']  ){
	wp_die('No result id given');
}
global $wpdb;


					
if ( filter_input(INPUT_GET, 'html') ){
	
		echo $pdfTemplate;
	exit;
	
} else {
	
	$quizDetails = $wpdb->get_row(
						$wpdb->prepare("SELECT * FROM `".WPSQT_TABLE_QUIZ_SURVEYS."` WHERE id = %d", array($_GET['quizid'])),
						ARRAY_A);
						
	$quizDetails['settings'] = unserialize($quizDetails['settings']);
						
	$resultDetails = $wpdb->get_row(
						$wpdb->prepare("SELECT * FROM `".WPSQT_TABLE_RESULTS."` WHERE id = %d", array($_GET['id'])),
						ARRAY_A	);
						
	$resultDetails['person'] = unserialize($resultDetails['person']);
	$resultDetails['sections'] = unserialize($resultDetails['sections']);
		
	$personName = ( isset($resultDetails['person']['name']) && !empty($resultDetails['person']['name']) ) ? $resultDetails['person']['name'] : 'Anonymous';
	$timestamp = strtotime($resultDetails['timestamp']);
	
	$pdfTemplate = (empty($quizDetails['settings']['pdf_template'])) ? get_option('wpsqt_pdf_template'):$quizDetails['settings']['pdf_template'];
	
	if ( empty($pdfTemplate) ){
		// default pdf template here.
		$pdfTemplate  = "<html>";
		$pdfTemplate .= "<body>";
		$pdfTemplate .= "<center>You %USER_NAME% passed the %QUIZ_NAME% quiz!</center>";
		$pdfTemplate .= "</body>";
		$pdfTemplate .= "</html>";
	} 
	
	$objTokens = Wpsqt_Tokens::getTokenObject();
	$objTokens->setDefaultValues();
	$pdfTemplate  = $objTokens->doReplacement($pdfTemplate);
	
	$resultUrl = esc_html(get_bloginfo('url').'/wp-admin/admin.php?page=wpsqt-menu&type=quiz&action=results&id='.$quizId
					.'&subaction=mark&subid='.$resultDetails['id']);
	$pdfTemplate = str_ireplace('%RESULT_URL%', $resultUrl, $pdfTemplate);
	$url = plugins_url('pdf.php?html=true&id='.$_GET['id'].'&quizid='.$_GET['quizid'],__FILE__);
	$apiKey = get_option('wpsqt_docraptor_api');
	
	if ( !$apiKey ){
		print "No DocRaptor API key! Please alert the site owner to fix this!";
		exit;
	}
	
	$objDocraptor = new DocRaptor($apiKey);
	$objDocraptor->setDocumentType('pdf')
				 ->setName('PDF')
				 ->setDocumentContent($pdfTemplate);
	header('Content-disposition: attachment; filename=document.pdf');
	header('Content-type: application/pdf');
	print $objDocraptor->fetchDocument();
	
	
}