<?php
	session_start();
	include_once 'dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

	<title>Cool CS353 Stuff</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<script type="text/javascript" async>
		function showSection( sid ) {
			$(document).ready(function(){
				$('#showInfoContent').load('showInfoQuery.php?sid=' +sid);
			});
			document.getElementById("showInfo").className = "show";	
		}
	</script>



</head>
<body>

	  <!-- Fixed navbar -->
	    <nav class="navbar navbar-inverse navbar-fixed-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="index.php">Channel Guide</a>
	        </div>

	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav">
	            <li class="active"><a href="index.php">Home</a></li>
	            <li><a href="#">About</a></li>
	          </ul>
	          <ul class="nav navbar-nav navbar-right">
	          	<?php 
	          		if (isset($_SESSION['user'])!="" ) {
          					$query = "SELECT *
			  						  FROM host 
			  						  WHERE hid = {$_SESSION['user']};";
			  				$result = mysqli_query($db , $query) or die("Could not execute query");
		  					$row  = mysqli_fetch_array($result);
		  					$loggedInNickname = $row['nickname'];
	          	?>
	          			<li> <p class="navbar-text"> Welcome <?php echo "$loggedInNickname" ?>,  </p></li>
	          			<li><a href="logout.php">Log out</a></li>
	          	<?php
	          		}
	          		else {
	          	?>
	            <li><a href="login.php">Log in</a></li>
	            <?php
	            	}
	            ?>

	          </ul>
	        </div>
	      </div>
	    </nav>


    <br> 
    <br>
	<br>





	<br>
	<div class = "container">
		<div class="panel panel-primary">
			  <!-- Default panel contents -->
			  <div class="panel-heading">This Week's Schedule</div>
			  <table class="table table-bordered ">
			  		<thead class = "thead-default">

			  		<tr>
			  			<td> Hours </td>
			  			<th> Monday </th>
			  			<th> Tuesday</th>
			  			<th> Wednesday </th>
			  			<th> Thursday </th>
			  			<th> Friday </th>
			  			<th> Saturday </th>
			  			<th> Sunday </th>
			  		</tr>
			  		</thead>
 					<tbody>

			  		<?php

			  			//Loop Initilization
			  			$days = array( "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
			  			$hours = array ("20:00:00", "21:00:00", "22:00:00", "23:00:00"	);

			  			foreach ($hours as &$time_value) {
			  				echo "<tr>
			  						<th scope=\"row\">$time_value</th>";

			  				foreach ($days as &$day_value) {

				  				$query = "SELECT sid, pname, cname, name
				  						  FROM `show` NATURAL JOIN channel NATURAL JOIN host 
				  						  WHERE day = \"$day_value\" AND time = \"$time_value\";";
				  				$row = mysqli_query($db , $query) or die("Could not execute query");
				  				if (mysqli_num_rows($row) == 0) echo "<td></td>";
				  				else {


				  					$row = mysqli_fetch_array($row);
				  					$sid = $row['sid'];
				  					echo "<td>
				  							<a href=\"javascript:void(0);\" onClick = \"event.preventDefault();showSection('$sid');\" > {$row['pname']} by {$row['name']}<br> on {$row['cname']} </a>
				  						  </td>";
				  				}
				  			}

			  				echo "</tr>";
			  			}
					?>	


					</tbody>
			  </table>
		</div>
	</div>


	<div id="showInfo" class = "hidden">
	<div class = "container"> 
		<div class = "jumbotron">
			<div id = "showInfoContent"> </div>
		</div>
	</div>
	</div>





    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
