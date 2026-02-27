<div class="wrap">
	
	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Help</h2>	
	
	<?php if ( isset($successMessage) ){ ?>
		<div class="updated" id="question_added"><?php echo $successMessage; ?></div>
	<?php } ?>
	
	<?php if ( isset($errorArray) && !empty($errorArray) ) { ?>
		<ul class="error">
			<?php foreach($errorArray as $error ){ ?>
				<li><?php echo $error; ?></li>
			<?php } ?>
		</ul>
	<?php } ?>
	
	<p>All of the documentation is on the <a href="https://github.com/fubralimited/WP-Survey-And-Quiz-Tool/wiki/_pages">GitHub Wiki</a>. If there you cannot find what you need there then feel free to contact us.</p>
	
	<p>The preferred method of contacting us is on the <a href="https://github.com/fubralimited/WP-Survey-And-Quiz-Tool/issues?sort=created&direction=desc&state=open">GitHub Issue Tracker</a>, however if you can't or don't want to use that method please use the form below which will be emailed to us.</p>
	
	<p><strong>Please note that using the form below will result in information such as your current WordPress version and plugin version being sent as well.</strong>
		
	<form method="post" action="<?php echo esc_url($_SERVER["REQUEST_URI"]); ?>">
		
		<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />
		<table class="form-table">
			<tr>
				<th scope="row">Name</th>
				<td><input type="text" name="name" value="" /></td>
			</tr>
			<tr>
				<th scope="row">Email</th>
				<td><input type="text" name="email" value="" /></td>
			</tr>
			<tr>
				<th scope="row">Contact Reason</th>
				<td><select name="reason">
						<option value="Bug">Bug</option>
						<option value="Suggestion">Suggestion</option>
						<option value="Moving to CatN">Moving to CatN</option>
						<option value="You guys rock">You guys rock</option>
						<option value="You guys are the suck!!!">You guys are the suck</option>
				</select></td>
			</tr>
			<tr>
				<th valign="top" scope="row">Message</th>
				<td><textarea cols="70" rows="5" name="message"></textarea></td>
			</tr>
		</table>
	
		<p class="submit">
			<input class="button-primary" type="submit" name="Send" value="Send" id="submitbutton" />
		</p>
		
	</form>
	
</div>	
<?php require_once WPSQT_DIR."/pages/admin/shared/image.php"; ?>