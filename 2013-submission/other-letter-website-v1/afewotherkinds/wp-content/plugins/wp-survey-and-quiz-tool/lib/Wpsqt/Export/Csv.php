<?php
require_once WPSQT_DIR.'lib/Wpsqt/Export.php';

	/**
	 * 
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Export_Csv extends Wpsqt_Export {
	
	private $csvLines = array();

	public $quizId;

	public function output(){
		
		$csv = "";
		foreach ( $this->_data as $array ) {
			$csv .= implode(",",$array).PHP_EOL;
		}
		
		return $csv;	
	}		

	public function generate($id) {
		global $wpdb;

		$results = $wpdb->get_results('SELECT * FROM '.WPSQT_TABLE_RESULTS.' WHERE item_id = "'.$id.'"', ARRAY_A);

		$this->csvLines[] = 'ID, Name, Score, Total, Percentage, Pass/Fail, Status, Date';
		foreach( $results as $result ){ 
			$csvline = $result['id'].","; 
			$csvline .= $result['person_name'].',';
			if($result['total'] == 0) {$csvline .= ',,';} else {$csvline .= $result['score'].",".$result['total'].",";}
			if($result['total'] == 0) {$csvline .= ',';} else {$csvline .= $result['percentage']."%,";}
			if ($result['pass'] == 1) {$csvline .= "Pass,";} else {$csvline .= "Fail,";}
			$csvline .= ucfirst($result['status']).","; 
			if (!empty($result['datetaken'])) { $csvline .= date('d-m-y G:i:s',$result['datetaken']); }; 
			$this->csvLines[] = $csvline;
		}

		return $this->csvLines;
	}

	public function saveFile() {
		$path = 'tmp/results-'.$this->quizId.'.csv';
		file_put_contents(WPSQT_DIR.$path, implode($this->csvLines, "\r\n"));
		return $path;
	}
		
}