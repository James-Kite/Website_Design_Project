<?php
	//connect to database
	require("scripts/database.php");
	//query database for Productions and prices
    $sql = "select * 
			from Production";
    $handle = $conn->prepare($sql);
    $handle->execute();
    $res = $handle->fetchAll();
	//print productions and prices to screen
    foreach($res as $row) {
		
		echo '<div class="container">';
        echo '	<li class="production">'.$row['Title'].'</li>';
		echo '	<div class="row">';
		echo '		<div class="prodImg">';
		echo '			<img src="images/productions/'.$row['Title'].'/image.png" alt="'.$row['Title'].' image.png not found..." width=568>';
		echo '		</div>';
		echo '		<div class="description">';
		$file = './images/productions/'.$row['Title'].'/description.txt';
		$handle = file_get_contents($file);
		echo $handle;
		echo '		</div>';
		echo '	</div>';
		echo '	<div class="ticketPrice">Base ticket price: &pound'.$row['BasicTicketPrice'].'</div>';
		echo '</div>';
		echo '<div style="clear: both;"></div>';
		
    }
	//kill the connection
	$conn = null;
?>