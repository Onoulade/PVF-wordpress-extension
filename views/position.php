<?php

function PVF_position_view($x, $z, $dim) {
	$dimension = PVF_dimension_data($dim);

	if(empty($x)) $x = 0;
	if(empty($z)) $z = 0;
	return '<div class="mc-box PVF_header">
				<div>
					<span class="mc-text">X </span><div class="mc-slot"><span class="mc-text">'.$x.'</span></div>
					<i class="mc-spacer"></i>
					<span class="mc-text">Z </span><div class="mc-slot"><span class="mc-text">'.$z.'</span></div>
				</div>
				<div class="mc-slot"><i class="icon-minecraft icon-minecraft-'.$dimension[1].'"></i><span class="mc-text">'.$dimension[0].'</span></div>
			</div>';
}
