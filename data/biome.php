<?php

function PVF_dimension_data($id = "") {
	$data = array(
		"overworld" => array("Overworld", "grass-block"),
		"nether" => array("Nether", "netherrack"),
		"end" => array("End", "end-stone")
	);
	if(isset($data[$id])) {
		return $data[$id];
	}
	else if($id != "") {
		return $data["overworld"];
	}
	return $data;
}
