<?php

/*
Plugin Name: PVF - Communauté
Description: Le meilleur plugin de gestion de commu pour un serveur minecraft !
Version: a0.1
Author: Onoulade
*/

define( 'PVF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PVF_PLUGIN_URI', plugin_dir_url( __FILE__ ));


require_once( PVF_PLUGIN_DIR . 'functions.php' );
require_once( PVF_PLUGIN_DIR . 'discord.php' );

require_once( PVF_PLUGIN_DIR . 'admin/discord_settings.php' );
require_once( PVF_PLUGIN_DIR . 'admin/functions.php' );
require_once( PVF_PLUGIN_DIR . 'admin/pages_settings.php' );
require_once( PVF_PLUGIN_DIR . 'admin/settings.php' );
require_once( PVF_PLUGIN_DIR . 'admin/trade_settings.php' );

require_once( PVF_PLUGIN_DIR . 'post_types.php' );
require_once( PVF_PLUGIN_DIR . 'post_fields.php' );

require_once( PVF_PLUGIN_DIR . 'data/biome.php' );

require_once( PVF_PLUGIN_DIR . 'views/base.php' );
require_once( PVF_PLUGIN_DIR . 'views/magasin.php' );

require_once( PVF_PLUGIN_DIR . 'views/player.php' );
require_once( PVF_PLUGIN_DIR . 'views/position.php' );
require_once( PVF_PLUGIN_DIR . 'views/items_table.php' );

require_once( PVF_PLUGIN_DIR . 'views/menu.php' );

require_once( PVF_PLUGIN_DIR . 'pages/login.php' );
require_once( PVF_PLUGIN_DIR . 'pages/shops.php' );
require_once( PVF_PLUGIN_DIR . 'pages/trades.php' );

register_activation_hook( __FILE__, "PVF_setup" );


add_action('init', 'PVF_register_post_types');
add_action('init', 'PVF_register_player_role');
add_action('init', 'PVF_register_ajax_methods');
add_action('init', 'PVF_javascript_files');

add_action('admin_menu', 'PVF_register_edit_page');
add_action('admin_menu', 'PVF_register_settings');
add_action('admin_menu', 'PVF_update_admin_role');
add_action('admin_menu', 'PVF_remove_vanilla_publish_box');
add_action('admin_menu', 'PVF_player_stop_access_profile' );

add_filter('admin_footer_text', 'PVF_footer_text_admin');
add_filter('admin_head', 'PVF_header_admin');
add_filter('admin_footer', 'PVF_footer_admin');

add_action('add_meta_boxes', 'PVF_register_post_fields' );
add_action('save_post', 'PVF_save_details');

add_action('wp_head', 'PVF_html_head');

add_filter( 'the_content', 'PVF_content_filter' );
add_filter( 'the_author', 'PVF_author_filter' );

add_filter('wp_insert_post_data', 'force_type_private');
add_action('user_profile_update_errors', 'PVF_profile_update_errors', 10, 3 );
add_filter( 'wp_nav_menu_items', 'PVF_commu_menu_item', 10, 2);

add_action( 'load-profile.php', 'PVF_disable_player_profile' );

add_filter('display_post_states', 'PVF_edit_title_admin_list_table', 100, 2 );

// Shortcodes for pages
add_shortcode('PVF_login_page', 'PVF_login_page');
add_shortcode('PVF_shops_page', 'PVF_shops_page');
add_shortcode('PVF_trades_page', 'PVF_trades_page');


function PVF_setup() {
	// create pages
	wp_insert_post(array(
		'post_title'    => "Communauté" ,
		'post_content'  => "[PVF_login_page]",
		'post_status'   => 'private',
		"post_type" 	=> "page"
	));

	wp_insert_post(array(
		'post_title'    => "Communauté" ,
		'post_content'  => "[PVF_login_page]",
		'post_status'   => 'private',
		"post_type" 	=> "page"
	));
}


function PVF_register_ajax_methods() {
	if(is_user_logged_in()) {
		add_action('wp_ajax_PVF_users_lookup', 'PVF_users_lookup');
		add_action('wp_ajax_PVF_item_search', 'PVF_item_search');
	}

	if (is_admin()) {
		add_action('wp_ajax_PVF_discord_member_list_lookup', 'PVF_discord_member_list_lookup');
		add_action('wp_ajax_PVF_save_item', 'PVF_save_item');
	}
}


function PVF_register_edit_page() {
  add_menu_page('PVF - réglages', 'PVF - Réglages', 'manage_options', 'PVF-commu', 'PVF_settings_page', "dashicons-block-default", 3);
  add_submenu_page('PVF-commu', 'PVF - Discord', 'Discord', 'manage_options', 'PVF-commu-discord', 'PVF_discord_settings_page');
  add_submenu_page('PVF-commu', 'PVF - Pages', 'Pages', 'manage_options', 'PVF-commu-pages', 'PVF_pages_settings_page');
  add_submenu_page('PVF-commu', 'PVF - Commerce', 'Commerce', 'manage_options', 'PVF-commu-trade', 'PVF_trade_settings_page');

  add_menu_page('PVF - Communauté', 'Contenu', 'manage_options', 'PVF-commu-content', 'PVF_options_page', "dashicons-archive", 3);
}

function PVF_update_capabilities($role, $slug) {
	$role->add_cap( 'read_'.$slug[0]);
	$role->add_cap( 'read_private_'.$slug[0] );
	$role->add_cap( 'read_private_'.$slug[1] );
	$role->add_cap( 'edit_'.$slug[0] );
	$role->add_cap( 'edit_'.$slug[1] );
	$role->add_cap( 'edit_published_'.$slug[1] );
	$role->add_cap( 'publish_'.$slug[1] );
	$role->add_cap( 'delete_'.$slug[0] );
	$role->add_cap( 'delete_private_'.$slug[1] );
	$role->add_cap( 'delete_published_'.$slug[1] );
}

function force_type_private($post){

    if ($post['post_type'] == 'base' || $post['post_type'] == 'magasin' || $post['post_type'] == 'projet') {
		if ($post['post_status'] == 'publish') {
			$post['post_status'] = 'private';
		}
		if($post['post_status'] == 'private') {
			$post['post_password'] = "";
		}
	}

    return $post;
}

function PVF_javascript_files() {
	wp_enqueue_script("player", PVF_PLUGIN_URI."inc/player.js", array("jquery"));
}

function PVF_html_head() { ?>
	<link rel="stylesheet" href="<?php echo PVF_PLUGIN_URI ?>inc/style.css" />
	<link rel="stylesheet" href="<?php echo PVF_PLUGIN_URI ?>inc/player.css" />
	<link rel="stylesheet" href="<?php echo PVF_PLUGIN_URI ?>inc/icons-minecraft-0.43.css" />
<?php }
