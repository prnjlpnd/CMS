<?php require_once("db.php"); ?>
<?php require_once("sessions.php"); ?>
<?php require_once("functions.php"); ?>
<?php
if(isset($_POST["Submit"])){
	$Name=mysqli_real_escape_string($connection,$_POST["Name"]);
	$Email=mysqli_real_escape_string($connection,$_POST["Email"]);
	$Comment=mysqli_real_escape_string($connection,$_POST["Comment"]);
date_default_timezone_set("Asia/Kolkata");
$currenttime=time();
$PostId=$_GET["id"];
$DateTime=strftime("%B-%d-%Y %H:%M:%S",$currenttime);
$DateTime;


if(empty($Name) || empty($Email) || empty($Comment)){
	$_SESSION["ErrorMessage"]= "All fields are required";
	
}
else{
	global $connection;
	$postidfromurl=$_GET["id"];
	$query="insert into comments(datetime,name,email,comment,approved_by,status,admin_panel_id) values ('$DateTime','$Name','$Email','$Comment','Pending','OFF',$postidfromurl)";
	$execute=mysqli_query($connection,$query);
	
	if($execute)
	{
		$_SESSION["SuccessMessage"]="Comment submitted Succesfully";
		
		 redirect_to("Fullpost.php?id={$PostId}");
		
		
	}else{
		$_SESSION["ErrorMessage"]="Something went wrong";
		
		redirect_to("Fullpost.php?id=$PostId");
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
<link rel="stylesheet" type="text/css" href="publicstyles.css">
<style>
	.fieldinfo{
		color: rgb(251,174,44);
		font-family: Bitter,Georgia,"Times New Roman",Times,seriff;
		font-size: 1.2em;
	}
	.commentblock{
		background-color: #f6f7f9;
	}
	.comment-info{
		color:#365899;
		font-family: sans-serif;
		font-weight: bold;
		font-size: 1.1em;
		padding-top: 10px;

	}
	.comment{
		margin-top: -2px;
		padding-bottom: 10px;
		font-size: 1.1em;

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
			<a class="navbar-brand" href="Blog.php"><img style="margin-top: -12px" src="Images/images5.jpg" width=200; height=50; ></a>
			</div>
			<div class="collapse navbar-collapse" id="collapse">
<ul class="nav navbar-nav">
	<li><a href="dashboard.php">Home</a></li>
	<li class="active"><a href="Blog.php">Blog</a></li>
	<li><a href="aboutus.html">About Us</a></li>
	<li><a href="Services.html">Services</a></li>
	<li><a href="contact.html">Contact Us</a></li>


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
<div style="height: 10px; background: #27aae1; margin-top: -20px;"></div>
<div class="container asd">
	<div class="blog-header">

		<h1>The Complete Responsive CMS Blog </h1>
		<p class="lead">Using PHP By Pranjal Pandey</p>
	</div>
	<div class="row">
		<div class="col-sm-8">
			<?php echo message();
		echo successmessage(); ?>
			<?php
			global $connection;
			if(isset($_GET["SearchButton"])){
				$Search=$_GET["Search"];
				$viewquery="select * from admin_panel where 
				datetime like '%$Search%' or title like '%$Search%' or category like '%$Search%' or post like '%$Search%'";
			}else{
				
				
				$postidfromurl=$_GET["id"];
             $viewquery="select * from admin_panel where id='$postidfromurl' order by datetime desc";}
             $execute=mysqli_query($connection,$viewquery);
             while($datarows=mysqli_fetch_array($execute))
             {
             $Postid=$datarows["id"];
             $Datetime=$datarows["datetime"];
             $Title=$datarows["title"];
             $Category=$datarows["category"];
             $Author=$datarows["author"];
             $Image=$datarows["image"];
             $Post=$datarows["post"];
         
?>
<div class="blogpost thumbnail">
	<img class="img-responsive img-rounded" src="Upload/<?php echo $Image;?> ">
<div class="caption">
	<h1 id="heading"><?php echo htmlentities($Title); ?></h1>
	<p class="description">Category:<?php echo htmlentities($Category); ?> |Published On- <?php echo htmlentities($Datetime); ?></p>
	<?php
		$connection;
		$queryapproved="select count(*) from comments where admin_panel_id='$Postid' AND status='ON'";
		$executequery=mysqli_query($connection,$queryapproved);
		$rowsapproved=mysqli_fetch_array($executequery);
		$totalapproved=array_shift($rowsapproved);
		
		?>
		<span class="badge pull-right">
        Comments:<?php echo $totalapproved;?>
</span>
	<p class="post"><?php echo nl2br($Post); ?></p>
</div>

</div>
<?php } ?>

<br><br>
<br><br>
<a href="Bookmark.php?id=<?php echo $Postid; ?>">
<button name="btnbookmark" class="btn btn-warning">
<span class="glyphicon glyphicon-bookmark"></span>&nbsp;Bookmark This Post </button>
</a>
<br><br>
<br><br>
<span class="fieldinfo">Share your thoughts about this post</span>
<br>
<span class="fieldinfo">Comments</span>
<?php
$connection;
$postidforcomments=$_GET["id"];
$queryextract="select * from comments where admin_panel_id='$postidforcomments' AND status='ON'";
$execute=mysqli_query($connection,$queryextract);
while($datarows=mysqli_fetch_array($execute)){
	$CommentDate=$datarows["datetime"];
	$CommenterName=$datarows["name"];
	$Commentbyusers=$datarows["comment"];
	?>
	<div class="commentblock">
		<img style="margin-left: 10px; margin-top: 10px;" class="pull-left" src="Images/comment-png-2.png" width=70px; height=70px;>
		<p style="margin-left: 90px;" class="comment-info"><?php echo $CommenterName; ?></p>
		<p style="margin-left: 90px;" class="description"><?php echo $CommentDate; ?></p>
		<p style="margin-left: 90px;" class="comment"><?php echo nl2br($Commentbyusers); ?></p>
	</div>
<?php } ?>

<div>
	<?php $PostId=$_GET["id"]; ?>
       <form action="Fullpost.php?id=<?php echo $PostId; ?>" method="post">
       
       	<fieldset>
       		<div class="form-group">
       	<label for="Name"><span class="fieldinfo">Name:</span></label>
       	<input class="form-control"  type="text" name="Name" id="Name" placeholder="Name">
       	</div>
       	<div class="form-group">
       	<label for="Email"><span class="fieldinfo">Email:</span></label>
       	<input class="form-control"  type="email" name="Email" id="Email" placeholder="Email">
       	</div>
       	<br>
       	<hr>
       
    
  <div class="form-group">
       	<label for="commentarea"><span class="fieldinfo">Comment:</span></label>
       	<textarea class="form-control" name="Comment" id="commentarea"></textarea>
       </div>
       <br>
       	       	<input class ="btn btn-primary" type="submit" name="Submit" value="Submit">
       	</fieldset>
       	<br>
       </form>			
		</div>
		</div>
		<div class="col-sm-offset-1 col-sm-3">
			<h2>About Me</h2>
			<img class="img-responsive img-circle imageicon" src="Images/blog.jpg">
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title">Categories</h2>
				</div>
				<div class="panel-body">
				<?php 
                     global $connection;
                     $viewquery="select * from category";
                     $execute=mysqli_query($connection,$viewquery);
                     while($datarows=mysqli_fetch_array($execute)){
                     	$id=$datarows['id'];
                     	$category=$datarows['name'];
                     
                   ?>
                   <a href="Blog.php?category=<?php echo $category ?>">
                   <span id="heading"><?php echo $category; ?></span>
               </a>
                   <br>
               <?php } ?>
				</div>
				<div class="panel-footer">

				</div>
			</div>
		<div class="panel panel-primary">
				<div class="panel-heading">
					<h2 class="panel-title">Recent Posts</h2>
				</div>
				<div class="panel-body">
					<?php 
                     global $connection;
                      $viewquery="select * from admin_panel order by datetime desc limit 0,5";
                      $execute=mysqli_query($connection,$viewquery);
                      while ($datarows=mysqli_fetch_array($execute)) {
                      	$id=$datarows['id'];
                      	$title=$datarows['title'];
                      	$datetime=$datarows['datetime'];
                      	$image=$datarows['image'];
                      
                      


					 ?>
					 <a href="Fullpost.php?id=<?php echo $id ?>">
                   <span id="heading"><?php echo $title; ?></span>
               </a>
                   <br>
					<?php } ?>
				</div>
				<div class="panel-footer">

				</div>
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
