<?php

function PVF_pages_settings_page() {
	?>
	<div class="wrap">
<?php PVF_options_admin_header(2) ?>
<?php settings_fields( 'PVF_settings' ); ?>
<?php do_settings_sections( 'PVF_settings' ); ?>
<style>
	.disabled {
		color: #222 !important;
		cursor: pointer;
	}
</style>
<table class="form-table">
    <tr valign="top">
    <th scope="row">Page de connexion</th>
    <td>
		<input class="disabled" type="text" disabled value="[PVF_login_page]" /><br>
		<p class="description">Affiche le bouton de connexion via Discord</p>
	</td>
	</tr>

	<tr valign="top">
    <th scope="row">Page commerce</th>
    <td>
		<input class="disabled" type="text" disabled value="[PVF_trades_page]" /><br>
		<p class="description">Affiche le tableau des items avec leur PMI et les magasins qui les vendent</p>
	</td>
	</tr>

	<tr valign="top">
    <th scope="row">Page magasins</th>
    <td>
		<input class="disabled" type="text" disabled value="[PVF_shops_page]" /><br>
		<p class="description">Affiche la liste des shops</p>
	</td>
	</tr>
</table>
<?php
}
