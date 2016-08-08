<?php
	// start session and load in session data array
	session_start();
	
	// page header and nav bar	
	include("scripts/atlasHeader.php");
	
	// initialise any new session variables
	$_SESSION['numSeats'] = $_GET['num'];

	// print out all booking details accquired so far	
	echo '<div class="atlasdesc">';
	echo 'You are about to finalize your booking with the following information...';
	echo '<br><br>';
	echo 'Booking REF: '.$_SESSION['id'];
	echo '<br><br>';
	echo 'Full Name: '.$_SESSION['fullName'];
	echo '<br>';
	echo 'Email: '.$_SESSION['email'];
	echo '<br><br>';
	echo 'Production: '.$_SESSION['production'];
	echo '<br>';
	echo 'Performance Date: '.$_SESSION['date'];
	echo '<br>';
	echo 'Performance Time: 17:00';
	echo '<br><br>';
	echo 'Seating Zone: '.$_SESSION['zone'];
	echo '<br>';
	echo 'Number of Seats to reserve: '.$_SESSION['numSeats'];
	echo '<br>';
	
	//connect to database
	include("scripts/database.php");
	
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
	
	//take from available seat array the first however many the customer wants to book
	$wtb = "";
	
	for($i = 0; $i < $_SESSION['numSeats'] && $i < sizeof($asa); $i++){
		$wtb = $wtb.$asa[$i];
	}
	
	//store this in session data to be later sent to sql database
	$pre_printSeats = str_split($wtb, 3);
	$printSeats = implode(" ", $pre_printSeats);
	$_SESSION['printSeats'] = $printSeats;
	$_SESSION['bookedSeats'] = $wtb;
	
	//print the reserved seats to screen	
	echo 'Reserving seats: '.$printSeats;
	
	//calculate price of booking by getting the relevent zone multiplier and basic ticket price fomr the sql database and mulitplying these by number of booked seats
	$sql = "select distinct p.BasicTicketPrice, z.PriceMultiplier
			from Production p, Zone z
			where p.Title = :show
			and z.Name = :zone";
			
	$handle = $conn->prepare($sql);
	$handle->execute(array(':show' => $_SESSION['production'], ':zone' => $_SESSION['zone']));
	$res = $handle->fetchAll();
	
	//print info to screen
	echo '<br><br>';
	echo 'Basic Ticket Price: &pound'.$res[0]['BasicTicketPrice'].'<br>';
	echo 'Zone Price Multiplier: '.$res[0]['PriceMultiplier'].'<br><br>';
	
	//store this total price as session data
	$totalPrice = $res[0]['BasicTicketPrice'] * $res[0]['PriceMultiplier'] * $_SESSION['numSeats'];
	$_SESSION['total'] = $totalPrice;
	
	echo '<br><br>The total cost of your booking comes to: ';
	echo '&pound'.$totalPrice;
	echo '<br><br>';
	
	echo '	<form action="bookingReceipt.php">
				<input class="submit" type="submit" value="Make Payment!">
			</form>';
			
	echo '</div>';
	
	//kill the connection
	$conn = null;

	// page signature
	include("scripts/signature.php");

?>