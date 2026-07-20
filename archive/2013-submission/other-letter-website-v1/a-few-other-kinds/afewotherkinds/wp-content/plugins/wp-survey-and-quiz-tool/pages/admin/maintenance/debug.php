<div class="wrap">
	
	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Maintenance</h2>	
	
	<div id="nav">
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab" href="<?php echo WPSQT_URL_MAINENTANCE; ?>">Status</a>
			<a class="nav-tab" href="<?php echo WPSQT_URL_MAINENTANCE; ?>&section=backup">Backup</a>
			<a class="nav-tab" href="<?php echo WPSQT_URL_MAINENTANCE; ?>&section=uninstall">Uninstall</a>
			<a class="nav-tab" href="<?php echo WPSQT_URL_MAINENTANCE; ?>&section=upgrade">Upgrade</a>
			<a class="nav-tab nav-tab-active" href="<?php echo WPSQT_URL_MAINENTANCE; ?>&section=debug">Debug</a>
		</h2>
	</div>
	
	<div class="wpsqt-maintenance">
		<form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
			<p style="text-align:center;">
				<input class="button-primary" type="submit" name="ResetSession" value="Reset Session Data" id="submitbutton" />
			</p>
		
			<p style="text-align:center;">This will reset the session variable.</p>
			<p style="text-align:center;font-weight: bold;">Only run this if you have been told to. Make sure you have a backup.</p>
		
		</form>
		<hr />
		<form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
			<p style="text-align:center;">
				<input class="button-primary" type="submit" name="ManualDb" value="Manually Install Database Tables" id="submitbutton" />
			</p>
		
			<p style="text-align:center;">This will manually install the database tables.</p>
			<p style="text-align:center;font-weight: bold;">Only run this if you received the notice to or are on a multisite install. Make sure you have a backup.</p>
		
		</form>
		<hr />
		<form method="post" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
			
			<p style="text-align:center;">
				<input class="button-primary" type="submit" name="AllUpgrades" value="Run All Previous Upgrades" id="submitbutton" />
			</p>
		
			<p style="text-align:center;">This will run every single possible database upgrade.</p>
			<p style="text-align:center;font-weight: bold;">This can easily corrupt the entire WPSQT database. Only run this if you have to or are instructed to. Make sure you have a backup.</p>
		
		</form>
	</div>	
	
	
</div>	
<?php require_once WPSQT_DIR."/pages/admin/shared/image.php"; ?>