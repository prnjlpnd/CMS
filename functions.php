<?php require_once("db.php"); ?>
<?php require_once("sessions.php"); ?>
<?php
function redirect_to($new_location){
	header("Location:".$new_location);
	exit;
}
function login_attempt($username,$password){
global $connection;
$query="select * from registration where username='$username' and password='$password'";
$execute=mysqli_query($connection,$query);
if($admin=mysqli_fetch_assoc($execute))
{
	return $admin;
}
else{
	return null;
}
}
function login(){
	if(isset($_SESSION["User_Id"])){
		return true;
	}
}
function confirm_login(){
	if(!login()){
		$_SESSION["ErrorMessage"]="Login Required";
		redirect_to("login.php");
	}
}

 ?>