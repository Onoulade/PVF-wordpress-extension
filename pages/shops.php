<?php

function PVF_shops_page() {
	$return = "";

	$return = "<table>";
	$return .= "<tr>";
	$return .= '<th>Nom</th>';
	$return .= '<th>Propiétaire</th>';
	$return .= '<th width="200">Position</th>';
	$return .= '<th>Vendu</th>';
	$return .= "</tr>";

	$query = new WP_Query(array(
	    'post_type' => 'magasin',
	    'post_status' => 'private',
		'posts_per_page' => -1
	));


	while ($query->have_posts()) {
		$query->the_post();
		$id = get_the_ID();
		$post = get_post($id);
		$permalink = get_post_permalink($id);
		$custom = get_post_custom($id);

		$x = $custom['position_x'][0];
		$z = $custom['position_z'][0];

		$items = "";

		$items_sold = "";
		if (!empty($custom['items_sold'])) {
			$items_sold = $custom['items_sold'][0];
		}
		$json = json_decode($items_sold);

		if(is_array($json) && count($json) > 0) {
			foreach ($json as $item) {
				$item_data = find_stored_item($item);
				$items .= '<i class="icon-minecraft '.$item_data["css"].'"></i>';
			}
		}

		$return .= "<tr>";
		$return .= '<td>'.$post->post_title.'</td>';
		$return .= '<td>'.$custom["proprietaires"][0].'</td>';
		$return .= '<td><div class="mc-box" style="width:100%"><span class="mc-text">X </span><div class="mc-slot"><span class="mc-text">'.$x.'</span></div>
		<i class="mc-spacer"></i>
		<span class="mc-text">Z </span><div class="mc-slot"><span class="mc-text">'.$z.'</span></div></div></td>';
		$return .= '<td>'.$items.'</td>';
		$return .= "</tr>";
	}

	wp_reset_query();

	$return .= "</table>";

	return $return;
}
