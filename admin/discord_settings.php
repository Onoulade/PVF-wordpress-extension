<?php

function PVF_discord_settings_page() {
	?>
	<div class="wrap">
<?php PVF_options_admin_header(1) ?>

<form method="post" action="options.php">
    <?php settings_fields( 'PVF_settings' ); ?>
    <?php do_settings_sections( 'PVF_settings' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Server ID</th>
        <td>
			<input class="regular-text" type="text" name="guild_id" value="<?php echo esc_attr( get_option('guild_id') ); ?>" /> <br>
			<p class="description">L'ID du serveur discord</p>
		</td>
		</tr>

		<tr valign="top">
        <th scope="row">App ID</th>
        <td>
			<input class="regular-text" type="text" name="app_id" value="<?php echo esc_attr( get_option('app_id') ); ?>" /> <br>
			<p class="description">L'ID de l'app discord</p>
		</td>
        </tr>

		<tr valign="top">
        <th scope="row">App Secret</th>
        <td>
			<input class="regular-text" type="text" name="app_secret" value="<?php echo esc_attr( get_option('app_secret') ); ?>" /> <br>
			<p class="description">L'ID secret de l'app discord</p>
		</td>
        </tr>

        <tr valign="top">
        <th scope="row">Bot Token</th>
        <td>
			<input class="regular-text" type="text" name="bot_token" value="<?php echo esc_attr( get_option('bot_token') ); ?>" /> <br>
			<p class="description">Le token du bot de l'app discord</p>
		</td>
        </tr>
    </table>

    <?php submit_button(); ?>

</form>
<hr>
<p>
	Une fois les informations sur l'application entrées, vous devez autoriser le bot sur votre serveur en cliquant sur ce lien :<br>
	<a target="_blank" href="https://discord.com/oauth2/authorize?client_id=<?php echo esc_attr( get_option('app_id') ); ?>&scope=bot">
	https://discord.com/oauth2/authorize?client_id=<?php echo esc_attr( get_option('app_id') ); ?>&scope=bot
	</a>
	<br><br>
	Une fois le bot ajouté, vous pouvez vérifier le bon état de la connexion à votre serveur :
	<button onclick="check_discord_server_connection(this)">Vérifier</button>
</p>

<script>
function check_discord_server_connection(button) {
	button.innerHTML = "Vérification en cours...";
	var se_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
	var url = se_ajax_url + '?action=PVF_discord_member_list_lookup';
	jQuery.getJSON(url, function(data) {
		if(data.message) {
			button.innerHTML = "Erreur : " + data.message;
		}
		else if(data == null) {
			button.innerHTML = "Erreur";
		}
		else {
			button.innerHTML = "Connecté !"
		}
	});
}

</script>
</div>

	<?php
}
