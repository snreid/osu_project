<?php
	function query_atom_feed($query){
		$feed_url = "https://www.jobsatosu.com/all_jobs.atom";
		$fopen_feed = fopen($feed_url, "r");
		
		if ($fopen_feed) {
			//Store our data
			$data = "";
			while (!feof($fopen_feed)) {
				$data .= fread($fopen_feed, 8192);
			}
		}
		$doc = new DOMDocument('1.0', 'iso-8859-1');
		$doc->loadXml($data);
		$xPath = new DOMXPath($doc);
		
		$xPath->registerNamespace('atom', "http://www.w3.org/2005/Atom");
		$results = $xPath->query($query);
		
		//Close fopen
		fclose($fopen_feed);
		
		return $results;
	}
	
	function query_for_all(){
		return "//atom:entry";
	}
	
	function get_all_entries(){
		$data = atom_feed_to_array(query_atom_feed(query_for_all()));
		//$index = 'title';
		//foreach ($data as $key => $row) {
		//	$sort_by[$key]  = $row[$index];
		//}

	// Add $data as the last parameter, to sort by the common key
		//array_multisort($sort_by, SORT_ASC, $data);
	
		return $data;
	}
	
	function atom_feed_to_array($feed){
		$results_array = Array();
		$i=0;
		foreach($feed as $entry){
			$results_array[$i]['id'] = "{$entry->getElementsByTagName('id')->item(0)->nodeValue}";
			$results_array[$i]['title'] = "{$entry->getElementsByTagName('title')->item(0)->nodeValue}";
			$results_array[$i]['author'] = "{$entry->getElementsByTagName('author')->item(0)->getElementsByTagName('name')->item(0)->nodeValue}";
			$results_array[$i]['published'] = "{$entry->getElementsByTagName('published')->item(0)->nodeValue}";
			$results_array[$i]['updated'] = "{$entry->getElementsByTagName('updated')->item(0)->nodeValue}";
			$results_array[$i]['link'] = "{$entry->getElementsByTagName('link')->item(0)->getAttribute('href')}";
			$results_array[$i]['content'] = "{$entry->getElementsByTagName('content')->item(0)->nodeValue}";	
			$i++;
		}
		return $results_array;
	}
	
	function table_formatted_atom_feed_array($results_array){
		$html_output = '';
		foreach($results_array as $entry){
			$html_output .= '<tr>';
			$html_output .= "<td align='center'><a href='{$entry['link']}'>{$entry['title']}</a></td>";
			$html_output .= "<td align='center'>{$entry['id']}</td>";
			$html_output .= "<td align='center'>{$entry['author']}</td>";
			$html_output .= "<td align='center'>{$entry['published']}</td>";
			$html_output .= '</tr>';
			$html_output .= "<tr><td colspan='5'>{$entry['content']}</td></tr>";
		}
		return $html_output;
	}
	
	function get_distinct_titles(){
		$results = query_atom_feed(query_for_all());
		$titles = Array();
		foreach($results as $result){
			$titles[] = "{$result->getElementsByTagName('title')->item(0)->nodeValue}";
		}
		sort($titles);
		$titles = array_unique($titles);
		return $titles;
	}
	
	function get_distinct_departments(){
		$results = query_atom_feed(query_for_all());
		$departments = Array();
		foreach($results as $result){
			$departments[] = "{$result->getElementsByTagName('author')->item(0)->getElementsByTagName('name')->item(0)->nodeValue}";
		}
		sort($departments);
		$departments = array_unique($departments);
		return $departments;
	}
?>