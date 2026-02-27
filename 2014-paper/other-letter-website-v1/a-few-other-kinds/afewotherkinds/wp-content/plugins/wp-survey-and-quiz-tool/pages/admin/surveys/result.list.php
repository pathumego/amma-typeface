<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Survey Results</h2>

	<?php require WPSQT_DIR.'pages/admin/misc/navbar.php'; ?>

	<form method="post" action="">

		<div class="tablenav">

			<ul class="subsubsub">
				<li>
					<a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=survey&id=<?php echo urlencode($_GET['id']); ?>" <?php if (isset($filter) && $filter == 'all') { ?>  class="current"<?php } ?> id="all_link">All <span class="count">(<?php echo $counts['unviewed_count'] + $counts['accepted_count'] + $counts['rejected_count']; ?>)</span></a>
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
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th class="manage-column" scope="col" width="40">ID</th>
					<th class="manage-column column-title" scope="col">Title</th>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach( $results as $result ){ ?>
				<tr>
					<th scope="row"><?php echo $result['id']; ?></th>
					<td class="column-title">
						<strong>
							<a class="row-title" href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=survey&id=<?php echo urlencode($_GET['id']); ?>&resultid=<?php echo $result['id']; ?>"><?php echo esc_html($result['person_name']);  if (isset($person['email'])){ ?> - <?php echo $person['email']; }  if (isset($result['ipaddress'])) { ?> - <?php  echo $result['ipaddress']; } ?></a>
						</strong>
						<div class="row-actions">
							<span class="view"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=view&id=<?php echo urlencode($_GET['id']); ?>&resultid=<?php echo $result['id']; ?>">View</a> | </span>
							<span class="delete"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=resultsdelete&subsection=survey&id=<?php echo urlencode($_GET['id']); ?>&resultid=<?php echo $result['id']; ?>">Delete</a></span>
						</div>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>

		<div class="tablenav">

			<div class="tablenav-pages">
		   		<?php echo Wpsqt_Core::getPaginationLinks($currentPage, $numberOfPages); ?>
			</div>
		</div>

	</form>
</div>
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>