
<?php 
if ( isset($redirectUrl) ){
?>
<script type="text/javascript">
window.location = "<?php echo $redirectUrl; ?>";
</script>
<?php 
	exit;
}

if ( empty($validData) ){
	$validData = array(array('name' => '', 'difficulty' => '', 'type' => '', 'number' => '','orderby' => ''));
}
?>
<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>
		WP Survey And Quiz Tool - Survey Sections
	</h2>
	
	<?php require WPSQT_DIR.'pages/admin/misc/navbar.php'; ?>
	
	<?php if ( isset($successMessage) ) {?>
		<div class='updated'><?php echo $successMessage; ?></div>
				
	<?php } ?>
	
	<?php if ( isset($_GET['new']) &&  $_GET['new'] == "true" ) { ?>
	<div class="updated">
		<strong>Survey successfully added.</strong>
	</div>
	<?php } ?>
	
	<?php if ( isset($errorArray) && !empty($errorArray) ) { ?>
		<ul class="error">
			<?php foreach($errorArray as $error ){ ?>
				<li><?php echo $error; ?></li>
			<?php } ?>
		</ul>
	<?php } ?>
	<form method="POST" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" id="section_form">
	
		<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />
		<table class="form-table" id="section_table" >
				<thead>
					<tr>
						<th>Name</th>
						<th>Limit</th>
						<th>Number Of Questions</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody>	
					<?php foreach ($validData as $key => $data) {?>			
					<tr>
						<td>							
							<input type="hidden" name="sectionid[<?php echo $key; ?>]" value="<?php echo $data['id']; ?>" />
							<input type="text" name="section_name[<?php echo $key; ?>]" value="<?php echo stripslashes($data['name']); ?>" size="30" id="name_<?php echo $key; ?>" />
						</td>
						<td><input type="text" name="number[<?php echo $key; ?>]" value="<?php echo $data['limit']; ?>" size="10" id="number_<?php echo $key; ?>" /></td>
						<td>
							<select name="order[<?php echo $key; ?>]">
								<option value="asc"<?php if ($data['order'] == 'asc'){?> selected="yes"<?php }?>>Ascending</option>
								<option value="desc"<?php if ($data['order'] == 'desc'){?> selected="yes"<?php }?>>Descending</option>
								<option value="random"<?php if ($data['order'] == 'random'){?> selected="yes"<?php }?>>Random</option>
							</select>
						</td>
						<td><input type="checkbox" name="delete[<?php echo $key; ?>]" value="yes" />
					</tr>
					<?php } ?>
				</tbody>
		</table>
		<input type="hidden" name="row_count" id="row_count" value="<?php echo sizeof($validData); ?>" />
		<p><a href="#" class="button-secondary" title="Add New Section" id="add_section_surveys">Add Section</a></p>
			
		<p class="submit">
			<input class="button-primary" type="submit" name="Save" value="Save" id="submitbutton" />
		</p>
	</form>

		
	<a name="difficutly_def"></a>
	
	<h4>Type Meanings</h4>

	<ul>
		<li><strong>Multiple Choice</strong> - Displays options given as well as a 'other' field which has a text input.</li>
		<li><strong>Scale</strong>  - Displays a question with a scale of 1 to 10 for users to select.</li>
	</ul>
</div>
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>
