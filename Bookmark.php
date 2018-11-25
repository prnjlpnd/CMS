<?php require_once("db.php"); ?>
<?php require_once("sessions.php"); ?>
<?php require_once("functions.php"); ?>
<?php
if(isset($_GET["id"])){
	global $connection;
	$username=$_SESSION["Username"];
	$postidfromurl=$_GET["id"];
	$seequery="select * from admin_panel where id='$postidfromurl'";
	$execute1=mysqli_query($connection,$seequery);
	while($datarows=mysqli_fetch_array($execute1))
	{
		$postid=$datarows["id"];
		$Title=$datarows["title"];
		$Author=$datarows["author"];
	}
  
	$query="insert into bkm (postid,postname,username,author) values('$postid','$Title','$username','$Author')";
	$execute=mysqli_query($connection,$query);
	if($execute){
		$_SESSION["SuccessMessage"]="Added Successfully";
	}
	else{
		$_SESSION["ErrorMessage"]="A Problem Occured :(";
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
<link rel="stylesheet" type="text/css" href="publicstyles.css">
	<style>
	</style>
</head>
<body><div style="height: 10px; background: #27aae1;"></div>
	<nav class="navbar navbar-inverse role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			<a class="navbar-brand" href="Blog.php"><img style="margin-top: -12px" src="Images/header.png" width=200; height=30; ></a>
			</div>
			<div class="collapse navbar-collapse" id="collapse">
<ul class="nav navbar-nav">
	<li><a href="#">Home</a></li>
	<li class="active"><a href="Blog.php">Blog</a></li>
	<li><a href="#">About Us</a></li>
	<li><a href="#">Services</a></li>
	<li><a href="#">Contact Us</a></li>
	<li><a href="#">Feature</a></li>

</ul>
<form action="Blog.php" class="navbar-form navbar-right">
	<div class="form-group">
		<input type="text" class="form-control" placeholder="Search" name="Search">
    </div>
    <button class="btn btn-default" name="SearchButton">Go</button>
</form>
</div>
</div>
</nav>
	<div class="row">
		<div class="col-sm-12">
			<?php echo message();
		echo successmessage(); ?>
	</div>
</div>
<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<th>Sr No.</th>
				
					<th>Author Name</th>
					<th>Post Title</th>
					<th>Action</th>
				</tr>
				<?php
                global $connection;
                	$username=$_SESSION["Username"];
                $viewquery="select * from bkm where username='$username'";
                $execute=mysqli_query($connection,$viewquery);
                $srno=0;
                while($datarows=mysqli_fetch_array($execute)){
                	$Id=$datarows["bookid"];
                	$PostID=$datarows["postid"];
                	$PostName=$datarows["postname"];
                	$Author=$datarows["author"];
                	$srno++;
                
?>
<tr>
	<td><?php echo $srno; ?></td>
	<td><?php echo $Author; ?></td>
	<td><a href="Fullpost.php?id=<?php echo $PostID; ?>"><?php echo $PostName; ?></a></td>
	<td><a href="deletebookmark.php?id=<?php echo $Id; ?>"><span class="btn btn-danger"> Delete</span></a></td>




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