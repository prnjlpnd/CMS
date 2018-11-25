
<?php require_once("db.php"); ?>
<?php require_once("sessions.php"); ?>
<?php require_once("functions.php"); ?>
<?php 

confirm_login();

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<link rel="stylesheet" href="adminstyles.css">
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
	<li class="active"><a href="dashboard.php" target="_blank">Home</a></li>
	<li><a href="Blog.php" target="_blank">Blog</a></li>
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
<div class="Line" style="height: 10px; background: #27aae1;"></div>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-2">
		<br>
		<br>
		<ul id="one" class="nav nav-pills nav-stacked">
	    <li class="active"><a href="dashboard.php">
	    	<span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
		<li><a href="addnewpost.php">
			<span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Content</a></li>
		<li><a href="categories.php">
			<span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
		<li><a href="admins.php">
		<span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
		<li><a href="Comments.php">
		<span class="glyphicon glyphicon-comment"></span>&nbsp;Comments
		<?php
		$connection;
		$querytotal="select count(*) from comments where status='OFF'";
		$executetotal=mysqli_query($connection,$querytotal);
		$rowstotal=mysqli_fetch_array($executetotal);
		$totaltotal=array_shift($rowstotal);
		if($totaltotal>0){ 
		?>
		<span class="label pull-right label-warning">
        <?php echo $totaltotal;?>
</span>
<?php } ?>
</a></li>
<li><a href="Bookmark.php">
<span class="glyphicon glyphicon-bookmark"></span>&nbsp;Bookmarks
<?php
		$connection;
		$username=$_SESSION["Username"];
		$querytotal="select count(*) from bkm where username='$username'";
		$executetotal=mysqli_query($connection,$querytotal);
		$rowstotal=mysqli_fetch_array($executetotal);
		$totaltotal=array_shift($rowstotal);
		if($totaltotal>0){ 
		?>
		<span class="label pull-right label-warning">
        <?php echo $totaltotal;?>
</span>
<?php } ?>
</a></li>
		<li><a href="Blog.php">
		<span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
		<li><a href="logout.php">
		<span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
	    </ul>

	</div>
	<div class="col-sm-10">
		<div><?php echo message();
		          echo successmessage(); ?></div>
		<h1>Admin Dashboard</h1>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<th>No.</th>
					<th>Post Title</th>
					<th>Date and Time</th>
					<th>Author</th>
					<th>Category</th>
					<th>Banner</th>
					<th>Comments</th>
					<th>Actions</th>
					<th>Details</th>
				</tr>
				<?php
				global $connection;
				$viewquery="select * from admin_panel order by id desc;";
				$execute=mysqli_query($connection,$viewquery);
				$srno=0;
				while($datarows=mysqli_fetch_array($execute)){
					$Id=$datarows["id"];
					$Datetime=$datarows["datetime"];
					$Title=$datarows["title"];
					$Category=$datarows["category"];
					$Admin=$datarows["author"];
					$Image=$datarows["image"];
					$Post=$datarows["post"];
					$srno++;
					?>
<tr>
	<td><?php echo $srno; ?></td>
	<td style="color: #5e5eff;"><?php
      if(strlen($Title)>20){
      	$Title=substr($Title,0,20).'..';}
      
	 echo $Title; ?></td>
	<td><?php 
  if(strlen($Datetime)>11){
      	$Datetime=substr($Datetime,0,11).'..';}
      

	echo $Datetime; ?></td>
	<td><?php 
 if(strlen($Admin)>6){
      	$Admin=substr($Admin,0,6).'..';}
      

	echo $Admin; ?></td>
		<td><?php
if(strlen($Category)>8){
      	$Category=substr($Category,0,8).'..';}
      

		 echo $Category; ?></td>
	<td><img src="Upload/<?php echo $Image; ?>" width="170" height="50px"></td>
	<td>
		<?php
		$connection;
		$queryapproved="select count(*) from comments where admin_panel_id='$Id' AND status='ON'";
		$executequery=mysqli_query($connection,$queryapproved);
		$rowsapproved=mysqli_fetch_array($executequery);
		$totalapproved=array_shift($rowsapproved);
		if($totalapproved>0){ 
		?>
		<span class="label pull-right label-success">
        <?php echo $totalapproved;?>
</span>

<?php } ?>

<?php
		$connection;
		$queryunapproved="select count(*) from comments where admin_panel_id='$Id' AND status='OFF'";
		$executequery=mysqli_query($connection,$queryunapproved);
		$rowsunapproved=mysqli_fetch_array($executequery);
		$totalunapproved=array_shift($rowsunapproved);
		if($totalunapproved>0){ 
		?>
		<span class="label label-danger">
        <?php echo $totalunapproved;?>
</span>

<?php } ?>


	








	</td>
	<td>
		<a href="editpost.php?Edit=<?php echo $Id; ?>"><span class="btn btn-warning">Edit</span></a> <a href="deletepost.php?Delete=<?php echo $Id; ?>"><span class="btn btn-danger"> Delete</span></a></td>
	<td><a href="Fullpost.php?id=<?php echo $Id; ?>" target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>

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