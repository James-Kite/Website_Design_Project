<?php 

	//php script to get available seats from the database and print them out as a table
	echo '<p class="formLine">';
	
	//query database for seats in selected zone
	$sql = "
		select RowNumber
		from Seat
		where Zone = :zone";
	
	$handle = $conn->prepare($sql);
	$handle->execute(array(':zone' => $zone));
	$res = $handle->fetchAll();
	
	//query database for all seats booked on perf date
	$sql = "
			select BookedSeats
			from Booking
			where PerfDate = :date
	";
	$handle = $conn->prepare($sql);
	$handle->execute(array(':date' => $_SESSION['date']));
	$res1 = $handle->fetchAll();
	
	$pre_bsa = "";
	
	foreach($res1 as $row){
		$pre_bsa = $pre_bsa.$row['BookedSeats'];
	}
	
	// array of booked seats
	$bsa = str_split($pre_bsa, 3);
	
	echo '<table class="seats">';
	
	//count through the seats and if seat appears in an existing booking, display an X in the table
	for ($count = 0; $count < count($res) ;){
		echo "<tr>\n";
		for($i = 0; $count < count($res) && $i < 20; $count++, $i++){

			if(in_array($res[$count][0], $bsa)){	
				echo '<td>X</td>';
			}
			else{
				echo '<td>'.$res[$count][0].'</td>';
			}
		}
			
		echo "</tr>\n";
	}
	
	echo '</table>';
	
	echo '</p>';

?>