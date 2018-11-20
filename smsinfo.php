<?php

	include('database_connection.php');
	include('function.php');

	if(!isset($_SESSION["type"]))
	{
	    header('location:login.php');
	}

	if($_SESSION['type'] != 'master')
	{
	    header('location:index.php');
	}

	include('header.php');

	$getQuery = mysqli_query($mycon,"SELECT * FROM tblsmsinfo WHERE smsid=1");
	$getRow = mysqli_fetch_array($getQuery);
	$getcallback = $getRow['call_back'];
	$getDevice = $getRow['iddevice'];

	if(isset($_POST['btn_save']))
	{
		$nospacescallback = str_replace(' ', '', $_POST['call_back']);
		$query = mysqli_query($mycon, "UPDATE tblsmsinfo SET iddevice='".$_POST['deviceid']."', call_back='".$nospacescallback."' WHERE smsid=1") or die(mysqli_error($mycon));
		if($query)
		echo '<script>alert("SMS information updated"); location.replace("smsinfo.php");</script>';
	}

?>

<div class="col-md-offset-3 col-md-6">
	<form method="post">
		<label for="deviceid">Device Id</label><input type="text" id="deviceid" name="deviceid" class="form-control" value="<?php echo $getDevice; ?>">
		<label for="call_back">Call Back code</label><textarea id="call_back" name="call_back" class="form-control" >
			<?php echo $getcallback; ?>
		</textarea>
		<br />
		<input type="submit" name="btn_save" class="btn btn-primary" style="width:100%" value="Save">
	</form>
</div>