<?php

function PVF_register_post_fields() {

	add_meta_box(
	    'guide', // $id
	    'Guide', // $title
	    'PVF_guide_field', // $callback
	    array('base', 'magasin', 'projet'), // $screen
	);

	add_meta_box(
	    'position', // $id
	    'Position', // $title
	    'PVF_position_field', // $callback
	    array('base', 'magasin', 'projet'), // $screen
	    'side', // $context
	    'high' // $priority
	);

	add_meta_box(
	    'proprietaire', // $id
	    'Propiétaire(s)', // $title
	    'PVF_proprietaires_field', // $callback
	    array('base', 'magasin', 'projet'), // $screen
	    'side', // $context
	    'high' // $priority
	);

	add_meta_box(
	    'publier', // $id
	    'Publier', // $title
	    'PVF_publish_field', // $callback
	    array('base', 'magasin', 'projet'), // $screen
	    'side', // $context
	    'high' // $priority
	);

	add_meta_box(
	    'vente', // $id
	    'A la vente', // $title
	    'PVF_sell_field', // $callback
	    array('magasin'), // $screen
	    'normal', // $context
	    'high' // $priority
	);
}



function PVF_guide_field() { ?>
	<h3>Bienvenue dans l'aide ! </h3>
	<pre>#- position -#</pre>
	<pre>#- proprietaires -#</pre>
	<pre>#- vendu -#</pre>
<?php }

function PVF_publish_field() {
	?>
<input type="submit" name="publish" id="publish" class="button button-primary button-large" value="Publier" style="width: 100%">
	<?php
}

function PVF_position_field() {
	global $post;

	$dimensions = PVF_dimension_data();
	$custom = get_post_custom($post->ID);

	$x = 0;
	if (!empty($custom["position_x"][0])) {
		$x = $custom["position_x"][0];
	}

	$z = 0;
	if (!empty($custom["position_z"][0])) {
		$z = $custom["position_z"][0];
	}


	?>
	<table width="100%">
		<tr>
			<td width="50%">X : <input type="number" size="6" style="width: calc(100% - 40px)" required name="position_x" value="<?php echo $x; ?>" /></td>
			<td>Z : <input type="number" size="6" style="width: calc(100% - 40px)" name="position_z" required value="<?php echo $z; ?>" /></td>
		</tr>
		<tr>
			<td colspan="2">
				<select name="dimension" style="width:100%">
					<?php
						foreach($dimensions as $did => $dimension) {
							$selected = $custom["dimension"][0] == $did ? "selected" : "";
							echo '<option value="'.$did.'" '.$selected.'>'.$dimension[0].'</option>';
						}
					?>
				</select>
			</td>
		</tr>
	</table>
	<?php
}

function PVF_proprietaires_field() {
	global $post;
	$custom = get_post_custom($post->ID);

	$proprietaires = "";
	if (!empty($custom['proprietaires'])) {
		$proprietaires = $custom['proprietaires'][0];
	}

	if ( !current_user_can( 'edit_others_PVF-communaute-donnees' ) ) {
		$name = wp_get_current_user()->display_name;
	    echo "Vous (".$name."), <br>";
		$proprietaires = preg_replace("/".$name.", /", "", $proprietaires);
	}

	?>
	<input value="<?php echo $proprietaires; ?>" name="proprietaires" type="text" id="PVF_proprietaires_input_search" placeholder="Ajoutez d'autres propriétaires" style="width:100%" />
	<script type="text/javascript">
		var se_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
		var url = se_ajax_url + '?action=PVF_users_lookup';
		jQuery( function() {
			function split( val ) {
			  return val.split( /,\s*/ );
			}
			function extractLast( term ) {
			  return split( term ).pop();
			}

			jQuery( "#PVF_proprietaires_input_search" )

			  .on( "keydown", function( event ) {
			    if ( event.keyCode === jQuery.ui.keyCode.TAB &&
			        jQuery( this ).autocomplete( "instance" ).menu.active ) {
			      event.preventDefault();
			    }
			  })
			  .autocomplete({
			    source: function( request, response ) {
			      jQuery.getJSON( url, {
			        term: extractLast( request.term )
			      }, response );
			    },
			    search: function() {

			      var term = extractLast( this.value );
			      if ( term.length < 2 ) {
			        return false;
			      }
			    },
			    focus: function() {

			      return false;
			    },
			    select: function( event, ui ) {
			      var terms = split( this.value );

				  if(terms.indexOf(ui.item.value) != -1) {
					  return false;
				  }

			      terms.pop();

			      terms.push( ui.item.value );

			      terms.push( "" );
			      this.value = terms.join( ", " );
			      return false;
			    }
			  });
			} );
	</script>
	<?php
}

