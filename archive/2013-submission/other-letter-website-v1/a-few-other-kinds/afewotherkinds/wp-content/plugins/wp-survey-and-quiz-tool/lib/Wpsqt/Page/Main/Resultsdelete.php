<?php

	/**
	 * Deletes results
	 *
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Resultsdelete extends Wpsqt_Page {

	public function process(){

		global $wpdb;

		if ( !isset($_GET['resultid']) ){
			// To a redirect here.
		}

		if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
			if (isset($_POST['deleteselected'])) {
				foreach ($_POST['delete'] as $result) {
					$wpdb->query(
						$wpdb->prepare("DELETE FROM `".WPSQT_TABLE_RESULTS."`
										WHERE id = %d", array((int) $result))
					);
				}
				$this->redirect(WPSQT_URL_MAIN."&section=results".
											   "&subsection=quiz&id=".
											   $_GET['id']."&deleted=true");
			} else {
				$wpdb->query(
					$wpdb->prepare("DELETE FROM `".WPSQT_TABLE_RESULTS."`
									WHERE id = %d", array($_GET['resultid']))
						);
				$this->redirect(WPSQT_URL_MAIN."&section=results".
											   "&subsection=quiz&id=".
											   $_GET['id']."&deleted=true");
				echo 'deleted';
			}
		} else {
			$this->_pageVars['personName'] = $wpdb->get_var(
												$wpdb->prepare( "SELECT person_name FROM `".WPSQT_TABLE_RESULTS."` WHERE id = %d" , array($_GET['resultid']) )
									     				);
			$this->_pageView = "admin/results/delete.php";
		}

	}

}
