<?php


function PVF_trades_page() {
	global $wpdb;

	$strJsonFileContents = file_get_contents(PVF_PLUGIN_DIR . "data/items.json");
	$items = json_decode($strJsonFileContents, true);

	$return = "<table>";
	$return .= "<tr>";
	$return .= '<th width="50"></th>';
	$return .= '<th>Item</th>';
	$return .= '<th width="150">PMI</th>';
	$return .= '<th>Magasins</th>';
	$return .= "</tr>";

	foreach ($items as $item) {
		if(empty($item['visible']) || !$item['visible']) continue;
		$css = !empty($item["css"]) ? $item["css"] : "";
		$label = !empty($item["label"]) ? $item["label"] : "";
		$prix = !empty($item["p_min"]) ? $item["p_min"] : "";
		$quantite = !empty($item["quantite"]) ? $item["quantite"] : "";
		$magasins = "";


		$result = $wpdb->get_results( "SELECT post_id FROM wp_postmeta WHERE meta_key = 'items_sold' AND meta_value LIKE '%\"" . $item["name"] . "\"%'");
		if(count($result) > 0) {
			foreach ($result as $value) {
				$id = $value->post_id;
				$post = get_post($id);
				$magasins .= '<a href="'.get_post_permalink($id).'">'.$post->post_title.'</a>, ';
			}

			$magasins = substr_replace($magasins ,"", -2);
		}



		$return .= "<tr>";
		$return .= '<td><i class="icon-minecraft '.$css.'"></i></td>';
		$return .= '<td>'.$label.'</td>';
		$return .= '<td><b>'.$prix.'</b> <span class="minecraft-font">d</span> pour <b>'.$quantite.'</b></td>';
		$return .= '<td>'.$magasins.'</td>';
		$return .= "</tr>";
	}

	$return .= "</table>";

	return $return;

}
