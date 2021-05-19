<?php

function PVF_players_box($players = array(), $align = "") {
	$return = '<div class="players-display-block '.$align.'">';
	foreach($players as $player) {
		$return .= PVF_player_view($player);
	}
	$return .= "</div>";

	return $return;
}

function PVF_player_view($player = "") {
	$user = PVF_get_user_by_name($player);
	$user_id = $user[0]->user_id;
	$playerLink = '<span class="mc-text">'.$player.'</span>';
	if (!empty($user_id)) {
		$playerLink = '<a class="mc-text" href="'.get_author_posts_url($user_id).'">'.$player.'</a>';
	}


	$uid = uniqid();
	$return = '
	<div class="mc-player-card-block">
	<div class="player-container">
		<div class="mc-player mc-player-'.$uid.'">
			<div class="head">
				<div class="top"></div>
				<div class="front"></div>
				<div class="left"></div>
				<div class="right"></div>
				<div class="back"></div>
				<div class="bottom"></div>
			</div>
			<div class="torso">
				<div class="top"></div>
				<div class="front"></div>
				<div class="left"></div>
				<div class="right"></div>
				<div class="back"></div>
				<div class="bottom"></div>
			</div>
			<div class="left-arm">
				<div class="top"></div>
				<div class="front"></div>
				<div class="left"></div>
				<div class="right"></div>
				<div class="back"></div>
				<div class="bottom"></div>
			</div>
			 <div class="right-arm">
				<div class="top"></div>
				<div class="front"></div>
				<div class="left"></div>
				<div class="right"></div>
				<div class="back"></div>
				<div class="bottom"></div>
			</div>
			<div class="left-leg">
				<div class="top"></div>
				<div class="front"></div>
				<div class="left"></div>
				<div class="right"></div>
				<div class="back"></div>
				<div class="bottom"></div>
			</div>
			<div class="right-leg">
				<div class="top"></div>
				<div class="front"></div>
				<div class="left"></div>
				<div class="right"></div>
				<div class="back"></div>
				<div class="bottom"></div>
			</div>
		</div>
		</div>
		'.$playerLink.'
		</div>
	<script>
		displayMCSkin("'.$player.'", "'.$uid.'")
	</script>';
	return $return;
}
