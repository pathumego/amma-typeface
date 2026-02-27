<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery("#wpsqt_questions tbody.wpsqt_questions_content").sortable();
	jQuery("#wpsqt_questions tbody.wpsqt_questions_content").disableSelection();
});

var saveOrder = function() {
	var table = jQuery("#wpsqt_questions tbody.wpsqt_questions_content");
	var order = "";
	table.children().each(function() {
		order = order + jQuery(this).attr('id') + ',';
	});
	order = encodeURIComponent(order);
	orderURL = "<?php echo WPSQT_URL_MAIN.'&section=questions&subsection=survey&id='.$_GET['id'].'&order=' ?>" + order;
	window.location = orderURL;
}
</script>

<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Questions</h2>
		
	<?php require WPSQT_DIR.'pages/admin/misc/navbar.php'; ?>
	
	<?php if ( isset($_GET['new']) &&  $_GET['new'] == "true" ) { ?>
	<div class="updated">
		<strong>Question successfully added.</strong>
	</div>
	<?php } ?>
	
	<?php if ( isset($_GET['edit']) &&  $_GET['edit'] == "true" ) { ?>
	<div class="updated">
		<strong>Question successfully edited.</strong>
	</div>
	<?php } ?>
	
	<?php if ( isset($_GET['delete']) &&  $_GET['delete'] == "true" ) { ?>
	<div class="updated">
		<strong>Question successfully deleted.</strong>
	</div>
	<?php } ?>
	<ul class="subsubsub">
		<?php foreach ( $question_types as $type ){ 
				$friendlyType = str_replace(' ', '', $type);
			?>			
			<li>
				<a href="<?php echo WPSQT_URL_MAIN; ?>&section=questions&subsection=<?php echo urlencode($_GET['subsection']); ?>&type=<?php echo $type; ?>" <?php if (isset($_GET['type']) && $type == $_GET['type']) { ?>  class="current"<?php } ?>><?php echo $type; ?> <span class="count">(<?php echo $question_counts[$friendlyType.'_count']; ?>)</span></a>
			</li>
		<?php } ?>
	</ul>
	<div class="tablenav">
	
		
	
		<?php if ( isset($_GET['id']) ){ ?>
		<div class="alignleft">
			<a href="<?php echo WPSQT_URL_MAIN; ?>&section=questionadd&subsection=<?php esc_html_e($_GET['subsection'], 'wp-survey-and-quiz-tool'); ?>&id=<?php esc_html_e($_GET['id'], 'wp-survey-and-quiz-tool'); ?>" class="button-secondary" title="Add New Question">Add New Question</a>
			<a href="#" title="Save Order" onclick="saveOrder();" class="button-secondary">Save Order</a>
		</div>
		<?php } ?>		
		<div class="tablenav-pages">
		   <?php echo Wpsqt_Core::getPaginationLinks($currentPage, $numberOfPages);  ?>
		</div>
	</div>
	<table class="widefat" id="wpsqt_questions">
		<thead>
			<tr>
				<th>ID</th>
				<th>Question</th>
				<th>Type</th>
				<th>Rate</th>
				<th>Edit</th>
				<th>Delete</th>
				<th></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Question</th>
				<th>Type</th>
				<th>Rate</th>
				<th>Edit</th>
				<th>Delete</th>
				<th></th>
			</tr>
		</tfoot>
		<tbody class="wpsqt_questions_content">
			<?php if ( empty($questions) ) { ?>			
				<tr>
					<td colspan="5"><div style="text-align: center;">No questions yet!</div></td>
				</tr>
			<?php }
				  else {
				  	$count = 0;
					foreach ($questions as $rawQuestion) { 
						$count++;
						$question = Wpsqt_System::unserializeQuestion($rawQuestion, $_GET['subsection']);
						?>
			<tr class="<?php echo ( $count % 2 ) ?  'wpsqt-odd' : 'wpsqt-even'; ?>" id="<?php echo $question['id']; ?>">
				<td><?php echo $question['id']; ?></td>
				<td><?php echo stripslashes($question['name']); ?></td>
				<td><?php echo ucfirst( stripslashes($question['type']) ); ?></td>
                
				<td>
					<?php    
                    
                    //global $wpdb;
                    $correct_answer = 0;
                    
                    $RESULTS_count = $wpdb->get_var( "SELECT COUNT(*) FROM ".WPSQT_TABLE_RESULTS );
                    $lastID = $wpdb->get_var( "SELECT id FROM ".WPSQT_TABLE_RESULTS." ORDER BY `id` DESC LIMIT 0,1" );
                    
                    for($i = 1; $i <= $lastID; $i++){
                    
                        $rawResult = $wpdb->get_row(
                                        $wpdb->prepare("SELECT * FROM ".WPSQT_TABLE_RESULTS." WHERE id = %d", $i),ARRAY_A);
                                                        
                        $rawResult['sections'] = unserialize($rawResult['sections']);
                        
                        foreach((array)$rawResult['sections'] as $result_sections){
                            if(isset($result_sections['answers'][$question['id']]['mark']) && ($result_sections['answers'][$question['id']]['mark'] == 'correct')) $correct_answer++;
                        }
                    }
					if ($RESULTS_count > 0) {
						$success_rate = number_format(($correct_answer/$RESULTS_count)*100, 0);
					} else {
						$success_rate = 0;
					}
                    echo ($success_rate<80 ? "<span style=\"color:red;\">$success_rate%</span>" : "<span style=\"color:green;\">$success_rate%</span>");
                    ?>
                </td>
                
				<td><a href="<?php echo WPSQT_URL_MAIN; ?>&section=questionedit&subsection=<?php esc_html_e($_GET['subsection'], 'wp-survey-and-quiz-tool'); ?>&id=<?php esc_html_e($_GET['id'], 'wp-survey-and-quiz-tool'); ?>&questionid=<?php esc_html_e($question['id'], 'wp-survey-and-quiz-tool'); ?>" class="button-secondary" title="Edit Question">Edit</a></td>
				<td><a href="<?php echo WPSQT_URL_MAIN; ?>&section=questiondelete&subsection=<?php esc_html_e($_GET['subsection'], 'wp-survey-and-quiz-tool'); ?>&id=<?php esc_html_e($_GET['id'], 'wp-survey-and-quiz-tool'); ?>&questionid=<?php esc_html_e($question['id'], 'wp-survey-and-quiz-tool'); ?>" class="button-secondary" title="Delete Question">Delete</a></td>
				<td><img src="<?php echo plugin_dir_url(WPSQT_DIR.'images/handle.png').'handle.png'; ?>" /></td>
			</tr>
			<?php } 
				 }?>
		</tbody>
	</table>

	<div class="tablenav">
		<?php if ( isset($_GET['id']) ){ ?>
		<div class="alignleft">
			<a href="<?php echo WPSQT_URL_MAIN; ?>&section=questionadd&subsection=<?php esc_html_e($_GET['subsection'], 'wp-survey-and-quiz-tool'); ?>&id=<?php esc_html_e($_GET['id'], 'wp-survey-and-quiz-tool'); ?>" class="button-secondary" title="Add New Question">Add New Question</a>
			<a href="#" title="Save Order" onclick="saveOrder();" class="button-secondary">Save Order</a>
		</div>
		<?php } ?>		
		<div class="tablenav-pages">
		   <?php echo Wpsqt_Core::getPaginationLinks($currentPage, $numberOfPages); ?>
		</div>		
	</div>

</div>
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>
