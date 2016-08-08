<?php 
	
	//start session
	session_start();
	
	//initialise session variables
	$id = session_id();

	// retrieve variables from previous page's form
	$fullName = $_GET['fullName'];
	$production = $_GET['production'];
	$email = $_GET['email'];
	
	// store these retrieved variables in the session data array
	$_SESSION['id'] = $id;
	$_SESSION['production'] = $production;
	$_SESSION['fullName'] = $fullName;
	$_SESSION['email'] = $email;

	//Insert header
	include("scripts/atlasHeader.php");
	
	//connect to database
	include("scripts/database.php");

	
	//show information entered on previous page
	echo '<div class="body">Booking form continued...</div>';
	
	echo '<div class="atlasdesc">You have begun the booking process!<br><br>Booking REF: '.$id.'<br><br>Full Name: '.$fullName.'<br>Email: '.$email.'<br><br>Production: '.$production.'<br></div>';

	echo '<div class="atlasdesc">Please select from the available performance dates and seating zones below:</div>';
	
	//form for user to select performance date for chosen production
	echo '<form class="booking" action="bookingCont2.php">';
	echo '	<p class="formLine">I would like to book tickets for the following date:&nbsp<select name="perfDate" required>';
	echo '							<option value="">Choose a date...</option>';
	$sql = "select PerfDate
			from Performance
			where Title = :show";
	$handle = $conn->prepare($sql);
	$handle->execute(array(':show' => $production));
	$res = $handle->fetchAll();
	foreach($res as $row) {
		echo '<option value="'.$row['PerfDate'].'">'.$row['PerfDate'].'</option>';
	}
	echo '</select></p>';
	echo '<p class="formLine">I want to sit in:&nbsp<select name="zone" required>';
	echo '<option value="">Choose a seating zone...</option>';
	$sql = "select distinct Zone
			from Seat";
	$handle = $conn->prepare($sql);
	$handle->execute();
	$res = $handle->fetchAll();
	foreach($res as $row){
		echo '<option value="'.$row['Zone'].'">'.$row['Zone'].'</option>';
	}
	echo '</select></p>';
	echo '<p class="formLine"><input type="submit" value="Show Me Available Seats!"></p>';
	echo '</form>';
	
	//Kill the connection
	$conn = null;
	
	// signature
	include ("scripts/signature.php");
	
?>