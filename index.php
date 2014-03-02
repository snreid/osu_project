<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php include('atom_feed_processes.php'); ?>
<html>
	<head>
		<script src="js/jquery-1.11.0.min.js"></script>
		<script src="js/vendor/jquery.js"></script>
		<script src="js/foundation.min.js"></script>
		<script src="datatables/js/jquery.dataTables.js"></script>
		<script src="datatables/css/jquery.dataTables.css"></script>
		<link rel="stylesheet" href="css/normalize.css"></link>
		<link rel="stylesheet" href="css/foundation.css"></link>
		<link rel="stylesheet" href="app_style.css"></link>

		<title>OSU Jobs</title>
	</head>
	<body>
		<script type="text/javascript">
			$(document).ready(function(){
				//$('#entries').dataTable({
					//"bPaginate": true,
					//"bLengthChange": true,
					//"bFilter": false,
					//"bSort": false,
//					"bInfo": false,
					//"bAutoWidth": false 
					//"sAjaxSource": {url:"atom_feed_processes.php", data:{action: 'atom_feed_for_datatables'},
					//"bServerSide": true,
					//"sServerMethod": 'GET',
					//"aoColumns": [
						//{ "mData": "Title" },
						//{ "mData": "ID" },
						//{ "mData": "Posting Department" },
						//{ "mData": "Published"},
						//{ "mData": "Content"}
					//],

				//});
				$('#titles').change(function(){
					$.ajax({ url: 'atom_feed_processes.php',
							data: {action: 'atom_feed_by_title', title:$('#titles').val()},
							type: 'post',
							success: function(output) {
								$('#entries_body').html(output);
							}
					});
				});
				
			});
		</script>
		<div class="row">
			<div class="column large-12">
				<?php
					$results = atom_feed_to_array(null);
					echo "<p>";
					echo "<h3>Search Results | ".count($results)."</h3>";
					echo "</p>";
				?>
			</div>
			<div class="column large-9">
				<table id="entries">
					<thead>
						<tr>
							<th>Title</th>
							<th>id</th>
							<th>Posting Department</th>
							<th>Published</th>
						</tr>
					</thead>
					<tbody id="entries_body">
						<?php
							echo table_formatted_atom_feed_array($results)
						?>
					</tbody>
				</table>
			</div>
			
			<div class="search-panel column medium-3">
				<p><h3>Custom Search</h3></p>
				<?php
					$titles =  get_distinct_titles();
					echo "<strong> Search By Title </strong><br />";
					echo '<select id="titles">';
					echo '<option>--Choose One--</option>';
					foreach($titles as $title){ 
						echo '<option value="'.$title.'">'.$title.'</option>'; 
					}
					echo '</select>';
					//echo $titles;
					$departments = get_distinct_departments();
					echo "<br /><br /><strong>Search By Department</strong><br />";
					echo '<select id="departments">';
					echo '<option>--Choose One--</option>';
					//echo $departments;
					foreach($departments as $department){ 
						echo '<option value="'.$department.'">'.$department.'</option>'; 
					}
					echo '</select>';
				?>
			</div>
		
		</div>

	</body>
</html>

