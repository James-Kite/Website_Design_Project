<?php 

	// start session, loads variables stored in session data array
	session_start();

	// retreive form variables from previous page
	$date = $_GET['perfDate'];
	$production = $_SESSION['production'];
	$zone = $_GET['zone'];
	
	//initialise new session variables relevent to this page
	$_SESSION['date'] = $date;
	$_SESSION['zone'] = $zone;

	//insert header
	include("scripts/atlasHeader.php");

	//connect to database
	include("scripts/database.php");
	
	// begin next part of booking process
	echo '<div class="body">Booking seats for '.$production.' on '.$date.'...</div>';
	
	// get zone names
	$sql = "select distinct Zone
			from Seat";
			
	$handle = $conn->prepare($sql);
	$handle->execute();
	$res = $handle->fetchAll();
	
	//form to select number of seats
	echo '<form class="booking" method="GET" action="finalBooking.php">';
	
	echo ' 	<div id="balc"><p class="formLine1">Available '.$zone.' Seats</p>';
	//get seats
	include("scripts/getSeats.php");
	echo '</div>';
	
	//create array of booked seats
	$sql = "
			select BookedSeats
			from Booking
			where PerfDate = :date
	";
	$handle = $conn->prepare($sql);
	$handle->execute(array(':date' => $_SESSION['date']));
	$res = $handle->fetchAll();
	
	$pre_bsa = "";
	
	foreach($res as $row){
		$pre_bsa = $pre_bsa.$row['BookedSeats'];
	}
	
	// array of booked seats
	$bsa = str_split($pre_bsa, 3);
	
	//create array of available seats by comparing with array of booked seats
	$sql = "
			select RowNumber
			from Seat
			where Zone = :zone
	";
	$handle = $conn->prepare($sql);
	$handle->execute(array(':zone' => $_SESSION['zone']));
	$res = $handle->fetchAll();
	
	$pre_sa = "";
	
	foreach($res as $row){
		$pre_sa = $pre_sa.$row['RowNumber'];
	}
	
	//array of seats in selected zone
	$sa = str_split($pre_sa, 3);
		
	// available seat string to later be turned into array
	$pre_asa = "";
	
	//cycle through selected zone seeats, if not in booked seat array then put in new array of seats available to book	
	foreach($sa as $check){
		if(in_array($check, $bsa)){
			//do nothing
		}
		else{
			//put in available seat string
			$pre_asa = $pre_asa.$check;
		}
	}
	
	//turn available seat string into array
	$asa = str_split($pre_asa, 3);
	
	$maxAvailable = sizeof($asa);
	
	if($asa[0] == ''){
		echo '<p class="formLine">No seats available, please go back to the previous page and select a different seating zone.</p>';
	}
	else{
		echo '<p class="formLine">Please choose how many seats you would like:&nbsp<input type="number" name="num" min="1" max="'.$maxAvailable.'" size="3" required></p>';
		echo '<input class="submit" type="submit" value="Finalise my booking!"></div>';
	}
			
	echo '</form>';
	
	//run the javascript functions on page load to make sure things are hidden that should be
	echo '<script> showTextBox(ddbox); </script>';
	echo '<script> whatZone(ddbox); </script>';
	
	//page signature
	include("scripts/signature.php");
	
	//kill the database connection
	$conn = null;

?>