<div class="wrap">
	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Results</h2>
		
	<?php require WPSQT_DIR.'pages/admin/misc/navbar.php'; ?>	
	
	<?php if ( isset($message) ) { ?>
	<div class="updated">
		<strong><?php echo $message; ?></strong>
	</div>
	<?php } ?>

	<?php if (isset($_GET['status'])) {
		$filter = $_GET['status'];
	} else {
		$filter = 'all';
	} ?>
	
		<form method="post" action="<?php echo WPSQT_URL_MAIN.'&section=resultsdelete&subsection=quiz&id='.$_GET['id']; ?>">
	
		<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />
		<div class="tablenav">
			<ul class="subsubsub">
				<li>
					<a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>" <?php if (isset($filter) && $filter == 'all') { ?>  class="current"<?php } ?> id="all_link">All <span class="count">(<?php echo $counts['unviewed_count'] + $counts['accepted_count'] + $counts['rejected_count']; ?>)</span></a> |			
				</li> 
				<li>
					<a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&status=unviewed" <?php if (isset($filter) && $filter == 'unviewed') { ?>  class="current"<?php } ?> id="quiz_link">Unviewed <span class="count">(<?php echo $counts['unviewed_count']; ?>)</span></a> |			
				</li> 
				<li>
					<a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&status=accepted" <?php if (isset($filter) && $filter == 'accepted') { ?>  class="current"<?php } ?>  id="survey_link">Accepted <span class="count">(<?php echo $counts['accepted_count']; ?>)</span></a> |		
				</li> 
				<li>
					<a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&status=rejected" <?php if (isset($filter) && $filter == 'rejected') { ?>  class="current"<?php } ?>  id="survey_link">Rejected <span class="count">(<?php echo $counts['rejected_count']; ?>)</span></a>			
				</li> 
			</ul>
			
			<div class="tablenav-pages">
				<a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&wpsqt-download=<?php echo urlencode($_GET['id']); ?>">Export CSV</a>
		   		<?php echo Wpsqt_Core::getPaginationLinks($currentPage, $numberOfPages); ?>	
		   	</div>
		</div>
		
		
		<?php if (isset($_GET['order']) && $_GET['order'] == 'ASC') {
			$order = 'DESC';
		} else {
			$order = 'ASC';
		} ?>
		<table class="widefat post fixed" cellspacing="0">
			<thead>
				<tr>
					<th scope="col" width="30"><input type="checkbox" class="wpsqt-selectall" /></th>
					<th class="manage-column" scope="col" width="35"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&orderby=id&order=<?php echo $order; ?><?php if (isset($_GET['status'])) { echo '&status='.$_GET['status']; }  if (isset($_GET['username'])) { echo '&username='.$_GET['username']; } ?>">ID</a></th>
					<th class="manage-column column-title" scope="col"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&orderby=person_name&order=<?php echo $order; ?><?php if (isset($_GET['status'])) { echo '&status='.$_GET['status']; }  if (isset($_GET['username'])) { echo '&username='.$_GET['username']; } ?>">Name</a></th>
					<th scope="col" width="75"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&orderby=score&order=<?php echo $order; ?><?php if (isset($_GET['status'])) { echo '&status='.$_GET['status']; }  if (isset($_GET['username'])) { echo '&username='.$_GET['username']; } ?>">Score</a></th>
					<th scope="col" width="90"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&orderby=percentage&order=<?php echo $order; ?><?php if (isset($_GET['status'])) { echo '&status='.$_GET['status']; }  if (isset($_GET['username'])) { echo '&username='.$_GET['username']; } ?>">Percentage</a></th>
					<th scope="col" width="75"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&orderby=pass&order=<?php echo $order; ?><?php if (isset($_GET['status'])) { echo '&status='.$_GET['status']; }  if (isset($_GET['username'])) { echo '&username='.$_GET['username']; } ?>">Pass/Fail</a></th>
					<th scope="col" width="75"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&orderby=status&order=<?php echo $order; ?><?php if (isset($_GET['status'])) { echo '&status='.$_GET['status']; }  if (isset($_GET['username'])) { echo '&username='.$_GET['username']; } ?>">Status</a></th>
					<th scope="col" width="75"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&orderby=datetaken&order=<?php echo $order; ?><?php if (isset($_GET['status'])) { echo '&status='.$_GET['status']; }  if (isset($_GET['username'])) { echo '&username='.$_GET['username']; } ?>">Date</a></th>
				</tr>			
			</thead>
			<tfoot>
				<tr>
					<th scope="col" width="30"><input type="checkbox" class="wpsqt-selectall" /></th>
					<th class="manage-column" scope="col" width="35"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&orderby=id&order=<?php echo $order; ?><?php if (isset($_GET['status'])) { echo '&status='.$_GET['status']; }  if (isset($_GET['username'])) { echo '&username='.$_GET['username']; } ?>">ID</a></th>
					<th class="manage-column column-title" scope="col"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&orderby=person_name&order=<?php echo $order; ?><?php if (isset($_GET['status'])) { echo '&status='.$_GET['status']; }  if (isset($_GET['username'])) { echo '&username='.$_GET['username']; } ?>">Name</a></th>
					<th scope="col" width="75"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&orderby=score&order=<?php echo $order; ?><?php if (isset($_GET['status'])) { echo '&status='.$_GET['status']; }  if (isset($_GET['username'])) { echo '&username='.$_GET['username']; } ?>">Score</a></th>
					<th scope="col" width="90"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&orderby=percentage&order=<?php echo $order; ?><?php if (isset($_GET['status'])) { echo '&status='.$_GET['status']; }  if (isset($_GET['username'])) { echo '&username='.$_GET['username']; } ?>">Percentage</a></th>
					<th scope="col" width="75"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&orderby=pass&order=<?php echo $order; ?><?php if (isset($_GET['status'])) { echo '&status='.$_GET['status']; }  if (isset($_GET['username'])) { echo '&username='.$_GET['username']; } ?>">Pass/Fail</a></th>
					<th scope="col" width="75"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&orderby=status&order=<?php echo $order; ?><?php if (isset($_GET['status'])) { echo '&status='.$_GET['status']; }  if (isset($_GET['username'])) { echo '&username='.$_GET['username']; } ?>">Status</a></th>
					<th scope="col" width="75"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&orderby=datetaken&order=<?php echo $order; ?><?php if (isset($_GET['status'])) { echo '&status='.$_GET['status']; }  if (isset($_GET['username'])) { echo '&username='.$_GET['username']; } ?>">Date</a></th>
				</tr>			
			</tfoot>
			<tbody>
				<?php foreach( $results as $result ){ ?>
				<tr>
					<td><input type="checkbox" name="delete[]" value="<?php echo $result['id']; ?>" class="wpsqt-delete" /></td>
					<th scope="row"><?php echo $result['id']; ?></th>
					<td class="column-title">
						<strong>
							<a class="row-title" href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&resultid=<?php echo $result['id']; ?>"><?php echo esc_html(wp_kses_stripslashes($result['person_name'])); ?></a>
						</strong>
						<div class="row-actions">
							<span class="mark"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=mark&id=<?php echo urlencode($_GET['id']); ?>&resultid=<?php echo $result['id']; ?>">Mark</a> | </span>
							<span class="delete"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=resultsdelete&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&resultid=<?php echo $result['id']; ?>">Delete</a></span>
						</div>
					</td>
					<td><?php if($result['total'] == 0) {echo "Unable to auto mark";} else {echo $result['score']."/".$result['total'];} ?></td>
					<td><?php if($result['total'] == 0) {echo "Unable to auto mark";} else {echo $result['percentage']."%";} ?></td>
					<td><font color="<?php if ($result['pass'] == 1) {echo "green";} else {echo "#FF0000";} ?>"><?php if ($result['pass'] == 1) {echo "Pass";} else {echo "Fail";} ?></font></td>
					<td><font color="<?php if ( ucfirst($result['status']) == 'Unviewed' ) {?>#000000<?php } elseif ( $result['status'] == 'Accepted' ){ ?>green<?php } else { ?>#FF0000<?php } ?>"><?php echo ucfirst($result['status']); ?></font></td>
					<td><?php if (!empty($result['datetaken'])) { echo date('d-m-y G:i:s',$result['datetaken']); } else { echo '-'; } ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		
		<div class="tablenav">
		
			<div class="tablenav-pages">			   
				<a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&export=csv&id=<?php echo urlencode($_GET['id']); ?>">Export CSV</a>
		   		<?php echo Wpsqt_Core::getPaginationLinks($currentPage, $numberOfPages); ?>	
			</div>
		</div>
		<input type="submit" name="deleteselected" value="Delete Selected" /><br /><br />
		<input type="checkbox" name="hideanon" value="hide" id="wpsqt-hideanon" /><label for="wpsqt-hideanon">Hide results with username Anonymous</label>
	</form>
</div>
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>
