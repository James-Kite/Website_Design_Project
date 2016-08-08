<?php
	//database connection script
	$host = 'dragon.ukc.ac.uk';
	$dbname = 'jk497';
	$user = 'jk497';
	$pwd = 'notap-s';
	try {
		$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if ($conn) {
		} else {
		}
	} catch (PDOException $e) {
		echo "PDOException: ".$e->getMessage();
	}
?>

