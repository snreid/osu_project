<?php
	include('atom_feed_processes.php');
	$title = $_POST['title'];
	$query = ( $title == "all" ? query_for_all() : "//atom:entry/atom:title[.='".$title."']/.." );
	$entries = atom_feed_to_array(query_atom_feed($query));
	//$json_results = '{"data" :"'.table_formatted_atom_feed_array($entries).'", "results":"'.count($entries).'"}';
	
	echo table_formatted_atom_feed_array($entries);
?>