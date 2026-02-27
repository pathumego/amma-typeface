<?php

/**
 * Class for the top scores widget
 * @since 2.3
 */
class Wpsqt_Top_Widget extends WP_Widget {

	// Contructor
	function Wpsqt_Top_Widget() {
		$widget_ops = array('classname' => 'Wpsqt_Top_Widget', 'description' => 'Top Scores');
		$this->WP_Widget('Wpsqt_Top_Widget', 'Top Scores', $widget_ops);
	}
	
	// Form for options when widget is added
	function form($instance) {
		$instance = wp_parse_args((array) $instance, array('quiz_id' => false, 'max_results' => '5'));
		$quiz_id = $instance['quiz_id'];
		$max_results = $instance['max_results'];
?>
	<p><label for="<?php echo $this->get_field_id('quiz_id'); ?>">Quiz ID: <input class="widefat" id="<?php echo $this->get_field_id('quiz_id'); ?>" name="<?php echo $this->get_field_name('quiz_id'); ?>" type="text" value="<?php echo esc_attr($quiz_id); ?>" /></label></p>
	<p><label for="<?php echo $this->get_field_id('max_results'); ?>">Max Results: <input class="widefat" id="<?php echo $this->get_field_id('max_results'); ?>" name="<?php echo $this->get_field_name('max_results'); ?>" type="text" value="<?php echo esc_attr($max_results); ?>" /></label></p>
<?php
	}
	
	// Handles when the form is saved
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['quiz_id'] = $new_instance['quiz_id'];
		$instance['max_results'] = $new_instance['max_results'];
		return $instance;
	}
	
	// Displays the widget
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		
		// Global db connection
		global $wpdb;
		
		// Gets the quiz name
		$quiz = $wpdb->get_row("SELECT `name` FROM `".WPSQT_TABLE_QUIZ_SURVEYS."` WHERE id = '".$instance['quiz_id']."'");
		
		// Actually grabs the top results
		$top = $wpdb->get_results("SELECT * FROM `".WPSQT_TABLE_RESULTS."` WHERE `item_id` = '".$instance['quiz_id']."' ORDER BY `percentage` DESC LIMIT ".$instance['max_results'], ARRAY_A);
		
		echo $before_widget;
		$title = "Top Scores For ".$quiz->name
		;
		if (!empty($title))
			echo $before_title.$title.$after_title;
		
		// Displays top results
		foreach($top as $result) {
			$person = unserialize($result['person']);
			if (empty($result['percentage']))
				continue;
			if (isset($person['name']) && !empty($person['name'])) {
				$name = $person['name'];
			} else if(isset($person['Name']) && !empty($person['Name'])) {
				$name = $person['Name'];
			} else {
				$name = 'Anonymous';
			}
			echo '<p>'.ucwords($name).' with a score of '.$result['percentage'].'%</p>';
		}
		
		echo $after_widget;
	}
}

