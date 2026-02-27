<?php

require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Results.php';

class Wpsqt_Page_Main_Results_Quiz extends Wpsqt_Page_Main_Results {
	
	public function init(){
		$this->_pageView = 'admin/results/index.php';
	}	
	
}

?>