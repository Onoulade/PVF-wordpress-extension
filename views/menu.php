<?php

function PVF_commu_menu_item( $items, $args ) {
    if (is_user_logged_in() ) {
        $items .= '<li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item menu-item-home menu-item-has-children ">
			<a href="'. wp_logout_url() .'">Log Out</a>
			<ul class="sub-menu">
				<li>Lol</li>
			</ul>
		</li>';
    }
    elseif (!is_user_logged_in() ) {
        $items .= '<li><a href="'. site_url('wp-login.php') .'">Log In</a></li>';
    }
    return $items;
}
