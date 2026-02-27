<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>
		WP Survey And Quiz Tool - Survey/Quizzes
		<a href="<?php echo WPSQT_URL_MAIN; ?>&section=addnew&subsection=quiz" class="button add-new-h2">Add New Quiz</a>
		<a href="<?php echo WPSQT_URL_MAIN; ?>&section=addnew&subsection=survey" class="button add-new-h2">Add New Survey</a>
		<a href="<?php echo WPSQT_URL_MAIN; ?>&section=addnew&subsection=poll" class="button add-new-h2">Add New Poll</a>
	</h2>

	<?php if ( isset($_GET['delete']) && $_GET['delete'] == "true" ){
		?>
	<div class="updated">
		<strong>Quiz/Survey successfully deleted!</strong>
	</div>
		<?php
	}?>

	<form method="post" action="">

		<div class="tablenav">

			<ul class="subsubsub">
				<li>
					<a href="<?php echo WPSQT_URL_MAIN; ?>" <?php if ($type == "") { ?>  class="current"<?php } ?> id="all_link">All <span class="count">(<?php echo $totalNo; ?>)</span></a> |
				</li>
				<li>
					<a href="<?php echo WPSQT_URL_MAIN; ?>&type=quiz" <?php if ($type =="quiz") { ?>  class="current"<?php } ?> id="quiz_link">Quizzes <span class="count">(<?php echo $quizNo; ?>)</span></a> |
				</li>
				<li>
					<a href="<?php echo WPSQT_URL_MAIN; ?>&type=survey" <?php if ($type == "survey") { ?>  class="current"<?php } ?>  id="survey_link">Surveys <span class="count">(<?php echo $surveyNo; ?>)</span></a> |
				</li>
				<li>
					<a href="<?php echo WPSQT_URL_MAIN; ?>&type=poll" <?php if ($type == "poll") { ?>  class="current"<?php } ?>  id="survey_link">Polls <span class="count">(<?php echo $pollNo; ?>)</span></a>
				</li>
			</ul>
			<div class="tablenav-pages">
		   		<?php echo Wpsqt_Core::getPaginationLinks($currentPage, $numberOfPages); ?>
		   	</div>
		</div>

		<table class="widefat post fixed" cellspacing="0">
			<thead>
				<tr>
					<th class="manage-column" scope="col" width="40">ID</th>
					<th class="manage-column column-title" scope="col">Title</th>
					<th scope="col" width="75">Status</th>
					<th scope="col" width="75">Results</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="manage-column" scope="col" width="25">ID</th>
					<th class="manage-column column-title" scope="col">Title</th>
					<th scope="col" width="75">Status</th>
					<th scope="col" width="75">Results</th>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach( $results as $result ){ ?>
				<tr class="<?php if (isset($result["unviewed_count"]) && $result["unviewed_count"] !== 0){?>unapproved<?php } else { ?>approved<?php  }?>">
					<th scope="row"><?php echo $result['id']; ?></th>
					<td class="column-title">
						<strong>
							<a class="row-title" href="<?php echo WPSQT_URL_MAIN;?>&section=edit&subsection=<?php esc_html_e($result["type"], 'wp-survey-and-quiz-tool'); ?>&id=<?php esc_html_e($result['id'], 'wp-survey-and-quiz-tool'); ?>"><?php esc_html_e($result["name"], 'wp-survey-and-quiz-tool'); ?></a><?php if ($type == "all"){?> <strong>- <?php esc_html_e(ucfirst($result["type"]), 'wp-survey-and-quiz-tool'); ?></strong><?php }?>
						</strong>
						<div class="row-actions">
							<span class="edit"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=edit&subsection=<?php esc_html_e($result["type"], 'wp-survey-and-quiz-tool'); ?>&id=<?php esc_html_e($result["id"], 'wp-survey-and-quiz-tool'); ?>">Edit</a> | </span>
							<span class="duplicate"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=duplicate&subsection=<?php esc_html_e($result["type"], 'wp-survey-and-quiz-tool'); ?>&id=<?php esc_html_e($result["id"], 'wp-survey-and-quiz-tool'); ?>">Duplicate</a> | </span>
							<span class="section"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=sections&subsection=<?php esc_html_e($result["type"], 'wp-survey-and-quiz-tool'); ?>&id=<?php esc_html_e($result["id"], 'wp-survey-and-quiz-tool'); ?>">Sections</a> | </span>
							<span class="questions"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=questions&subsection=<?php esc_html_e($result["type"], 'wp-survey-and-quiz-tool'); ?>&id=<?php esc_html_e($result["id"], 'wp-survey-and-quiz-tool'); ?>">Questions</a> | </span>
							<span class="form"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=form&subsection=<?php esc_html_e($result['type'], 'wp-survey-and-quiz-tool'); ?>&id=<?php esc_html_e($result["id"], 'wp-survey-and-quiz-tool'); ?>">Form</a> | </span>
							<?php if ($result['type'] == 'survey'){ ?>
							<span class="results"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=<?php esc_html_e($result['type'], 'wp-survey-and-quiz-tool'); ?>&id=<?php esc_html_e($result["id"], 'wp-survey-and-quiz-tool'); ?>">Single Results</a> | </span>
							<span class="results"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=total&id=<?php esc_html_e($result["id"], 'wp-survey-and-quiz-tool'); ?>">Total Results</a> | </span>
							<?php } else { ?>
							<span class="results"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=<?php esc_html_e($result["type"], 'wp-survey-and-quiz-tool'); ?>&id=<?php esc_html_e($result["id"], 'wp-survey-and-quiz-tool'); ?>">Results</a> | </span>
							<?php } ?>
							<span class="delete"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=delete&subsection=<?php esc_html_e($result["type"], 'wp-survey-and-quiz-tool'); ?>&id=<?php esc_html_e($result["id"], 'wp-survey-and-quiz-tool'); ?>">Delete</a></span>
						</div>
					</td>
					<td><font color="<?php if ($result['status'] == 'enabled'){ ?>#00FF00<?php } else { ?>#FF0000<?php }?>"><?php esc_html_e(ucfirst($result["status"]), 'wp-survey-and-quiz-tool'); ?></font></td>
					<td class="comments column-comments">
						<div class="post-com-count-wrapper">
							<a class="post-com-count" title=" pending" href="<?php echo WPSQT_URL_MAIN;?>&section=results&subsection=<?php esc_html_e($result["type"], 'wp-survey-and-quiz-tool'); ?>&id=<?php esc_html_e($result["id"], 'wp-survey-and-quiz-tool'); ?>">
								<span class="comment-count"><?php esc_html_e($result["results"], 'wp-survey-and-quiz-tool'); ?></span>
							</a>
						</div>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>

	</form>

</div>


<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>