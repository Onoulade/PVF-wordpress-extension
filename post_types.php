<?php


function PVF_register_post_types() {

	$show_ui = !is_admin();
	$show_in_menu = is_admin() ? 'PVF-commu-content' : true;

	$PVF_post_base = array(
		'labels' => array (
			'name' => __( 'Bases', 'base' ),
		),
		'description' => 'Le modèle pour créer des bases',
		'supports' => array( 'title', 'editor'),
		'public' => true,
		'menu_position' => 3,
		'has_archive' => false,
		'show_ui' => true,
		'show_in_menu' => $show_in_menu,
		'rewrite' => array('slug' => 'base', ),
		'capability_type' => array('PVF-communaute-donnee', 'PVF-communaute-donnees'),
		'map_meta_cap' => true

	);

	$PVF_post_projet = array(
		'labels' => array (
			'name' => __( 'Projets', 'projet' ),
		),
		'description' => 'Le modèle pour créer des projets',
		'supports' => array( 'title', 'editor' ),
		'public' => false,
		'menu_position' => 3,
		'has_archive' => false,
		'show_ui' => true,
		'show_in_menu' => $show_in_menu,
		'rewrite' => array('slug' => 'projet', ),
		'capability_type' => array('PVF-communaute-donnee', 'PVF-communaute-donnees'),
		'map_meta_cap' => true

	);

	$PVF_post_magasin = array(
		'labels' => array (
			'name' => __( 'Magasins', 'magasin' ),
		),
		'description' => 'Le modèle pour créer des magasins',
		'supports' => array( 'title', 'editor' ),
		'public' => true,
		'menu_position' => 3,
		'has_archive' => false,
		'show_ui' => true,
		'show_in_menu' => $show_in_menu,
		'rewrite' => array('slug' => 'magasin', ),
		'capability_type' => array('PVF-communaute-donnee', 'PVF-communaute-donnees'),
		'map_meta_cap' => true

	);

	$PVF_post_ferme = array(
		'labels' => array (
			'name' => __( 'Fermes', 'ferme' ),
		),
		'description' => 'Le modèle pour créer des fermes',
		'supports' => array( 'title', 'editor' ),
		'public' => false,
		'menu_position' => 3,
		'has_archive' => false,
		'show_ui' => true,
		'show_in_menu' => $show_in_menu,
		'rewrite' => array('slug' => 'ferme', ),
		'capability_type' => array('PVF-communaute-donnee', 'PVF-communaute-donnees'),
		'map_meta_cap' => true

	);

	$PVF_page_accueil = array(
		'labels' => array (
			'name' => __( 'Accueil', 'accueil' ),
		),
		'description' => 'Le modèle pour l\'accueil',
		'supports' => array( 'title', 'editor' ),
		'public' => false,
		'menu_position' => 3,
		'has_archive' => true,
		'show_ui' => true,
		'show_in_menu' => $show_in_menu,
		'rewrite' => array('slug' => 'ferme', ),
		'capability_type' => array('PVF-communaute-admin', 'PVF-communaute-admins'),
		'map_meta_cap' => true

	);



	register_post_type("base", $PVF_post_base);
	register_post_type("projet", $PVF_post_projet);
	register_post_type("magasin", $PVF_post_magasin);
	register_post_type("ferme", $PVF_post_ferme);

}

function PVF_author_filter($content) {
	return "lol";
}

function PVF_content_filter($content) {
	global $post;

	switch ($post->post_type) {
		case 'base':
			return PVF_base_content_filter($content);
			break;
		case 'magasin':
			return PVF_magasin_content_filter($content);
			break;

		default:
			return $content;
	}
}
