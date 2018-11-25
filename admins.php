<?php require_once("db.php"); ?>
<?php require_once("sessions.php"); ?>
<?php require_once("functions.php"); ?>
<?php 

confirm_login();

?>
<?php
$connection=mysqli_connect('localhost','root','','phpcms');
if(isset($_POST["Submit"])){
	$UserName=mysqli_real_escape_string($connection,$_POST["UserName"]);
	$Password=mysqli_real_escape_string($connection,$_POST["Password"]);
	$ConfirmPassword=mysqli_real_escape_string($connection,$_POST["ConfirmPassword"]);
	date_default_timezone_set("Asia/Kolkata");
$currenttime=time();
$datetime=strftime("%B-%d-%Y %H:%M:%S",$currenttime);
$hourminute=strftime("%H:%M",$currenttime);
$datetime;
$admin=$_SESSION["Username"];
if(empty($UserName)||empty($Password)||empty($ConfirmPassword)){
	$_SESSION["ErrorMessage"]= "All fields must be filled out";
	redirect_to("admins.php");
}
elseif(strlen($Password)<4){
$_SESSION["ErrorMessage"]= "Password must have atleast 4 characters";
	redirect_to("admins.php");	
}
elseif($Password!==$ConfirmPassword){
$_SESSION["ErrorMessage"]= "Password/Confirm Password do not match";
	redirect_to("admins.php");	
}

else{
	global $connection;
	$query="insert into registration(datetime,username,password,addedby) values('$datetime','$UserName','$Password','$admin')";
	$execute=mysqli_query($connection,$query);
	 if($execute){
   	$_SESSION["SuccessMessage"]="Admin Added Successfully :)";
   }
   else
   {
   	$_SESSION["ErrorMessage"]="Some Error :(";
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

<link rel="stylesheet" href="css/adminstyles.css">
<style>
	.fieldinfo{
		color: rgb(251,174,44);
		font-family: Bitter,Georgia,"Times New Roman",Times,seriff;
		font-size: 1.2em;
	}
</style>
</head>
<body>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-2">
		<h1></h1>
		<ul id="one" class="nav nav-pills nav-stacked">
	    <li><a href="dashboard.php">
	    	<span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
		<li><a href="addnewpost.php">
			<span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Content</a></li>
		<li><a href="categories.php">
			<span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
		<li class="active"><a href="admins.php">
		<span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
		<li><a href="Comments.php">
		<span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
		<li><a href="Blog.php">
		<span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
		<li><a href="logout.php">
		<span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
	    </ul>

	</div>
	<div class="col-sm-10">
		<h1>Manage Admin Access</h1>
		<?php echo message();
		echo successmessage(); ?>
		<div>
       <form action="admins.php" method="post">
       	<fieldset>
       		<div class="form-group">
       	<label for="UserName"><span class="fieldinfo">UserName:</span></label>
       	<input class="form-control"  type="text" name="UserName" id="UserName" placeholder="UserName">
       	</div>
       	<div class="form-group">
       	<label for="Password"><span class="fieldinfo">Password:</span></label>
       	<input class="form-control"  type="Password" name="Password" id="Password" placeholder="Password">
       	</div>
       	<div class="form-group">
       	<label for="ConfirmPassword"><span class="fieldinfo">Confirm Password:</span></label>
       	<input class="form-control"  type="Password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Retype Same Password">
       	</div>
       	<br>
       	<input class ="btn btn-success btn-block" type="submit" name="Submit" value="Add New Admin">

       	</fieldset>
       	<br>
       </form>			
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<th>Sr No.</th>
					<th>Date & Time</th>
					<th>Admin Name</th>
					<th>Added By</th>
					<th>Action</th>
				</tr>
				<?php
                global $connection;
                	$sql = "CREATE TRIGGER `TRGREP10` BEFORE INSERT ON `registration` FOR EACH ROW BEGIN\n"

    . "IF EXISTS (SELECT * FROM registration WHERE registration.username = NEW.username) THEN\n"

    . "       SIGNAL SQLSTATE \'45059\' SET MESSAGE_TEXT = \'already exists\'END IFEND";

$executeit=mysqli_query($connection,$sql);
                $viewquery="select * from registration order by datetime desc";
                $execute=mysqli_query($connection,$viewquery);
                $srno=0;
                while($datarows=mysqli_fetch_array($execute)){
                	$Id=$datarows["id"];
                	$Datetime=$datarows["datetime"];
                	$UserName=$datarows["username"];
                	$Admin=$datarows["addedby"];
                	$srno++;
                
?>
<tr>
	<td><?php echo $srno; ?></td>
	<td><?php echo $Datetime; ?></td>
	<td><?php echo $UserName; ?></td>
	<td><?php echo $Admin; ?></td>
	<td><a href="deleteadmin.php?id=<?php echo $Id; ?>"><span class="btn btn-danger"> Delete</span></a></td>




</tr>
<?php } ?>
			</table>
		</div>
	</div>


</div>
</div>
<div id="Footer">
	<hr><p>Theme by| Pranjal Pandey | &copy:2016-2020 ---All Rights Reserved.</p>
	<a style ="color:white; text-decoration;none; cursor:pointer; font-weight: bold" href="https://www.facebook.com/"></a>
</div>
<div style="height: 10px; background:#27aae1;"></div>
</body>
</html>