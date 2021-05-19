<?php

function PVF_register_settings() {
	register_setting( 'PVF_settings', 'app_id' );
	register_setting( 'PVF_settings', 'guild_id' );
	register_setting( 'PVF_settings', 'app_secret' );
	register_setting( 'PVF_settings', 'bot_token' );
}

function PVF_options_admin_header($active = -1) {
	?>
	<h1 class="wp-heading-inline">Communauté</h1>
	<hr class="wp-header-end">
	<nav class="nav-tab-wrapper wp-clearfix" aria-label="Menu secondaire">
		<a href="admin.php?page=PVF-commu" class="nav-tab <?php echo $active == 0 ? "nav-tab-active" : ""; ?>">Général</a>
		<a href="admin.php?page=PVF-commu-discord" class="nav-tab <?php echo $active == 1 ? "nav-tab-active" : ""; ?>">Bot Discord</a>
		<a href="admin.php?page=PVF-commu-pages" class="nav-tab <?php echo $active == 2 ? "nav-tab-active" : ""; ?>">Pages</a>
		<a href="admin.php?page=PVF-commu-trade" class="nav-tab <?php echo $active == 3 ? "nav-tab-active" : ""; ?>">Commerce</a>
	</nav>
	<?php
}


function PVF_settings_page() {
	?>
	<div class="wrap">
<?php PVF_options_admin_header(0) ?>
</div>
	<?php
}
