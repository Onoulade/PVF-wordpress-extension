<?php


function PVF_login_page() {
	return "<button>Se connecter avec discord !</button><br>https://discord.com/api/oauth2/authorize?client_id=".get_option('app_id')."&redirect_uri=http%3A%2F%2Flocalhost%3A8888%2Fcallback.php&response_type=token&scope=identify&expires_in=15552000";
}
