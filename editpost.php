<?php require_once("db.php"); ?>
<?php require_once("sessions.php"); ?>
<?php require_once("functions.php"); ?>
<?php 

confirm_login();

?>
<?php
$connection=mysqli_connect('localhost','root','','phpcms');
if(isset($_POST["Submit"])){
	$Title=mysqli_real_escape_string($connection,$_POST["Title"]);
	$Category=mysqli_real_escape_string($connection,$_POST["Category"]);
	$Post=mysqli_real_escape_string($connection,$_POST["Post"]);

	

	date_default_timezone_set("Asia/Kolkata");
$currenttime=time();
$datetime=strftime("%B-%d-%Y %H:%M:%S",$currenttime);
$datetime;
$admin="pranjal";
$image=$_FILES["Image"]["name"];
if(empty($image))
{
  $searchqueryparameter=$_GET['Edit'];
			$connection;
            
            $query="select * from admin_panel where id='$searchqueryparameter'";
            $execute=mysqli_query($connection,$query);
            while($datarows=mysqli_fetch_array($execute))
            	$image=$datarows['image'];
}

$Target="Upload/".basename($image);


if(empty($Title)){
	$_SESSION["ErrorMessage"]= "Title can't be empty";
	redirect_to("addnewpost.php");
}
else{
	global $connection;
	$editfromurl=$_GET['Edit'];
	$query="update admin_panel set datetime='$datetime',title='$Title',category='$Category',author='$admin',image='$image',post='$Post'
	where id='$editfromurl' ";
	$execute=mysqli_query($connection,$query);
	move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
	if($execute)
	{
		$_SESSION["SuccessMessage"]="Post updated Succesfully";
		redirect_to("dashboard.php");
	}else{
		$_SESSION["ErrorMessage"]="Something went wrong";
		redirect_to("dashboard.php");
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
		<li class="active"><a href="addnewpost.php">
			<span class="glyphicon glyphicon-list-alt"></span>&nbsp;Add New Content</a></li>
		<li><a href="categories.php">
			<span class="glyphicon glyphicon-tags"></span>&nbsp;Categories</a></li>
		<li><a href="#">
		<span class="glyphicon glyphicon-user"></span>&nbsp;Manage Admins</a></li>
		<li><a href="#">
		<span class="glyphicon glyphicon-comment"></span>&nbsp;Comments</a></li>
		<li><a href="#">
		<span class="glyphicon glyphicon-equalizer"></span>&nbsp;Live Blog</a></li>
		<li><a href="#">
		<span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
	    </ul>

	</div>
	<div class="col-sm-10">
		<h1>Update Post</h1>
		<?php echo message();
		echo successmessage(); ?>
		<div>
			<?php 
			$searchqueryparameter=$_GET['Edit'];
			$connection;
            
            $query="select * from admin_panel where id='$searchqueryparameter'";
            $execute=mysqli_query($connection,$query);
            while($datarows=mysqli_fetch_array($execute)){
            	$Titletobeupdated=$datarows['title'];
            	$Categorytobeupdated=$datarows['category'];
            	$Imagetobeupdated=$datarows['image'];
            	$Posttobeupdated=$datarows['post'];

            }


			?>
       <form action="editpost.php?Edit=<?php echo $searchqueryparameter;?>" method="post" enctype="multipart/form-data">

       	<fieldset>
       		<div class="form-group">
       	<label for="title"><span class="fieldinfo">Title:</span></label>
       	<input value="<?php echo $Titletobeupdated; ?>" class="form-control"  type="text" name="Title" id="title" placeholder="Title">
       	</div>
       	<div class="form-group">
       		<span class="fieldinfo">Existing Category:</span>
       		<?php echo $Categorytobeupdated; ?><br>
       	<label for="categoryselect"><span class="fieldinfo">Category:</span></label>
       	<select class="form-control" id="categoryselect" name="Category">
       		<?php
                global $connection;
                $viewquery="select * from category order by datetime desc";
                $execute=mysqli_query($connection,$viewquery);
                
                while($datarows=mysqli_fetch_array($execute)){
                	$Id=$datarows["id"];
                    $CategoryName=$datarows["name"];
               ?>
               <option><?php echo $CategoryName; ?></option>
               <?php } ?>



       	</select>
       </div>
       <div class="form-group">
       		<span class="fieldinfo">Existing Image:</span>
       	<img src="Upload/<?php echo $Imagetobeupdated; ?>" width=170px; height=70px;><br>
       	<label for="imageselect"><span class="fieldinfo">Select Image:</span></label>
       	<input type="File" class="form-control" name="Image" id="imageselect">
       </div>
       	<br>


  <div class="form-group">
       	<label for="postarea"><span class="fieldinfo">Post:</span></label>
       	<textarea class="form-control" name="Post" id="postarea">
       		<?php echo $Posttobeupdated; ?>
       	</textarea>
       </div>
       <br>
       	       	<input class ="btn btn-success btn-block" type="submit" name="Submit" value="Update Post">
       	</fieldset>
       	<br>
       </form>			
		</div>
		
				<?php
                global $connection;
                $viewquery="select * from category order by datetime desc";
                $execute=mysqli_query($connection,$viewquery);
                $srno=0;
                while($datarows=mysqli_fetch_array($execute)){
                	$Id=$datarows["id"];
                	$Datetime=$datarows["datetime"];
                	$Name=$datarows["name"];
                	$CreatorName=$datarows["creatorname"];
                	$srno++;
                }
                
?>

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