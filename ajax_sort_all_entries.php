<?php
	include('atom_feed_processes.php');
	$index = $_POST['index'];
	$data = atom_feed_to_array(query_atom_feed(query_for_all()));
	if( $index != 'none' ){
		foreach ($data as $key => $row) {
			$sort_by[$key]  = $row[$index];
		}
		// Add $data as the last parameter, to sort by the common key
		array_multisort($sort_by, SORT_ASC, $data);
	}
	//$json_results = '{"data" :"'.htmlspecialchars( htmlentities(  table_formatted_atom_feed_array($data)  ) ).'", "results":"'.count($data).'"}';
	
	echo table_formatted_atom_feed_array($data);
?>