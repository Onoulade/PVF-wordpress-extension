<?php

function PVF_magasin_content_filter( $content ) {
	global $post;
	$pre_ = '';
	$post_ = '';

	$custom = get_post_custom($post->ID);
    if ( get_post_type() == "magasin" ) {

		$position = PVF_position_view($custom['position_x'][0], $custom['position_z'][0], $custom['dimension'][0]);
		$proprios = PVF_proprietaires_string_to_array($custom["proprietaires"][0]);
		$proprietaires = PVF_players_box($proprios);
		$items_sold = PVF_items_sold_table($custom["items_sold"][0]);

		if(preg_match("/\#- position -\#/", $content)) {
			$content = preg_replace("/#- position -#/", $position, $content);
		}
		else {
			$pre_ .= $position;
		}

		if(preg_match("/\#- proprietaires -\#/", $content)) {
			$content = preg_replace("/\#- proprietaires -\#/", $proprietaires, $content);
		}
		else {
			$pre_ .= $proprietaires;
		}

		if(preg_match("/\#- vendu -\#/", $content)) {
			$content = preg_replace("/\#- vendu -\#/", $items_sold, $content);
		}
		else {
			$pre_ .= $items_sold;
		}

		$content = PVF_clean_content_meta_display($content);

		//$post_ = PVF_players_box(array("Onoulade"));

    }
    return $pre_.$content.$post_;
}
?>
