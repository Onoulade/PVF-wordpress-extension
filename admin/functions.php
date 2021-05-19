<?php

function PVF_update_admin_role() {
	$role = get_role( 'administrator' );
	$slugs = array('PVF-communaute-donnee', 'PVF-communaute-donnees');

	PVF_update_capabilities($role, $slugs);

	$role->add_cap( 'delete_others_'.$slugs[1] );
	$role->add_cap( 'edit_others_'.$slugs[1]);
}

function PVF_register_player_role() {
	//remove_role('player');
	add_role("player", "Player");
	$role = get_role( 'player' );
	$slugs = array('PVF-communaute-donnee', 'PVF-communaute-donnees');
	PVF_update_capabilities($role, $slugs);
	$role->add_cap( 'read' );

}

function PVF_footer_text_admin () {
    echo '<span id="footer-thankyou">Merci de faire confiance à Onoulade !</span>';
}

function PVF_footer_admin() {
	?>
	<script>
		jQuery(".wp-list-table.widefat.plugins").find(".active").each(function() {
			if(this.getAttribute('data-slug') == "pvf-communaute") {
				var descr = jQuery(this).find(".plugin-description");
				descr.css("position", "relative");
				descr[0].innerHTML += '<img src="<?php echo PVF_PLUGIN_URI ?>inc/tenor.gif" style="float: right;position: absolute;height: 110px;top: -44px;right:10px;" />'
			}
		});
	</script>
	<?php
}

function PVF_header_admin() {
	?>
	<link rel="stylesheet" href="<?php echo PVF_PLUGIN_URI ?>inc/style.css" />
	<link rel="stylesheet" href="<?php echo PVF_PLUGIN_URI ?>inc/icons-minecraft-0.43.css" />
	<?php
}

function PVF_discord_member_list_lookup() {
	if(!is_admin()) {
		echo json_encode(array("message" => "Seul l'admin peut effectuer cette requête" ));
		die();
	}

	$result = PVF_discord_member_list();
	echo json_encode($result);

	die();


}

function PVF_users_lookup() {
    global $wpdb;

    $search = $wpdb->esc_like($_REQUEST['q']);
	$user_query = new WP_User_Query( array( 'role' => 'player', 'search' => $search ) );

	$results = array();

	foreach ($user_query->get_results() as $user) {
		$results[] = $user->display_name;
	}
	echo json_encode($results);

    die();
}

function PVF_player_stop_access_profile() {
	remove_menu_page( 'index.php' );
    remove_menu_page( 'profile.php' );
    remove_submenu_page( 'users.php', 'profile.php' );
}

function PVF_disable_player_profile() {
	$user = wp_get_current_user(); // getting & setting the current user
	$roles = ( array ) $user->roles;

    if(in_array("player", $roles)) {
		wp_die("Vous ne pouvez pas éditer votre profil pour le moment !");
	}

}

function PVF_edit_title_admin_list_table($states, $id) {
	return [];
}

function PVF_item_search() {
	$search = sanitize_text_field($_GET['term']);

	$strJsonFileContents = file_get_contents(PVF_PLUGIN_DIR . "data/items.json");
	$items = json_decode($strJsonFileContents, true);
	$return = array();

	foreach($items as $item) {
		if(!empty($_GET["already"]) && in_array($item["name"], $_GET["already"])) {
			continue;
		}
		if((strpos($item["label"], $search) !== false || strpos($item["name"], $search) !== false) && $item["visible"] == true) {
			$return[] = $item;
		}
	}

	echo json_encode($return);
	wp_die();
}

function PVF_save_item() {
	if(!is_admin()) {
		die();
	}

	$id = sanitize_text_field($_POST['item']);
	$label = sanitize_text_field($_POST['label']);
	$p_min = sanitize_text_field($_POST['p_min']);
	$quantite = sanitize_text_field($_POST['quantite']);
	$visible = $_POST['visible'] == "true" ? true : false;

	$strJsonFileContents = file_get_contents(PVF_PLUGIN_DIR . "data/items.json");
	$items = json_decode($strJsonFileContents, true);

	for($i=0;$i<count($items);++$i) {
		$item = $items[$i];
		if($id == $item["name"]) { var_dump($id);
			$item["label"] = $label;
			$item["p_min"] = $p_min;
			$item["quantite"] = $quantite;
			$item["visible"] = $visible;
			$items[$i] = $item;
			break;
		}
	}

	$json = json_encode($items);

	file_put_contents(PVF_PLUGIN_DIR . "data/items.json", $json);

}
