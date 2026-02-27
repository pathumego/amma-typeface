<?php
require_once WPSQT_DIR.'lib/Wpsqt/Export.php';

	/**
	 * Handles exporting data in a SQL format.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Export_Sql extends Wpsqt_Export {


	/**
	 * The name of the table that is going to be exported
	 * 
	 * @var array
	 * @since 2.0
	 */
	protected $_tableName;
	
	/**
	 * 
	 * 
	 * @param string $tableName
	 * @since 2.0
	 */
	public function setTable ( $tableName ) {
		$this->_tableName = $tableName;
	}	
	


	public function output(){
		
		global $wpdb;
		// Fetch the table data.	
		$tableData = $wpdb->get_results("DESCRIBE ".$this->_tableName.";",ARRAY_A);		
		$keys = array_keys(current($this->_data));
		$dontExport = array();
			
		// Create table SQL.	
		$sql = "CREATE TABLE IF NOT EXISTS `".$this->_tableName."` (".PHP_EOL;
		foreach ( $tableData as $row ) {
			
			$sql .= "`".$row['Field']."` ".$row['Type']." ";
			$sql .= ( $row['Null'] == "YES" ) ? "NULL" : "NOT NULL"; 
			$sql .= " DEFAULT ".$row['Default']." ".$row['Extra']." ,".PHP_EOL;
			
			if ( !empty($row['Key']) && $row['Extra'] == "auto_increment" ){
				$dontExport[] = $row['Field'];
			}
		}		
		$sql .= ") ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci;".PHP_EOL;
		
		$cols = array();
		$vals = array();
		foreach ( $keys as $key ){			
			if ( !in_array($colName,$dontExport) ){
				$cols[] = "`".$key."`";
			}	
		}
		
		// Generate the massive insert statement.
		$sql .= "INSERT INTO `wpsqt_export` (".implode(",",$cols).") VALUES ";
		
		// Loop through the data.
		foreach ( $this->_data as $array ){
			$sqlVal = "(";
			$sqlVals = array();
			// loop through the coloumns.
			foreach ( $array as $colName => $col ) {
				if ( !in_array($colName,$dontExport) ){
					$sqlVals[] = "'".$col."'";
				}
			}		
			$sqlVal .= implode(",",$sqlVals);
			$sqlVal .= ")";
			$vals[] = $sqlVal;
		}	
		$sql .= implode(",",$vals);
		
		return $sql.PHP_EOL;
		
	}
		
}