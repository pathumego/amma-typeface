<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - CatN</h2>
	
	<p>CatN vCluster PHP hosting has been developed specifically for hosting PHP application such as WordPress. Our system is cutting edge and makes use of the newest version of software available such as PHP 5.3.X. If your current host does not regularly update their platform you may find compatibility errors in the future.</p>

	<p>vCluster starts at <strong>&pound;5 per month</strong> which includes a <strong>dedicated static IP</strong> allowing you to have <strong>SSL encrypted sites</strong> at <strong>no extra cost</strong> and the option to host an <strong>unlimited number of websites</strong> on the single package. vCluster is WordPress Multi-Site compatible and you can host <strong>multiple PHP applications</strong> on a single vCluster account.</p>

	<p>Migrating your site to a new host can be difficult and time consuming. Enter into dialogue with our hosting experts and we'll move your site to CatN for <strong>free</strong>, painlessly and quickly! Fill out out the form below!</p>

	<p>For more information take a look at the CatN website <a href="http://www.catn.com">here</a>.</p>
	
	<form method="post" action="<?php echo get_bloginfo("url"); ?>/wp-admin/admin.php?page=<?php echo WPSQT_PAGE_CONTACT; ?>">
		
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
						<option value="Moving to CatN">Moving to CatN</option>
				</select></td>
			</tr>
			<tr>
				<th valign="top" scope="row">Message</th>
				<td><textarea cols="70" rows="5" name="message"></textarea></td>
			</tr>
		</table>
		
		
		<p>
			<input class="button-primary" type="submit" name="Send" value="Send" id="submitbutton" />
		</p>
			
	</form>
</div>
<?php require_once WPSQT_DIR."/pages/admin/shared/image.php"; ?>