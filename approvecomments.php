<?php require_once("db.php"); ?>
<?php require_once("sessions.php"); ?>
<?php require_once("functions.php"); ?>
<?php
if(isset($_GET["id"])){
	$idfromurl=$_GET["id"];
	$connection;
	$admin=$_SESSION["Username"];
	$query="UPDATE comments SET status='ON',approved_by='$admin' where id='$idfromurl'";
	$execute=mysqli_query($connection,$query);
	if($execute){
		$_SESSION["SuccessMessage"]="Comment Approved Successfully";
		redirect_to("Comments.php");

	}
	else{
		$$_SESSION["ErrorMessage"]="Something Went Wrong";
		redirect_to("Comments.php");
	}
}


  ?>