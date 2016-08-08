<?php 

	// header and nav bar
	include("scripts/atlasHeader.php");
	
	// clear all session data
	session_start();
	$_SESSION = array();
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}
	session_destroy();
	
	//Present user with booking form part 1
	echo '<div class="body">Bookings to be made here...</div>';
	include("scripts/bookingForm.php");

	//page signature
	include("scripts/signature.php");
	
?>