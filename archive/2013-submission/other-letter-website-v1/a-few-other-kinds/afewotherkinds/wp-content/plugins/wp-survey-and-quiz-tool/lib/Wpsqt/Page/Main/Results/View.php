 <?php
 require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Results/Mark.php';	
 	
 	/**
	 *  
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */
 
class Wpsqt_Page_Main_Results_View extends Wpsqt_Page_Main_Results_Mark {
 	
	public function init(){
		$this->_pageView = 'admin/surveys/result.single.php';	
	}	
	
 }	