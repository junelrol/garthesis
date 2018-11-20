<?php
	$id = $_GET['id'];
	include('database_connection.php');

	if(!isset($_SESSION["type"]))
	{
	    header('location:login.php');
	}

	if($_SESSION['type'] != 'master')
	{
	    header('location:index.php');
	}

	$getplate = mysqli_query($mycon,"SELECT * FROM tbltruck WHERE TruckID='".$id."'");
	$rows = mysqli_fetch_array($getplate);
	if($rows["status"]=="available")
	{
		$newstat = "maintenance";
	}else{
		$newstat = "available";
	}
	$update = mysqli_query($mycon, "UPDATE tbltruck SET status='$newstat' WHERE TruckID='".$id."'");
	if($update)
	{
		echo '<script>alert("Truck status updated"); location.replace("addtruck.php");</script>';
	}
?>