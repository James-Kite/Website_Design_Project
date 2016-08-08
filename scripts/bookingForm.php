<?php 
	
	session_start();

	//connect to database
	include("scripts/database.php");

	//Form for clients to book theatre performance
	
	echo 	'<form action="bookingCont.php" id="firstForm" method="GET" class="booking">
			<p class="formLine">Full Name:&nbsp<input type="text" id="fullName" name="fullName" required></p>
			<p class="formLine">Email:&nbsp<input type="email" id="email" name="email" required></p>';			
			
	echo 	'<p class="formLine">Production: <select id="production" name="production" required>';
	
	$production = $_GET['production'];
	
	echo											'<option value="">Choose a Production...</option>';
	
	//Get production titles from database
	$sql = "select distinct Title
			from Production";
	$handle = $conn->prepare($sql);
	$handle->execute();
	$res = $handle->fetchAll();
	
	foreach($res as $prod) {
		if($production == $prod[0]){ 
			echo									'<option value="'.$prod[0].'" selected>'.$prod[0].'</option>';
		}
		else {
			echo									'<option value="'.$prod[0].'">'.$prod[0].'</option>';
		}
	}

	echo 									'</select></p>
			<p class="formLine"><input type="submit" value="Show Me Dates!"></p>
			</form>';
			
	//kill the connection
	$conn = null;
?>