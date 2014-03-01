<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
	<head>
		<script src="jquery-1.11.0.min.js"></script>
		<script src="js/vendor/jquery.js"></script>
		<script src="js/foundation.min.js"></script>
		<link rel="stylesheet" href="css/normalize.css"></link>
		<link rel="stylesheet" href="css/foundation.css"></link>
		<title>OSU</title>
	</head>
	<body>
		<script type="text/javascript">
			$(document).ready(function(){
			});
		</script>
		<div class="row">
			<div class="small-2 columns"></div>
			<div class="small-8 columns">I'm a div!<br /></div>
			<div class="small-2 columns"></div>
		</div>
		
		<?php
			
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
			
			$stuff = $xPath->query("//atom:entry/atom:title[.='Post Doctoral Researcher']/..");
			
			
			
			
			
			echo "Counting...";
			echo $stuff->length;
			echo "<br />";
			
			foreach($stuff as $entry){
				echo "{$entry->nodeValue}";
				echo "<br />";
			}
			
			//foreach ($doc as $entry) {
				//echo $doc->saveHtml($entry);
				//echo "<br />";
			//}
			
			//$nodeList = $doc->getElementsbytagname('entry');

			//foreach ($nodeList as $node) {
			//	//echo $node->nodeValue;
			//	echo $node->getElementsByTagName('title')->item(0)->nodeValue;
			//	echo "<br /><strong>******** MY BREAK ********</strong><br />";
			//} 

			
			
			echo "<br /><br /><br /><br /><br /><br />";
			
			echo $data;
			 //Close fopen
			 fclose($fopen_feed);
		?>
		
		

	</body>
</html>

