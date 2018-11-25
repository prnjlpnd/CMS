<?php require_once("db.php"); ?>
<?php require_once("sessions.php"); ?>
<?php require_once("functions.php"); ?>
<?php
$connection=mysqli_connect('localhost','root','','phpcms');
if(isset($_POST["Submit"])){
	$UserName=mysqli_real_escape_string($connection,$_POST["UserName"]);
	$Password=mysqli_real_escape_string($connection,$_POST["Password"]);

if(empty($UserName)||empty($Password)){
	$_SESSION["ErrorMessage"]= "All fields must be filled out";
	redirect_to("login.php");
}
else{
	$found_account=login_attempt($UserName,$Password);
	$_SESSION["User_Id"]=$found_account["id"];
		$_SESSION["Username"]=$found_account["username"];
	if($found_account){
		$_SESSION["SuccessMessage"]= "Welcome {$_SESSION["Username"]}";
	redirect_to("dashboard.php");
		
	}
	else{
		$_SESSION["ErrorMessage"]= "Invalid Email and password";
	redirect_to("login.php");
	}
	}


}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<link rel="stylesheet" href="adminstyles.css">
<style>
	.fieldinfo{
		color: rgb(251,174,44);
		font-family: Bitter,Georgia,"Times New Roman",Times,seriff;
		font-size: 1.2em;
	}
	body{
		background-color: #ffffff;
	}
</style>
</head>
<body>
	<div style="height: 10px; background: #27aae1;"></div>
	<nav class="navbar navbar-inverse role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			<a class="navbar-brand" href="Blog.php"><img style="margin-top: -12px" src="Images/images5.jpg" width=200; height=30; ></a>
			</div>
			<div class="collapse navbar-collapse" id="collapse">
</div>
</div>
</nav>
<div style="height: 10px; background: #27aae1; margin-top: -20px;"></div>
<div class="container-fluid">
<div class="row">
	
	<div class="col-sm-offset-4 col-sm-4">
		<?php echo message();
		echo successmessage(); ?>
		<br><br><br><br>
		<h2>Welcome Back</h2>
		

		<div>
       <form action="login.php" method="post">
       	<fieldset>
       		<div class="form-group">
       			
       	<label for="UserName"><span class="fieldinfo">UserName:</span></label>
       	<div class="input-group input-group-lg">
       				<span class="input-group-addon">
       					<span class="glyphicon glyphicon-envelope text-primary"></span>
       				</span>
       	<input class="form-control"  type="text" name="UserName" id="UserName" placeholder="UserName">
       	</div>
</div>
       	<div class="form-group">
       	<label for="Password"><span class="fieldinfo">Password:</span></label>
       	  	<div class="input-group input-group-lg">
       	  		<span class="input-group-addon">
       	  				<span class="glyphicon glyphicon-lock text-primary"></span>
       				</span>
       	<input class="form-control"  type="Password" name="Password" id="Password" placeholder="Password">
       	</div>
       </div>
       	
       	<br>
       	<input class ="btn btn-info btn-block" type="submit" name="Submit" value="Login">

       	</fieldset>
       	<br>
       </form>			
		</div>
		
	</div>


</div>
</div>

</body>
</html>