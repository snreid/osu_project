<?php
	if(isset($_POST['action']) && !empty($_POST['action'])) {
		$action = $_POST['action'];
		$title = $_POST['title'];
		switch($action) {
			case 'ajax_get_job_by_title' : ajax_get_job_by_title($title);break;
			case 'blah' : blah();break;
			default : atom_feed_to_array();break;
		}
	}

	function ajax_get_job_by_title($title){
		echo $title;
		atom_feed_to_array("//atom:entry/atom:title[.='Accountant']/..");
		//"//atom:entry/atom:title[.='".$title."']/.."
	}

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
		$query = ($query == null ? "//atom:entry" : $query);
		$results = $xPath->query($query);
		//"/atom:title[.='Post Doctoral Researcher']/.."
		
		//echo $data;
		//Close fopen
		fclose($fopen_feed);
		
		return $results;
	}
	
	function atom_feed_to_array($query){
		echo "Results of query: ".$query;
		$results = query_atom_feed($query);
		$results_array = Array();
		$i=0;
		foreach($results as $entry){
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
		$results = query_atom_feed(null);
		$titles = Array();
		foreach($results as $result){
			$titles[] = "{$result->getElementsByTagName('title')->item(0)->nodeValue}";
		}
		sort($titles);
		$titles = array_unique($titles);
		return $titles;
	}
	
	function get_distinct_departments(){
		$results = query_atom_feed(null);
		$departments = Array();
		foreach($results as $result){
			$departments[] = "{$result->getElementsByTagName('author')->item(0)->getElementsByTagName('name')->item(0)->nodeValue}";
		}
		sort($departments);
		$departments = array_unique($departments);
		return $departments;
	}
	
	
	
	
	
	
	
	
	
	
	
	
		function atom_feed_for_datatables(){
		$results = query_atom_feed();
		$results_array = Array();
		$i=0;
		foreach($results as $entry){
			$results_array[$i][] = "{$entry->getElementsByTagName('title')->item(0)->nodeValue}";
			$results_array[$i][] = "{$entry->getElementsByTagName('id')->item(0)->nodeValue}";
			$results_array[$i][] = "{$entry->getElementsByTagName('author')->item(0)->getElementsByTagName('name')->item(0)->nodeValue}";
			$results_array[$i][] = "{$entry->getElementsByTagName('published')->item(0)->nodeValue}";
			//$results_array[$i][] = "{$entry->getElementsByTagName('updated')->item(0)->nodeValue}";
			//$results_array[$i][] = "{$entry->getElementsByTagName('link')->item(0)->getAttribute('href')}";
			$results_array[$i][] = "{$entry->getElementsByTagName('content')->item(0)->nodeValue}";	
			$i++;
		}
		
		$iTotal = count($results_array);
		$iFilteredTotal = count($results_array);
		
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		
		 foreach($results_array as $row)
		{
			$output['aaData'][] = $row;
		}

		echo json_encode( $output );
	}
?>