function PVF_sell_field() {
	global $post;
	$custom = get_post_custom($post->ID);

	$items_sold = "";
	if (!empty($custom['items_sold'])) {
		$items_sold = $custom['items_sold'][0];
	}
	?>
	<input value="" name="search_items" type="text" id="PVF_vente_items_input_search" placeholder="Ajoutez des objets à la vente" style="width:100%" />
	<input type="hidden" name="items_sold" id="PVF_vente_items_value" value='<?php echo $items_sold; ?>' />
	<br><br><table id="items_vendus" width="100%">
		<tr>
			<thead>
			<th style="text-align:left;">Item</th>
			<th width="200" style="text-align:left;">PMI</th>
			<th width="50"></th>
		</tr>
		<?php
		$json = json_decode($items_sold);

		if(is_array($json) && count($json) > 0) {
			foreach ($json as $item) {
				$item_data = find_stored_item($item);
				?>
				<tr class="item item-sold-<?php echo $item_data["name"] ?>">
					<td><i class="icon-minecraft <?php echo $item_data["css"] ?>"></i>&nbsp;&nbsp;<?php echo $item_data["label"] ?></td>
					<td><b><?php echo $item_data["p_min"] ?></b> <span class="minecraft-font">d</span> pour <b><?php echo $item_data["quantite"] ?></b> items</td>
					<td><button type="button" class="button-link editinline" onclick="remove_sold_item('<?php echo $item_data["name"] ?>')">Retirer</button></td>
				</tr>
				<?php
			}
		}
		?>
	</table>
	<script type="text/javascript">
		var se_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
		var url = se_ajax_url + '?action=PVF_item_search';
		var sold = <?php
			if(is_array($json) && count($json) > 0) {
				echo "[";
				foreach ($json as $item) {
					echo '"'.$item.'",';
				}
				echo "]";
			}
			else {
				echo "[]";
			}
		?>;
		jQuery(function() {
			jQuery( "#PVF_vente_items_input_search" ).autocomplete({
				source: function( request, response ) {
				  jQuery.getJSON( url, {
					term: request.term,
					already:sold
				  }, response );
				},
				search: function() {

				  var term = this.value;
				  if ( term.length < 2 ) {
					return false;
				  }
				},
				focus: function() {
				  return false;
				},
				select: function( event, ui ) {
					var tr = document.createElement("tr");
					tr.className = "item item-sold-" + ui.item.name;

					var c = '<td><i class="icon-minecraft ' + ui.item.css + '"></i>&nbsp;&nbsp;' + ui.item.label + '</td>';
					c += '<td><b>' + ui.item.p_min + '</b> <span class="minecraft-font">d</span> pour <b>' + ui.item.quantite + '</b> items</td>';
					c += '<td><button type="button" class="button-link editinline" onclick="remove_sold_item(\'' + ui.item.name + '\')">Retirer</button></td>';
					tr.innerHTML = c;

					jQuery("#items_vendus").append(tr);
					sold.push(ui.item.name);
					update_sold_items();
					setTimeout(function() { jQuery("#PVF_vente_items_input_search").val(""); }, 10);
				}
			}).autocomplete( "instance" )._renderItem = function( ul, item ) {
				return jQuery( "<li>" )
					.append( "<div><i class='icon-minecraft " + item.css + "'></i> " + item.label + "</div>" )
					.appendTo( ul );
			};
		} );
		function remove_sold_item(name) {
			for (var i = 0; i < sold.length; i++) {
				if(sold[i] == name) {
					delete sold[i];
				}
			}
			jQuery(".item-sold-"+name).remove();
			update_sold_items();
		}

		function update_sold_items() {
			jQuery("#PVF_vente_items_value").val(JSON.stringify(sold));
		}
	</script>
	<?php
}

function PVF_remove_vanilla_publish_box() {
	remove_meta_box( 'submitdiv', array('base', 'magasin', 'projet', 'ferme'), 'side' );
}


function PVF_save_details($post_ID = 0) {
    $post_ID = (int) $post_ID;
    $post_type = get_post_type( $post_ID );
	$user = wp_get_current_user();

	$proprietaires = "";

	$roles = ( array ) $user->roles;
    if(in_array("player", $roles)) {

		$proprietaires .= $user->display_name . ", ";
	}
	if(!empty($_POST["proprietaires"])) {
		$proprietaires .= sanitize_text_field($_POST["proprietaires"]);
	}

	if(!empty($_POST["position_x"])) {
		$position_x = intval(sanitize_text_field($_POST["position_x"]));
	}
	if(!empty($_POST["position_z"])) {
		$position_z = intval(sanitize_text_field($_POST["position_z"]));
	}
	if(!empty($_POST["dimension"])) {
		$dimension = sanitize_text_field($_POST["dimension"]);
	}
	if(!empty($_POST["items_sold"])) {
		$items_sold = sanitize_text_field($_POST["items_sold"]);
	}

    if ($post_type == "base") {

    	update_post_meta($post_ID, "position_x", $position_x);
		update_post_meta($post_ID, "position_z", $position_z);
		update_post_meta($post_ID, "dimension", $dimension);
		update_post_meta($post_ID, "proprietaires", $proprietaires);

    }
	else if ($post_type == "magasin") {

    	update_post_meta($post_ID, "position_x", $position_x);
		update_post_meta($post_ID, "position_z", $position_z);
		update_post_meta($post_ID, "proprietaires", $proprietaires);
		update_post_meta($post_ID, "items_sold", $items_sold);

    }
   return $post_ID;
}
