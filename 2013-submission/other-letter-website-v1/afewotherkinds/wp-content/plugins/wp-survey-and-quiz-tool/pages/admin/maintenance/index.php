<div class="wrap">
	
	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Maintenance</h2>	
	
	<div id="nav">
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab nav-tab-active" href="<?php echo WPSQT_URL_MAINENTANCE; ?>">Status</a>
			<a class="nav-tab" href="<?php echo WPSQT_URL_MAINENTANCE; ?>&section=backup">Backup</a>
			<a class="nav-tab" href="<?php echo WPSQT_URL_MAINENTANCE; ?>&section=uninstall">Uninstall</a>
			<a class="nav-tab" href="<?php echo WPSQT_URL_MAINENTANCE; ?>&section=upgrade">Upgrade</a>
			<a class="nav-tab" href="<?php echo WPSQT_URL_MAINENTANCE; ?>&section=debug">Debug</a>
		</h2>
	</div>
	
	<div class="wpsqt-maintenance">
		<h3>Check For Updates</h3>
			<dl class="wpsqt">
				<dt>Most recent version of plugin:</dt>
				<dd><?php echo $version; ?></dd>
				
				<dt>Current version you are running:</dt>
				<dd><?php echo WPSQT_VERSION; ?></dd>
				
				<dt>Database upgrade required: </dt>
				<dd><?php if (isset($update) && $update == true) { echo 'Yes'; } else { echo 'No'; }?></dd>
			</dl>
			
			<p></p><strong><?php if(version_compare(WPSQT_VERSION, $version) < 0) { echo '<font color="#FF0000">Update required, visit the plugin update page to do so.</font>'; } else { echo '<font color="green">You are currently running the most recent version of the plugin</font>'; if(isset($update) && $update == true) { echo '<font color="#FF0000">&nbsp;but you need to <a href="'.WPSQT_URL_MAINENTANCE.'&section=upgrade">upgrade your database</a>.</font>'; } else { echo '<font color="green">&nbsp;and no upgrades are necessary.</font>'; } } ?></strong></p>
	</div>	
	
	
</div>	
<?php require_once WPSQT_DIR."/pages/admin/shared/image.php"; ?>