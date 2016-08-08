<?php 
	//page header and nav bar	
	include("scripts/atlasHeader.php");
	
	echo '<div class="body">A list of current performances...</div>';
	
	//performances listed
	echo "<div>";
		//get performances to list on page
		include("scripts/getPerf.php");
	echo "</div>";
	
	//page signature
	include ("scripts/signature.php");
?>