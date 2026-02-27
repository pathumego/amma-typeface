<?php

	/**
	 * Handles the upgrading of the plugin.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

if ($needUpdate == '1') {
	if (version_compare($oldVersion, '2.1') <= 0) {
		$objUpgrade = new Wpsqt_Upgrade;
		$objUpgrade->getUpdate(0);
		$objUpgrade->execute();
	}
	switch($oldVersion) {
		case '2.4.3':
		echo '<h4>Updating to 2.5</h4>';
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_RESULTS."` ADD `pass` BOOLEAN NOT NULL");
		echo '<p>Added the `pass` column</p>';
		case '2.5':
		echo '<h4>Updating to 2.5.1</h4>';
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_QUIZ_SURVEYS."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_SECTIONS."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_QUESTIONS."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_FORMS."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_RESULTS."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_SURVEY_CACHE."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
		$wpdb->query("ALTER TABLE  `".WPSQT_TABLE_QUIZ_SURVEYS."` CHANGE  `name`  `name` VARCHAR( 512 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
		echo '<p>Updated all columns to use UTF8</p>';
		case '2.5.1':
		echo '<h4>Updating to 2.5.2</h4>';
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_RESULTS."` ADD `datetaken` VARCHAR(255) NOT NULL AFTER `item_id`");
		case '2.5.2':
		echo '<h4>Updating to 2.5.3</h4>';
		case '2.5.3':
		echo '<h4>Updating to 2.5.4</h4>';
		case '2.6.2':
		echo '<h4>Updating to 2.6.3</h4>';
		$wpdb->query("ALTER TABLE  `".WPSQT_TABLE_QUIZ_SURVEYS."` CHANGE  `name`  `name` VARCHAR( 512 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_RESULTS."` ADD `datetaken` VARCHAR(255) NOT NULL AFTER `item_id`");
		case '2.6.6':
		echo '<h4>Updating to 2.6.7</h4>';
		update_option("wpsqt_required_role", '');
		case '2.8':
		echo '<h4>Updating to 2.8.1</h4>';
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_RESULTS."` ADD `cached` TINYINT(1) DEFAULT '0' AFTER `pass`");
		echo 'Caching all poll results...... ';
			require_once WPSQT_DIR.'lib/Wpsqt/Shortcode.php';

			$polls = $wpdb->get_results("SELECT `id`, `name` FROM `".WPSQT_TABLE_QUIZ_SURVEYS."` WHERE `type` = 'poll'", ARRAY_A);

			foreach ($polls as $poll) {

				$id = (int) $poll['id'];
				$name = $poll['name'];

				$resultsCount = $wpdb->query("SELECT `sections` FROM `".WPSQT_TABLE_RESULTS."` WHERE `item_id` = '".$id."'", ARRAY_A);

				// Calculate how many blocks of 100 the results can be split into and always round up
				$recuranceAmount = ceil($resultsCount / 100);
				$counter = 0;

				for($i=0;$i<$recuranceAmount;$i++) {
					$a = $counter + 100;
					$results = $wpdb->get_results("SELECT `id`, `sections`, `cached` FROM `".WPSQT_TABLE_RESULTS."` WHERE `item_id` = '".$id."' LIMIT ".$counter.",".$a."", ARRAY_A);

					foreach($results as $result) {
						// Only cache if not already cached!
						if ($result['cached'] == 0) {
							$_SESSION['wpsqt'] = array();
							$_SESSION['wpsqt']['current_result_id'] = (int) $result['id'];
							$result = unserialize($result['sections']);
							// Need a SC object because the constructer sets all the $_SESSION bs we need to be able to resuse the caching method
							$shortcodeObj = new Wpsqt_Shortcode($name, 'poll');
							// Adds answers to $_SESSION
							$_SESSION['wpsqt'][$name]['sections'] = $result;
							// Actually cache
							$shortcodeObj->cachePoll();
						}
					}

					$counter += 100;
				}

			}
		echo 'Done';
		case '2.9':
		echo '<h4>Updating to 2.9.1</h4>';
		$wpdb->query("ALTER TABLE `".WPSQT_TABLE_QUESTIONS."` ADD `order` INT(11) DEFAULT NULL AFTER `difficulty`");
		case '2.12':
		echo '<h4>Updating to 2.13</h4>';
		$wpdb->query("CREATE TABLE IF NOT EXISTS `{$wpdb->get_blog_prefix()}_wpsqt_quiz_state` (
			  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
			    `uid` mediumtext,
				  `answers` text,
				    `post` text,
					  `quiz_id` int(11) DEFAULT NULL,
					    `current_section` int(11) DEFAULT NULL,
						  PRIMARY KEY (`id`)
					  ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;");
	}
	echo '<p><strong>Updated. Return to the <a href="'.WPSQT_URL_MAIN.'">main page</a> to ensure the notice disappears</strong></p>';
	update_option('wpsqt_version',WPSQT_VERSION);

} else {
	echo '<p>You are up to date.</p>';
}
update_option("wpsqt_update_required",false);