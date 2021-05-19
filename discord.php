<?php

function PVF_get_discord_user_info($token) {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,"https://discord.com/api/oauth2/@me");

	curl_setopt($ch, CURLOPT_POST, 0);

	// In real life you should use something like:
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token));

	// Receive server response ...
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec($ch);
	$json = json_decode($server_output);
	return $json->user;

	curl_close ($ch);
}

function PVF_discord_member_list() {
	$guildID = esc_attr( get_option('guild_id') );
	$botToken = esc_attr( get_option('bot_token') );

	if(empty($guildID)) {
		return array("message" => "Vous devez d'abord enregistrer l'id du serveur " );
	}

	if(empty($botToken)) {
		return array("message" => "Vous devez d'abord enregistrer le token du bot" );
	}

	$ch = curl_init('https://discordapp.com/api/guilds/' . $guildID . '/members?limit=1000');

	// Set authorization token.
	curl_setopt($ch, CURLOPT_HTTPHEADER, Array('Authorization: Bot ' . $botToken));

	// We don't wanna return the headers ;)
	curl_setopt($ch, CURLOPT_HEADER, 0);

	// Yes..
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	// Give $result the output.
	$result = json_decode(curl_exec($ch));

	// Close the cURL handle.
	curl_close($ch);
	return $result;
}
