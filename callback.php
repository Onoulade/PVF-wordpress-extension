<?php
include_once("../../../wp-load.php");
session_start();

if(empty($_GET['access_token']) && empty($_POST['minecraf_username'])) {
	?>
	<script>
		window.location.href=window.location.hash.replace(/#/, "?");
	</script>
	<?php
}
else if(!empty($_GET['access_token']) && empty($_POST['minecraf_username'])) {
	$token = addslashes($_GET['access_token']);
	$requested_user = PVF_get_discord_user_info($token);

	$user = get_user_by( 'login', $requested_user->id );
	if($user) {
		$user_id = $user->ID;
		$user_login = $requested_user->id;
		wp_set_current_user($user_id, $user_login);
        wp_set_auth_cookie($user_id);
        do_action('wp_login', $user_login);
		var_dump(is_user_logged_in());
		exit();
	}

	$list = PVF_discord_member_list();
	foreach($list as $user) {
		if($user->user->id == $requested_user->id) {
			$_SESSION['PVF_discord_id'] = $user->user->id;
			$_SESSION['PVF_discord_pseudo'] = $user->user->username;
			$_SESSION['PVF_member_since'] = $user->joined_at;
			$_SESSION['PVF_token'] = $token;
			?>
				On y est presque <b><?php echo $user->user->username ?></b>, il ne reste plus qu'a entrer votre pseudo Minecraft :
				<form action="callback.php" method="POST">
					<input type="text" name="minecraf_username" />
					<input type="submit" value="C'est parti !" />
				</form>

			<?php
		}

	}
}
else if(!empty($_POST['minecraf_username']) && !empty($_SESSION['PVF_discord_id']) && !empty($_SESSION['PVF_discord_pseudo']) && !empty($_SESSION['PVF_member_since']) && !empty($_SESSION['PVF_token'])) {
	$username = stripslashes($_POST['minecraf_username']);
	if(username_exists($username)) {
		wp_die("Ce pseudo Minecraft est déjà enregistré sur PVF, merci de contacter Barenn7 si vous pensez que c'est une erreur.");
	}
	else {
		$password = randomPassword();
		$user_id = wp_create_user( $_SESSION['PVF_discord_id'], $password, "" );

		$user = get_user_by( 'id', $user_id );
		$user->remove_role( 'subscriber' );
		$user->add_role( 'player' );
		wp_update_user( array ('ID' => $user->ID, 'display_name' => $username, 'nickname' => $_SESSION['PVF_discord_pseudo'], 'last_name' => $_SESSION['PVF_discord_pseudo']));
		add_user_meta($user_id, "discord_token", $_SESSION['PVF_token']);
		add_user_meta($user_id, "member_since", $_SESSION['PVF_member_since']);

	}
}
?>
