<?php
	//connect to database
	require("scripts/database.php");
	// fetch just the performance titles from performance table and list them
	$sql = "select distinct title 
			from Performance";
	$handle = $conn->prepare($sql);
	$handle->execute();
	$res = $handle->fetchAll();
	//List each performance title
	foreach($res as $row) {
		echo '<li class="production">'.$row[0].'</li>';
		// List all the performance dates and times for the particular performance
		$subSql = "select PerfDate, PerfTime 
				   from Performance
				   where Title = :show";
		$handle = $conn->prepare($subSql);
		$handle->execute(array(':show' => $row[0]));
		$res2 = $handle->fetchAll();
		foreach($res2 as $row2) {
			echo '<li class="dt">'.$row2['PerfDate'].' :: '.$row2['PerfTime'].'</li>';
		}
		$production = $row[0];
		echo '<li class=""><a class="bookBtn" href="bookings.php?production='.$production.'">Book seats for this Production</a></li>';
	}
	//kill connection
	$conn = null;
?>