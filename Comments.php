
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
	
<div class="Line" style="height: 10px; background: #27aae1;"></div>
<div class="container-fluid">
<div class="row">
	<div class="col-sm-2">
		<br>
		<br>
		<ul id="one" class="nav nav-pills nav-stacked">
	    <li><a href="dashboard.php">
	    	<span class="glyphicon glyphicon-th"></span>&nbsp;Dashboard</a></li>
		<li><a href="addnewpost.php">
			<span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Content</a></li>
		<li><a href="categories.php">
			<span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
		<li><a href="admins.php">
		<span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
		<li class="active"><a href="Comments.php">
		<span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
		<li><a href="Blog.php">
		<span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
		<li><a href="logout.php">
		<span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
	    </ul>

	</div>
	<div class="col-sm-10">
		<div><?php echo message();
		          echo successmessage(); ?></div>
		<h1>Unapproved Comments</h1>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<th>No.</th>
					<th>Name</th>
					<th>Date</th>
					<th>Comment</th>
					
					<th>Approve</th>
					<th>Delete Comment</th>
					<th>Details</th>
				</tr>
<?php
  $connection;
  $query="select * from comments where status='OFF' order by datetime desc";
  $execute=mysqli_query($connection,$query);
  $srno=0;
  while($datarows=mysqli_fetch_array($execute)){
$CommentId=$datarows["id"];
$Datetimeofcomment=$datarows['datetime'];
$Personname=$datarows['name'];
$Personcomment=$datarows['comment'];
$CommentedPostId=$datarows['admin_panel_id'];
$srno++;

?>
<tr>
	<td><?php echo htmlentities($srno); ?></td>
	<td style="color: #5e5eff;"><?php echo htmlentities($Personname); ?></td>
	<td><?php echo htmlentities($Datetimeofcomment); ?></td>
	<td><?php echo htmlentities($Personcomment); ?></td>
	

	<td><a href="approvecomments.php?id=<?php echo $CommentId?>"><span class="btn btn-success">Approve</span></a></td>
	<td><a href="deletecomments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-danger">Delete</span></a></td>
	<td><a href="Fullpost.php?id=<?php echo $CommentedPostId; ?>"target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
	
</tr>
<?php } ?>
			</table>
		</div>
		<h1>Approved Comments</h1>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tr>
					<th>No.</th>
					
					<th>Name</th>
					<th>Date</th>
					<th>Comment</th>
					<th>Approved By</th>
					<th>Revert Approve</th>
					<th>Delete Comment</th>
					<th>Details</th>
				</tr>
<?php
  $connection;
  $admin="pranjal";
  $query="select * from comments where status='ON' order by datetime desc";
  $execute=mysqli_query($connection,$query);
  $srno=0;
  while($datarows=mysqli_fetch_array($execute)){
  
$CommentId=$datarows["id"];
$Datetimeofcomment=$datarows['datetime'];
$Personname=$datarows['name'];
$Personcomment=$datarows['comment'];
$Approvedby=$datarows['approved_by'];
$CommentedPostId=$datarows['admin_panel_id'];
$srno++;


?>
<tr>
	<td><?php echo htmlentities($srno); ?></td>
	<td style="color: #5e5eff;"><?php echo htmlentities($Personname); ?></td>
	<td><?php echo htmlentities($Datetimeofcomment); ?></td>
	<td><?php echo htmlentities($Personcomment); ?></td>
	<td><?php echo htmlentities($Approvedby); ?></td>
	<td><a href="disapprovecomments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-warning">Unapprove</span></a></td>
	<td><a href="deletecomments.php?id=<?php echo $CommentId; ?>"><span class="btn btn-danger">Delete</span></a></td>
	<td><a href="Fullpost.php?id=<?php echo $CommentedPostId; ?>"target="_blank"><span class="btn btn-primary">Live Preview</span></a></td>
	
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