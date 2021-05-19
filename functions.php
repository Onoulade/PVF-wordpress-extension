<?php
function PVF_clean_content_meta_display($content) {
	return preg_replace("/#- (.+) -#/sm", "", $content);
}

function PVF_proprietaires_string_to_array($str) {
	$str = preg_replace("/, $/", "", $str);
	return preg_split("/, /", $str);
}

function PVF_profile_update_errors($errors, $update, $user) {
	var_dump($errors);
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_=+?&#%';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 16; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function PVF_get_user_by_name($name) {
	$name = sanitize_text_field($name);
	global $wpdb;
	$result = $wpdb->get_results( "SELECT * FROM wp_usermeta WHERE meta_key = 'nickname' AND meta_value = '".$name."' LIMIT 0,1");
	return $result;
}

function find_stored_item($name) {
	$strJsonFileContents = file_get_contents(PVF_PLUGIN_DIR . "data/items.json");
	$items = json_decode($strJsonFileContents, true);

	foreach ($items as $item) {
		if($item['name'] == $name) {
			return $item;
		}
	}
}
