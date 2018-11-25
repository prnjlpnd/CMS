<?php require_once("db.php"); ?>
<?php require_once("sessions.php"); ?>
<?php require_once("functions.php"); ?>
<?php
if(isset($_GET["id"])){
	$idfromurl=$_GET["id"];
	$connection;
	$query="DELETE FROM category where id='$idfromurl'";
	$execute=mysqli_query($connection,$query);
	if($execute){
		$_SESSION["SuccessMessage"]="Category Deleted Successfully";
		redirect_to("categories.php");

	}
	else{
		$$_SESSION["ErrorMessage"]="Something Went Wrong";
		redirect_to("categories.php");
	}
}


  ?>