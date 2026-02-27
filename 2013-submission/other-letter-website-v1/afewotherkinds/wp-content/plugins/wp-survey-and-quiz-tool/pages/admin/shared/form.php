<div class="wrap">
	
	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Form</h2>
		
	<?php require WPSQT_DIR.'pages/admin/misc/navbar.php'; ?>
	

	<?php if ( isset($enabled) && $enabled == 'no' ){ ?>
		<div class="error">This quiz/survey doesn't currently have a contact form enabled. This form will enable the contact form on the quiz/survey.</div>
	<?php } ?>
	
	<?php if ( isset($updated) ) { ?>
		<div class="updated"><strong><?php echo $updated; ?></strong></div>
	<?php } ?>	
	
	
	<p>This provides the ability to create a contact form with custom fields with the ability to define which information is required and what information isn't for your quiz or survey. Using this feature will totally override the default form so if you wish to have the same fields you will need to enter them again.</p>
	
	<form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
		
	<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />
		<table id="multi_table" class="form-table">
			<thead>			
				<tr>
					<th>Name</th>
					<th>Type</th>
					<th>Required</th>
					<th>Validate</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($fields as $key =>  $field){ ?>
				<tr>
					<input type="hidden" name="formitemid[<?php echo $key; ?>]" value="<?php echo $field['id']; ?>" />
					<td><input type="text" name="field_name[<?php echo $key; ?>]" value="<?php echo stripslashes($field['name']); ?>" /></td>
					<td><select name="type[<?php echo $key; ?>]"/>
							<option value="text" <?php if ($field['type'] == 'type'){ ?> selected="selected"<?php }?>>Text</option>
							<option value="textarea" <?php if ($field['type'] == 'textarea'){ ?> selected="selected"<?php }?>>Textarea</option>
							<option value="select" <?php if ($field['type'] == 'select') { ?> selected="selected"<?php }?>>Radio Buttons</option>
						</select></td>
					<td><select name="required[<?php echo $key; ?>]">
							<option value="no" <?php if ($field['required'] == 'no'){ ?> selected="selected"<?php }?>>No</option>
							<option value="yes" <?php if ($field['required'] == 'yes'){ ?> selected="selected"<?php }?>>Yes</option>
						</select></td>
					<td><select id="validator_original" name="validation[<?php echo $key; ?>]">
							<?php foreach ( $validators as $validator ){ ?>
							<option value="<?php echo $validator; ?>" <?php if ($field['validation'] == $validator) { ?> selected="selected" <?php } ?>><?php echo $validator; ?></option>
							<?php } ?>	
						</select></td>
					<td><input type="checkbox" name="delete[<?php echo $key; ?>]" value="yes" /></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<input type="hidden" name="row_count" id="row_count" value="<?php echo sizeof($fields); ?>" />
		<p><a href="#" class="button-secondary" id="add_field">Add Field</a></p>
		<p class="submit">
			<input class="button-primary" type="submit" name="Save" value="Save Question" id="submitbutton" />
		</p>
	</form>
	
</div>
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>