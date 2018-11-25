<?php require_once("db.php"); ?>
<?php require_once("sessions.php"); ?>
<?php require_once("functions.php"); ?>
<?php
if(isset($_GET["id"])){
	$idfromurl=$_GET["id"];
	$connection;
	$query="DELETE FROM comments where id='$idfromurl'";
	$execute=mysqli_query($connection,$query);
	if($execute){
		$_SESSION["SuccessMessage"]="Comment Deleted Successfully";
		redirect_to("Comments.php");

	}
	else{
		$$_SESSION["ErrorMessage"]="Something Went Wrong";
		redirect_to("Comments.php");
	}
}


  ?>