<div class="wrap">
	
	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Maintenance</h2>	
	
	<div id="nav">
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab" href="<?php echo WPSQT_URL_MAINENTANCE; ?>">Status</a>
			<a class="nav-tab nav-tab-active" href="<?php echo WPSQT_URL_MAINENTANCE; ?>&section=backup">Backup</a>
			<a class="nav-tab" href="<?php echo WPSQT_URL_MAINENTANCE; ?>&section=uninstall">Uninstall</a>
			<a class="nav-tab" href="<?php echo WPSQT_URL_MAINENTANCE; ?>&section=upgrade">Upgrade</a>
			<a class="nav-tab" href="<?php echo WPSQT_URL_MAINENTANCE; ?>&section=debug">Debug</a>
		</h2>
	</div>
	
	<div class="wpsqt-maintenance">
		<?php if (isset($dirwriteable) && $dirwriteable == false) { ?>
			<strong>Directory not writable or doesn't exist. See error above.</strong>
		<?php } else { ?>
			<form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
			
	 			<p style="text-align:center;">This will create a backup of all the WPSQT databases</p>
				<p style="text-align:center;">Backups are saved to <em>db-backups</em> with the name <em>db-(hour)(minute)(second)-(day)(month)(year).sql</em></p>
				
				<p style="text-align:center;">Please enter your database information.</p>
				
				<p style="text-align:center;">
					<label>Database Host</label> <input type="text" name="host" id="host" /><br />
					<label>Username</label> <input type="text" name="user" id="user" /><br />
					<label>Password</label> <input type="password" name="pass" id="pass" /><br />
					<label>Database Name</label> <input type="text" name="database" id="database" /><br />
				</p>
				
				<p style="text-align:center;">
					<input class="button-primary" type="submit" name="Backup" value="Backup" id="submitbutton" />
				</p>
			</form>
		<?php } ?>
	</div>	
	
	
</div>	
<?php require_once WPSQT_DIR."/pages/admin/shared/image.php"; ?>