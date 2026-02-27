<?php
require_once WPSQT_DIR.'lib/Wpsqt/Form.php';


/**
 * The form for adding new questions, should be usable 
 * by both quiz and surveys.
 * 
 * @author Iain Cambridge
 * @copyright Fubra Limited 2010-2011, all rights reserved.
 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
 * @package WPSQT
 */

class Wpsqt_Form_Question extends Wpsqt_Form {
	
	/**
	 * Builds the question form.
	 * 
	 * @param array $questionTypes The array of question types, should have the name of the type as the key and the description of the question type as the value.
	 * @param array $sections The array of sections. Values as the values for this one.
	 * @param array $options The array of values for the fields in the form. If it's empty we'll build a basic one to avoid undefined indexes all over the place.
	 */
	public function __construct( $questionTypes, $sections, $options = array() ){
		if ( empty($options) ) {
			$options = array('question' => false,
							 'type' => false,
							 'points' => false,
							 'difficulty' => false,
							 'randomize_answers' => false,
							 'section' => false,
							 'add_text' => false,
							 'explanation' => false,
							 'explanation_onlyatfinish' => false,
							 'required' => false,
					 		 'image' => false,
					 		 'likertscale' => false,
					 		 'likertmatrixscale' => false,
					 		 'likertmatrixcustom' => false);
		}
		$typeHelpText = "";
		foreach ( $questionTypes as $type => $text ){
			$typeHelpText .= "<strong>".$type."</strong> ".$text."<br />";
		}
		
		$this->addOption("wpsqt_name", "Question", "textarea", $options['question'], "The text for the question (the actual question)." )
			 ->addOption("wpsqt_type", "Type", "select", $options['type'], $typeHelpText, array_keys($questionTypes) )
			 ->addOption("wpsqt_randomize_answers", "Randomize answers", "yesno", $options['randomize_answers'], "Sort the answers of this question randomly.")
			 ->addOption("wpsqt_likertmatrixscale", "Likert Matrix Scale", "select", $options['likertmatrixscale'], "Scale 1-5 or Disagree/Agree", array("1-5", "Disagree/Agree"))
			 ->addOption("wpsqt_likertscale", "Likert Scale", "select", $options['likertscale'], "What should the likert display to?", array('10', '5', '3', 'Agree/Disagree'))
			 ->addOption("wpsqt_likertmatrixcustom", "Custom Answer", "yesno", $options['likertmatrixcustom'], "Would you like the user to be able to enter a custom answer?")
			 ->addOption("wpsqt_points", "Points", "select", $options['points'], "How many points the question is worth.", range(1,10))
			 ->addOption("wpsqt_difficulty", "Difficulty", "select", $options['difficulty'], "The difficulty of the question.", array('Easy','Medium','Hard'))
			 ->addOption("wpsqt_section", "Section", "select", $options['section'], "The section/page this question should be in/on.", $sections)
			 ->addOption("wpsqt_required", "Required", "yesno", $options['required'], "Should the user be forced to answer the question to progress to the next step?")
			 ->addOption("wpsqt_explanation", "Answer Explanation", "textarea", $options['explanation'], "What shall be shown when 'show answer' is pressed. <b>Leave blank for no answer explanation to be available.</b>\nWill also display on quiz review page.", array(), false)
			 ->addOption("wpsqt_explanation_onlyatfinish", "Answer Explanation only at finish", "yesno", $options['explanation_onlyatfinish'], "Only show the explanation of an answer after the quiz is taken and &quot;Finish Display&quot; is set to &quot;Review&quot; .", array(), false)
			 ->addOption("wpsqt_add_text", "Additional Text", "textarea", $options['add_text'], "Additional text/html for questions, good for using html to display images.",array(),false)
			 ->addOption("wpsqt_image", "Image", "image", $options['image'], "The image that is to be associated with the question.", array(),  false );
			
		$this->options = $options;
		apply_filters("wpsqt_form_question", $this);
		
	}
	
}
