<?php 
	include('atom_feed_processes.php');
	$department = $_POST['department'];
	$query = ( $department == "all" ? query_for_all() : "//atom:entry/atom:author/atom:name[.='".$department."']/../.." );
	$entries = atom_feed_to_array(query_atom_feed($query));
	//$json_results = '{"data" :"'.table_formatted_atom_feed_array($entries).'", "results":"'.count($entries).'"}';
	
	echo table_formatted_atom_feed_array($entries);
?>