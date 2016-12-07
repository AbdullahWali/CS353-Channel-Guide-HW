<?php
	include_once 'dbconnect.php';
	 $sid = $_GET['sid'];
	// //Get Show Information 


	$query = "SELECT pname, cname, name, day, time 
			  FROM `show` NATURAL JOIN channel NATURAL JOIN host 
			  WHERE sid = {$sid};";

	$row = mysqli_query($db , $query) or die("Could not execute query");
	$row = mysqli_fetch_array($row);

	echo "<h2> {$row['cname']} </h2>";
	echo "<p>{$row['pname']} by {$row['name']} on {$row['day']} {$row['time']}</p>";

	$query = "SELECT gname, title, profession, short_bio
			  FROM guest_show natural join guest
			  WHERE sid = $sid;";
	$result = mysqli_query($db , $query) or die("Could not execute query");
	
	if (!mysqli_num_rows($result) == 0) echo "<strong>Guests:<br></strong>";
	while ($row = mysqli_fetch_array($result)){ 
		echo "<em>{$row['title']} {$row['gname']}</em> <br>";
		echo "<strong>Profession:</strong> {$row['profession']}<br>";
		echo "<strong>Short Bio:</strong> {$row['short_bio']}<br><br>";


	}
?>