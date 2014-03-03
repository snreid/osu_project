<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php include('atom_feed_processes.php'); ?>
<html>
	<head>
		<script src="js/jquery-1.11.0.min.js"></script>
		<script src="js/vendor/jquery.js"></script>
		<script src="js/foundation.min.js"></script>
		<script src="js/jquery.tablePagination.0.5.min.js"></script>

		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/foundation.css">
		<link rel="stylesheet" href="app_style.css">
		
		<!--<script src="datatables/js/jquery.dataTables.js"></script>
		<script src="datatables/css/jquery.dataTables.css"></script>
		
		<script src="jqPagination/js/jquery.jqpagination.js"></script>
		<link rel="stylesheet" href="jqPagination/css/jqpagination.css"></link>--> 

		<title>OSU Jobs</title>
	</head>
	<body>
		<script type="text/javascript">
			$(document).ready(function(){
				$('#entries').tablePagination({});
				
				$('#titles').change(function(){
					$('#departments').val('all');
					$.ajax({ url: 'ajax_get_entries_by_title.php',
							data: {title : $('#titles').val()},
							type: 'post',
							success: function(output) {
								ajax_update_results(output);
							}
					});
				});
				$('#departments').change(function(){
					$('#titles').val('all');
					$.ajax({ url: 'ajax_get_entries_by_department.php',
							data: {department : $('#departments').val()},
							type: 'post',
							success: function(output) {
								ajax_update_results(output);
							}
					});
				});
				
				$('#sort_by').change(function(){
					console.log("You've called the sorting function...");
					$.ajax({ url: 'ajax_sort_all_entries.php',
							data: {index : $('#sort_by').val()},
							type: 'post',
							cache: false,
							success: function(output) {
								ajax_update_results(output);
							}
					});
				});
				function ajax_update_results(output){
					$('#entries_body').html(output);
					$('#results_number').html('Search Results | ' + $('#entries >tbody >tr').length / 2);
					$('#entries').tablePagination({});
				}
			});
		</script>
		<div class="row">
			<div class="column large-12">
				<?php
					$results = get_all_entries();
					echo "<p>";
					echo "<h3 id='results_number'>Search Results | ".count($results)."</h3>";
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
					echo '<option value="all">-- All --</option>';
					foreach($titles as $title){ 
						echo '<option value="'.$title.'">'.$title.'</option>'; 
					}
					echo '</select>';
					
					echo "<br /><br />";
					
					$departments = get_distinct_departments();
					echo "<strong>Search By Department</strong><br />";
					echo '<select id="departments">';
					echo '<option value="all">-- All --</option>';
					foreach($departments as $department){ 
						echo '<option value="'.$department.'">'.$department.'</option>'; 
					}
					echo '</select>';
				?>
				<br /><br />
				<strong>Sort</strong><br />
				<select id="sort_by">
					<option value="none">-- None --</option>
					<option value="title">By Title</option>
					<option value="author">By Department</option>
				</select>
			</div>
		
		</div>

	</body>
</html>

