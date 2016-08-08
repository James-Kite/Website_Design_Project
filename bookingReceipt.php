<?php 
	// start session to load in session data array
	session_start();
	
	//page header and nav bar	
	include("scripts/atlasHeader.php");
	
	// print out all booking details from whole process	
	echo '<div class="atlasdesc">';
	echo 'Thank you for your payment of &pound'.$_SESSION['total'];
	echo '<br>Your booking details are as follows:';
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
	echo 'Seats reserved: '.$_SESSION['printSeats'];
	echo '<br>';
	echo '</div>';
	
	//page signature
	include("scripts/signature.php");
	
	//send all data to database to store in Bookings table
	
	//retrieve first seat booked to be the RowNumber column in the database
	$split = str_split($_SESSION['bookedSeats'], 3);
	$seatIndex = $split[0];

	//connect to database and place session info in bookings table
	include("scripts/database.php");
		
	$time = "17:00:00";
	
	$sql = "insert into Booking (BookingId, PerfDate, PerfTime, Name, Email, RowNumber, NoSeats, BookedSeats) values (:id,:date,:time,:fullName,:email,:rowNum,:numSeats, :bookedSeats)";
	$handle = $conn->prepare($sql); 
	$handle->execute(array(':id' => $_SESSION['id'], ':date' => $_SESSION['date'], ':time' => $time, ':fullName' => $_SESSION['fullName'], ':email' => $_SESSION['email'], ':rowNum' => $seatIndex, ':numSeats' => $_SESSION['numSeats'], ':bookedSeats' => $_SESSION['bookedSeats']));
	
	//kill the connection
	$conn = null;

	//destroy session data
	session_destroy();

?>