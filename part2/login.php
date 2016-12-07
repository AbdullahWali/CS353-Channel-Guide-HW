<?php
include_once 'dbconnect.php';
 session_start();
 ob_start();
 // it will never let you open index(login) page if session is set
 if ( isset($_SESSION['user'])!="" ) {
  header("Location: index.php");
  exit;
 }


$error = false;
 
 if( isset($_POST['btn-login']) ) { 
  
	  // prevent sql injections/ clear user invalid inputs
	  $nickname = trim($_POST['nickname']);
	  $nickname = strip_tags($nickname);
	  $nickname = htmlspecialchars($nickname);
	  
	  $pass = trim($_POST['pass']);
	  $pass = strip_tags($pass);
	  $pass = htmlspecialchars($pass);


	  // prevent sql injections / clear user invalid inputs
	  if(empty($nickname)){
	   $error = true;
	   $nicknameError = "The nickname..write it.";
	  } 

	  if(empty($pass)){
	   $error = true;
	   $passError = "I don't think I should let you in without a password";
	  }

	  if (empty($pass) and empty($nickname)){
	  	$error = true;
	  	$nonError= "Do those rectangular boxes down there mean anything to you? :)";
	  }

	  // if there's no error, continue to login
	  if (!$error) {
 

	   $res=mysqli_query($db, "SELECT * FROM host WHERE nickname='$nickname'");
	   $row=mysqli_fetch_array($res);
	   $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
   
	   if( $count == 1 && $row['password']==$pass ) {
	    $_SESSION['user'] = $row['hid'];
	    header("Location: index.php");
	   } else {
	    $errMSG = "Incorrect Credentials, Try again...";

	   }
	}
}
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
	            <li><a href="index.php">Home</a></li>
	            <li><a href="#">About</a></li>
	          </ul>
	          <ul class="nav navbar-nav navbar-right">
	            <li  class="active" ><a href="#login.php">Log in</a></li>

	          </ul>
	        </div>
	      </div>
	    </nav>


    <br><br><br> 
    <br>
	<br>


    <div  class="container col-md-4 col-md-offset-4">
<div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
     <div class="col-md-12">
        
         <div class="form-group">
             <h2 class="">Log In</h2>
            </div>
        
         <div class="form-group">
             <hr />
            </div>
            


            <!-- Error Handling HTML -->

            <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>

	<?php
      if ( isset($nonError) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $nonError; ?>
                </div>
             </div>
                <?php
   }  else if ( isset($nicknameError) ) {
   ?>

    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $nicknameError; ?>
                </div>
             </div>
                <?php
   } else if ( isset($passError) ) {
   ?>

    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $passError; ?>
                </div>
             </div>
                <?php
   }
   ?>

            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="username" name="nickname" class="form-control" placeholder="Your Nickname" maxlength="50" />
                </div>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="50" />
                </div>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
        
        </div>
   
    </form>
    </div> 

    </div> <!-- /container -->






    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
<?php ob_end_flush(); ?>