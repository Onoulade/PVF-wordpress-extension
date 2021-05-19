<?php

function PVF_items_sold_table($items, $show_prices = false) {
	$json = json_decode($items);
	if(!is_array($json) || count($json) == 0) {
		return;
	}

	$return = "<h3>A la vente</h3>";
	$return .= '<table>';

	foreach ($json as $item) {
		$item_data = find_stored_item($item);
		$return .= '<tr>';
		$return .= '<td><i class="icon-minecraft '.$item_data['css'].'"></i></td>';
		$return .= '<td>'.$item_data['label'].'</td>';
		$return .= '</tr>';
	}
	$return .= "</table>";

	return $return;
}
