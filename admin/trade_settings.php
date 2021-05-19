<?php

function PVF_trade_settings_page() {
	$strJsonFileContents = file_get_contents(PVF_PLUGIN_DIR . "data/items.json");
	$items = json_decode($strJsonFileContents, true);
	?>
	<div class="wrap">
<?php PVF_options_admin_header(3) ?>

<div class="tablenav top">
	<p class="search-box">
		<input type="text" id="myInput" placeholder="Filtrer">
	</p>

				<!--<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text">Sélectionnez l’action groupée</label><select name="action" id="bulk-action-selector-top">

</select>
<input type="submit" id="doaction" class="button action" value="Appliquer">
</div>-->
	</div>

<table class="wp-list-table widefat fixed striped table-view-list">
	<thead>
		<tr>
			<!--<td class="manage-column column-cb check-column"><input type="checkbox" onclick="selectAll(this);"></td>-->
			<td style="width: 32px;"></td>
			<td style="width: 150px;">Item</td>
			<th>Nom</th>
			<td style="width: 75px;">Prix min.</td>
			<td style="width: 75px;">Quantité</td>
			<td style="width: 75px;">Visible</td>
			<td style="width: 75px;"></td>
		</tr>
	</thead>
	<?php
	foreach ($items as $item) {
		?>
		<tr class="item item-<?php echo $item["name"]; ?>">
			<!--<td><input type="checkbox" class="item_select"></td>-->
			<td><i class="icon-minecraft <?php echo $item["css"]; ?>"></i></td>
			<td>minecraft:<?php echo $item["name"]; ?></td>
			<td class="label"><?php echo $item["label"]; ?></td>
			<td class="p_min"><?php echo !empty($item["p_min"]) ? $item["p_min"] : 0; ?></td>
			<td class="quantite"><?php echo !empty($item["quantite"]) ? $item["quantite"] : 0; ?></td>
			<td class="visible"><?php
				if(!empty($item["visible"]) && $item["visible"] == true) {
					echo "Oui";
				}
				else { echo "Non"; }
			 ?></td>
			<td><button type="button" class="button-link editinline" onclick="open_edit('<?php echo $item["name"]; ?>', this)">Modifier</button></td>
		</tr>
		<?php
	}
	?>
</table>

<script>
jQuery("#myInput").on("keyup", function() {
    var value = jQuery(this).val().toLowerCase();
    jQuery("table tr.item").filter(function() {
      jQuery(this).toggle(jQuery(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

function selectAll(box) {
	jQuery('.item_select').each(function() {
		if(jQuery(this).parent().parent().css("display") == "none") {
			return;
		}
		this.checked = box.checked;
	})
}

function open_edit(item, button) {
	var itemRow = jQuery(".item-" + item);

	var labelCell = itemRow.find('.label');
	var p_minCell = itemRow.find('.p_min');
	var quantiteCell = itemRow.find('.quantite');
	var visibleCell = itemRow.find('.visible');

	labelCell.html('<input type="text" value="'+labelCell.html()+'"/>');
	p_minCell.html('<input type="number" value="'+p_minCell.html()+'" style="width:75px;"/>');
	quantiteCell.html('<input type="number" value="'+quantiteCell.html()+'" style="width:75px;"/>');
	visibleCell.html('<input type="checkbox" '+(visibleCell.html() == "Oui" ? "checked" : "")+'/>');

	button.innerHTML = "Enregistrer";
	button.onclick = function() {
		save_item(item, button)
	}
}

function save_item(item, button) {

	var itemRow = jQuery(".item-" + item);

	var labelCell = itemRow.find('.label');
	var p_minCell = itemRow.find('.p_min');
	var quantiteCell = itemRow.find('.quantite');
	var visibleCell = itemRow.find('.visible');

	var label = labelCell.find("input").val();
	var p_min = p_minCell.find("input").val();
	var quantite = quantiteCell.find("input").val();
	var visible = visibleCell.find("input")[0].checked;

	var se_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
	var url = se_ajax_url + '?action=PVF_save_item';
	jQuery.post(url,
		{
			item: item,
			label: label,
			p_min: p_min,
			quantite: quantite,
			visible: visible
		},
		function(data) {
			labelCell.html(label);
			p_minCell.html(p_min);
			quantiteCell.html(quantite);
			visibleCell.html(visible ? "Oui" : "Non");

			button.innerHTML = "Modifier";
			button.onclick = function() {
				open_edit(item, button);
			}
		}
	);
}
</script>
<?php
}
