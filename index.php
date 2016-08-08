<?php
	// site header and nav bar
	include("scripts/atlasHeader.php");
	
	//page about section
	echo '<div class="body">About ATLAS THEATRE...</div>';
	
	//read in desciption of theatre from text file
	$file = "./description.txt";
	$handle = file_get_contents($file);
	
	//display description on page
	echo '<div class="atlasdesc">';
	echo $handle;
	echo '</div>';
	
	//page signature
	include ("scripts/signature.php");
?>