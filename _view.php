<?php


	$this_file = $_SERVER ["SCRIPT_FILENAME"];
	$this_file = explode("/", $this_file);
	array_pop($this_file);
	$here = implode("/", $this_file)."/";
	
	include($_SERVER["DOCUMENT_ROOT"]."/_inc/load_view.php");
	
?>