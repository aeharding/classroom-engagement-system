<?php 

	$con = new mysqli($config_server, $config_user, $config_pass, $config_table);
	$query = "SELECT * FROM `questions` WHERE s_sid='{$_SESSION['session']}' ORDER BY s_time DESC";
	$result = $con->query($query);
	
	for($i = 0; $row = mysqli_fetch_array($result); $i++) {
		if($i > 10) { break; } // TODO
		$qtype = "";
		if($row['s_qtype'] == 'mult') {
			$qtype = "A-E";
		} else if($row['s_qtype'] == 'bool') {
			$qtype = "True/False";
		}
		echo "<tr>";
		echo "<td>{$row['s_time']}</td>";
		echo "<td>$qtype</td>";
		echo '<td>
			<div class="btn-group">
				<button class="btn btn-small dropdown-toggle" data-toggle="dropdown">Options <span class="caret"></span></button>
				<ul class="dropdown-menu pull-right">
					<li><a href="#"><i class="icon-bullhorn"></i> Results</a></li>
					<li><a href="#"><i class="icon-play"></i> Resume</a></li>
					<li><a href="#"><i class="icon-download-alt"></i> Download .csv</a></li>
					<li class="divider"></li>
					<li><a href="#"><i class="icon-remove-sign"></i> Delete</a></li>
				</ul>
			</div>
		</td>';
		echo "</tr>";
  }
?>