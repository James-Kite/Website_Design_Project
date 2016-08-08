<?php 
	//page header and nav bar
	include("scripts/atlasHeader.php");
	echo '<div class="body">A list of current productions...</div>';
	echo "<div>";
		// get productions and relevent info to display on page
		include("scripts/getProd.php");
	echo "</div>";
	
	//page signature
	include("scripts/signature.php");
?>